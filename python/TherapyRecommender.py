import pandas as pd
from Visit import Visit
import time
import numpy as np
from functools import reduce
import pickle

class TherapyRecommender:
    
    
    
    def __init__(self, vdb, config_recom):                
        ### variables
        # recommender settings
        self.impute         = config_recom["impute"]
        self.extended       = config_recom["extended"]
        self.prefilter      = config_recom["prefilter"]
        self.affinity_thr   = config_recom["affinity_thr"]
        self.rules          = config_recom["rules"]
        
        # feature settings
            # sortation of feature sections for buildDataFrame (->settings!)
        self.sortby = {"comorbidities":"comorbidities: Komorbidität","therapyprevious":"therapyprevious: Therapie","therapycurrent":"therapycurrent: Therapie"}
            # delta features to calculate from tbldata for getDelta (->settings!)
        self.Delta = {"from":["status: PasiScore"],"calc":["therapycurrent: DeltaPasi"]}
            # measures of therapy outcome for calcAffinity (->settings!)
        self.outcome = {}
        self.outcome["current"] = {"primary":"therapycurrent: Therapie","measures":["therapycurrent: Wirksamkeit","therapycurrent: UAWja","therapycurrent: DeltaPasi"]}
        self.outcome["hist"] = {"primary":"therapyprevious: Therapie","measures":["therapyprevious: Wirksamkeit","therapyprevious: UAWJa"]}
        # feature statistics
        self.ranges         = pd.DataFrame()
        self.ranges_adj     = pd.DataFrame()
        self.moct           = pd.DataFrame()
        self.moct_adj       = pd.DataFrame()                
        # unadjusted & unmodified training data
        self.trainData      = pd.DataFrame()
        self.trainTypes     = pd.DataFrame()
        self.trainIDs       = {"visitIDs":[],"patientIDs":[]}
        self.previousIDs    = {}
        self.trainAffinity  = pd.DataFrame()        
        # unmodified visit data
        self.currentData        = pd.DataFrame()
        self.currentTypes       = pd.DataFrame()
        self.currentIDs         = {"visitIDs":[],"patientID":[]}
        self.currentAffinity    = pd.DataFrame()
        self.currentRecom       = pd.DataFrame()
        
        ### functions
        # get statistics of database
        s = time.time()
        self.getFeatureStats(vdb)
        e = time.time()
        print("getFeatureStats:", e-s)
        # load all training data
        s = time.time()
        self.loadTrainingData(vdb)
        e = time.time()
        print("loadTrainingData:", e-s)
        # update and adjust statistics
        s = time.time()
        self.adjustFeatureStats()
        e = time.time()
        print("adjustFeatureRange:", e-s)


        
    def doRecommendation(self, vdb, vis):        
        ### load data of current visit
        s = time.time()
        currentData = self.loadCurrentData(vdb, vis)
        e = time.time()
        print("loadCurrentData:", e-s)
        ### match training data to current data
        s = time.time()
        trainData, trainIDs = self.matchTrainingData()
        e = time.time()
        print("matchTrainingData:", e-s)
        ### prepare features for calculation (currently: feature normalization)
        s = time.time()
        currentData, trainData = self.prepareFeatures(currentData, trainData)
        e = time.time()
        print("prepareFeatures:", e-s)
        ### find k-nearest neighbors of current visit
        s = time.time()
        self.currentkNN = self.calcKNN(currentData, trainData)
        e = time.time()
        print("calcKNN:", e-s)
        ### estimate affinities of current visits based on kNN 
        s = time.time()
        self.currentRecom, currentRecom_thr = self.calcRecom(self.currentkNN)
        e = time.time()
        print("calcRecom:", e-s)
        ### print recommendations above threshold
        if not currentRecom_thr.empty:
            for idx, val in currentRecom_thr.iteritems():
                print(idx, "=", val)



    def getFeatureStats(self, vdb):
        vis_tmp = Visit()
        vis_tmp.loadVisitData(vdb)
        data = pd.DataFrame.from_dict(vis_tmp.attributes, orient='index')
        # feature ranges
        self.ranges["min"]  = data.min(axis=1, skipna=True)
        self.ranges["max"]  = data.max(axis=1, skipna=True)
        # measures of central tendency (moct)
        self.moct["mode"]   = data.mode(axis=1)[0] #only return first column (could be more than one mode)
        self.moct["median"] = data.median(axis=1, skipna=True)
        self.moct["mean"]   = data.mean(axis=1, skipna=True)


    def adjustFeatureStats(self):
        ### append stats of calculated features 
        for newfeat in self.Delta["calc"]:
            idx_drop = [idx for idx in self.trainData.index if newfeat not in idx]
            df = self.trainData.drop(idx_drop)
            self.ranges.loc[newfeat, "max"] = df.max(skipna=True).max(skipna=True)
            self.ranges.loc[newfeat, "min"] = df.min(skipna=True).min(skipna=True)
            self.moct.loc[newfeat,"mode"]   = df.mode(axis=1)[0].mode()[0] 
            self.moct.loc[newfeat,"median"] = df.median(axis=1, skipna=True).median(axis=0, skipna=True)
            self.moct.loc[newfeat,"mean"] = df.mean(axis=1, skipna=True).mean(axis=0, skipna=True)
        
        ### adjust stats to current structure of dataframe 
        for index in self.trainData.index:
            for index_rng in self.ranges.index:
                if index_rng in index:
                    self.ranges_adj.loc[index, 'min'] = self.ranges.loc[index_rng, 'min']
                    self.ranges_adj.loc[index, 'max'] = self.ranges.loc[index_rng, 'max']
                    self.moct_adj.loc[index, "mode"]    = self.moct.loc[index_rng, "mode"]
                    self.moct_adj.loc[index, "median"]  = self.moct.loc[index_rng, "median"]
                    self.moct_adj.loc[index, "mean"]    = self.moct.loc[index_rng, "mean"]
                    break
        
 
       
    def loadCurrentData(self, vdb, vis):        
        ### load info & data of current visit
        s = time.time()
        vis.loadVisitInfo(vdb)
        vis.loadVisitData(vdb, True)
        self.currentIDs["visitIDs"] = [vis.visitID] + vis.preVisits + vis.nextVisits
        self.currentIDs["patientID"] = vis.patientID
        
        ### load info & data of all previous visits of current patient
        previous = []
        for idx, entry in enumerate(vis.preVisits):
            previous.append(Visit())
            previous[idx].visitID = entry
            previous[idx].loadVisitInfo(vdb)
            previous[idx].loadVisitData(vdb, True)
        e = time.time()
        print("loadfromsql:", e-s)
                       
        ### get delta(Pasi) of current visit
        s = time.time()
        for i, _ in enumerate(self.Delta["from"]):
            from_ = self.Delta["from"][i]
            calc_ = self.Delta["calc"][i]
            if previous:
                self.getDelta(vis, previous[-1], from_, calc_)
            else:
                self.getDelta(vis, None, from_, calc_)
        e = time.time()
        print("getdeltapasi:", e-s)
        
        ### build dataframe
        s = time.time()
        self.currentData, self.currentTypes = self.buildDataFrame2(vis.attributes, vis.typeAttributes)              
        e = time.time()
        print("builddataframe:", e-s)
        
        ### get current affinities
        s = time.time()
        self.currentAffinity = self.calcAffinity(self.currentData)                
        # get affinities of previous visits
        if previous:            
            for num, preVisit in enumerate(previous):
                # delta(Pasi)    
                for i, _ in enumerate(self.Delta["from"]):
                    from_ = self.Delta["from"][i]
                    calc_ = self.Delta["calc"][i]
                    if num > 0:
                        self.getDelta(preVisit, previous[num-1], from_, calc_)
                    else:
                        self.getDelta(preVisit, None, from_, calc_)
                # dataframe
                df, _ = self.buildDataFrame2(preVisit.attributes, preVisit.typeAttributes)
                # affinities
                aff = self.calcAffinity(df)
                # merge previous affinities
                if num > 0:
                    previousAffinity = aff.mask(aff.isnull(), other=previousAffinity, axis=0)
                else:
                    previousAffinity = aff
            # merge with current affinities
            self.currentAffinity = self.currentAffinity.mask(self.currentAffinity.isnull(), other=previousAffinity, axis=0)        
        # fill NaN
        self.currentAffinity.fillna(0, inplace=True)
        e = time.time()
        print("getcurrentaffinity:", e-s)                                    
        
        return self.currentData
    
 
    
    def getDelta(self, vis, vis_prev, from_, calc_):
        ### calculate feature value
        # if previous visit exists
        if vis_prev:
            # get features
            current_ = vis.attributes[from_][0]
            prev_ = vis_prev.attributes[from_][0]
            # calculate delta(features)
            if current_ != None and prev_ != None:
                delta_ = current_ - prev_
            else:
                delta_ = None
        else:
            delta_ = None
        
        ### append feature
        vis.attributes[calc_] = []
        # if feature is part of sorted section
        if any(ind in calc_ for ind in self.sortby.keys()):
            for ind in self.sortby.keys():
                    if ind in calc_:
                        # get length of primary feature
                        numrep = len(vis.attributes[self.sortby[ind]])
        else:
            numrep = 1
        for i in range(numrep):
            # append for length of primary feature    
            vis.attributes[calc_].append(delta_)
        vis.typeAttributes[calc_] = 4
        
  
    
    def loadTrainingData(self, vdb):       
        ### load training IDs from db
        vdb.cur.execute("SELECT tblvisite.IDVisite, tblvisite.Patient FROM tblvisite")        
        for entry in vdb.cur.fetchall(): 
            self.trainIDs["visitIDs"].append(entry[0])
            self.trainIDs["patientIDs"].append(entry[1])
            
#        ### load training data from db
#        trainData_tmp = []
#        trainTypes_tmp = []
#        # for all visits
#        for ID in self.trainIDs["visitIDs"]:
#            ### load visit
#            vis_tmp = Visit()
#            vis_tmp.visitID = ID
#            #vis_tmp.visitID = self.trainIDs["visitIDs"][loc]
#            #vis_tmp.patientID = self.trainIDs["patientIDs"][loc]
#            vis_tmp.loadVisitInfo(vdb)
#            self.previousIDs[str(ID)] = vis_tmp.preVisits
#            vis_tmp.loadVisitData(vdb, True)
#
#            ### get delta(Pasi) of visit
#            if vis_tmp.preVisits:
#                vis_prev_tmp = Visit()
#                vis_prev_tmp.visitID = vis_tmp.preVisits[-1]
#                vis_prev_tmp.patientID = vis_tmp.patientID
#                vis_prev_tmp.loadVisitData(vdb, True)
#            for i, _ in enumerate(self.Delta["from"]):
#                from_ = self.Delta["from"][i]
#                calc_ = self.Delta["calc"][i]
#                if vis_tmp.preVisits:
#                    self.getDelta(vis_tmp, vis_prev_tmp, from_, calc_)
#                else:
#                    self.getDelta(vis_tmp, None, from_, calc_)
#           
#            # build dataframe
#            try:
#                data_tmp, types_tmp = self.buildDataFrame2(vis_tmp.attributes, vis_tmp.typeAttributes)
#            except:
#                print(ID)
#            # collect dataframes
#            trainData_tmp.append(data_tmp)
#            trainTypes_tmp.append(types_tmp)
#       
#        ### concatenate dataframes   
#        self.trainData = pd.concat(trainData_tmp, axis=1, ignore_index=True)
#        self.trainData.columns = self.trainIDs["visitIDs"]
#        #self.trainTypes = pd.concat(trainTypes, axis=1, ignore_index=True)
#        #self.trainTypes.columns = self.trainIDs["visitIDs"]
#        self.trainTypes = trainTypes_tmp[0]
        
        # if buildDataFrame: trainData&Types / if buildDataFrame2: trainData2&Types2            
        self.trainData = pd.read_pickle('data/trainData2.pkl')
        self.trainTypes = pd.read_pickle('data/trainTypes2.pkl')
        pkl_file = open('data/previousIDs.pkl', 'rb')
        self.previousIDs = pickle.load(pkl_file)
        pkl_file.close()
        
        ### get training affinities
        self.trainAffinity = self.calcAffinity(self.trainData)
        # merge affinities of current and previous visits
        for col in self.trainAffinity:
            if self.previousIDs[str(col)]:
                for num, prevID in enumerate(self.previousIDs[str(col)]):
                    aff = self.trainAffinity[prevID]
                    if num > 0:
                        previousAffinity = aff.mask(aff.isnull(), other=previousAffinity, axis=0)
                    else:
                        previousAffinity = aff
                self.trainAffinity[col] = self.trainAffinity[col].mask(self.trainAffinity[col].isnull(), other=previousAffinity, axis=0)
        # fill NaN
        self.trainAffinity.fillna(0, inplace=True)
            

#    def buildDataFrame(self, data, types):
#        #sortby = {"comorbidities":"comorbidities: Komorbidität","therapyprevious":"therapyprevious: Therapie","therapycurrent":"therapycurrent: Therapie"}
#        data_tmp = pd.DataFrame()
#        types_tmp = pd.DataFrame()
#        # for each feature
#        for key in data:
#            ### if feature needs to be sorted
#            if any(ind in key for ind in self.sortby.keys()):
#                # get indicator
#                for ind in self.sortby.keys():
#                    if ind in key:
#                        # get dominant feature
#                        sort = data[self.sortby[ind]]                    
#                        
#                        ### expand feature by dominant feature
#                        for i in range(int(self.ranges.loc[self.sortby[ind], 'max'])):
#                            # if ordinal/interval/ratio
#                            if types[key] == 3 or types[key] == 4:
#                                # default = None to exclude from similarity computation
#                                data_tmp.loc[key + "_" + str(i+1), 0] = None
#                                types_tmp.loc[key + "_" + str(i+1), 0] = types[key]
#                            # if nominal and not dominant feature    
#                            elif types[key] == 2 and key != self.sortby[ind]:
#                                # additionally expand by current feature
#                                for j in range(int(self.ranges.loc[key, 'max'])):
#                                    data_tmp.loc[key + "_" + str(i+1) + "_" + str(j+1), 0] = None
#                                    types_tmp.loc[key + "_" + str(i+1) + "_" + str(j+1), 0] = 1
#                            # if dominant feature (always nominal)      
#                            elif types[key] == 2 and key == self.sortby[ind]:
#                                data_tmp.loc[key + "_" + str(i+1), 0] = 0
#                                types_tmp.loc[key + "_" + str(i+1), 0] = 1        
#                            # if dichotomous        
#                            elif types[key] == 1 or key == self.sortby[ind]:
#                                data_tmp.loc[key + "_" + str(i+1), 0] = None
#                                types_tmp.loc[key + "_" + str(i+1), 0] = 1                            
#                                
#                        ### set feature values
#                        if all(sort):
#                            for i, val in enumerate(sort):
#                                if data[key][i] is not None:
#                                    # if dichotomous/ordinal/interval/ratio
#                                    if types[key] == 1 or types[key] == 3 or types[key] == 4:
#                                        data_tmp.loc[key + "_" + str(val), 0] = data[key][i] 
#                                    # if nominal and not dominant feature   
#                                    elif types[key] == 2 and key != self.sortby[ind]:
#                                        for j in range(int(self.ranges.loc[key, 'max'])):
#                                            data_tmp.loc[key + "_" + str(val) + "_" + str(j+1), 0] = 0    
#                                        data_tmp.loc[key + "_" + str(val) + "_" + str(data[key][i]), 0] = 1
#                                    # if dominant feature (always nominal)    
#                                    elif types[key] == 2 and key == self.sortby[ind]:
#                                        data_tmp.loc[key + "_" + str(val), 0] = 1
#                                    
#            ### else
#            else:
#                # if dichotomous/ordinal/interval/ratio: adopt value
#                if types[key] == 1 or types[key] == 3 or types[key] == 4:
#                    data_tmp.loc[key, 0] = data[key][0]
#                    types_tmp.loc[key, 0] = types[key]
#                # if nominal: transform to dichotomous    
#                elif types[key] == 2:
#                    # expand feature
#                    for i in range(int(self.ranges.loc[key, 'max'])):
#                        data_tmp.loc[key + "_" + str(i+1), 0] = 0
#                        types_tmp.loc[key + "_" + str(i+1), 0] = 1
#                    # set feature value
#                    if data[key][0] is not None:
#                        data_tmp.loc[key + "_" + str(data[key][0]), 0] = 1
#                        
#        return data_tmp, types_tmp     
        
        
    
    def buildDataFrame2(self, data, types):
        
        def expandNominal(data):
            data_new = []
            types_new = []
            for idx in data.index:                
                index_new = []
                # build new index
                for i in range(int(self.ranges.loc[idx, 'max'])):
                    index_new.append(idx + '_' + str(i+1))
                # transform nominal to dichotmous
                if not pd.isnull(data.loc[idx,0]): 
                    data_tmp = pd.DataFrame(0, index=range(int(self.ranges.loc[idx, 'max'])), columns=range(1))
                    data_tmp.loc[int(data.loc[idx,0])-1, 0] = 1
                else: 
                    data_tmp = pd.DataFrame(None, index=range(int(self.ranges.loc[idx, 'max'])), columns=range(1))
                # set new types
                types_tmp = pd.DataFrame(1, index=range(int(self.ranges.loc[idx, 'max'])), columns=range(1))                
                # set new index
                data_tmp.index = index_new
                types_tmp.index = index_new
                # accumulate new data
                data_new.append(data_tmp)
                types_new.append(types_tmp)
            # concatenate data
            data_new = pd.concat(data_new)
            types_new = pd.concat(types_new)
            return data_new, types_new
        
        def expandPrimary(data):
            data_new = []
            types_new = []
            for idx in data.index:                
                index_new = []
                # build new index
                for i in range(int(self.ranges.loc[idx, 'max'])):
                    index_new.append(idx + '_' + str(i+1))
                # transform nominal to dichotmous
                if not pd.isnull(data.loc[idx,0]): 
                    data_tmp = pd.DataFrame(0, index=range(int(self.ranges.loc[idx, 'max'])), columns=range(1))
                    for col in data:
                        if not (pd.isnull(data.loc[idx,col]) or data.loc[idx,col]==0):
                            data_tmp.loc[int(data.loc[idx,col])-1, 0] = 1
                else: 
                    data_tmp = pd.DataFrame(None, index=range(int(self.ranges.loc[idx, 'max'])), columns=range(1))
                # set new types
                types_tmp = pd.DataFrame(1, index=range(int(self.ranges.loc[idx, 'max'])), columns=range(1))                
                # set new index
                data_tmp.index = index_new
                types_tmp.index = index_new
                # accumulate new data
                data_new.append(data_tmp)
                types_new.append(types_tmp)
            # concatenate data
            data_new = pd.concat(data_new)
            types_new = pd.concat(types_new)
            return data_new, types_new
                
        def expandNominalbyPrimary(data, prim_data, prim_idx):
            data_new = []
            types_new = []
            for idx in data.index:                
                index_new = []
                # build new index
                for i in range(int(self.ranges.loc[prim_idx, 'max'])):
                    for j in range(int(self.ranges.loc[idx, 'max'])):
                        index_new.append(idx + '_' + str(i+1) + '_' + str(j+1))                
                # build dichotomous structure
                data_tmp = pd.DataFrame(None, index=range(int(self.ranges.loc[prim_idx, 'max'])*int(self.ranges.loc[idx, 'max'])), columns=range(1))
                # fill in values
                for col in prim_data:
                    if not (pd.isnull(data.loc[idx,col]) or pd.isnull(prim_data.loc[prim_idx,col])):
                        offset = (int(prim_data[col]) - 1)*int(self.ranges.loc[idx, 'max']) - 1
                        for i in range(int(self.ranges.loc[idx, 'max'])):
                            data_tmp.loc[offset+(i+1), 0] = 0
                        data_tmp.loc[offset+int(data.loc[idx,col]), 0] = 1
                # set new types
                types_tmp = pd.DataFrame(1, index=range(int(self.ranges.loc[prim_idx, 'max'])*int(self.ranges.loc[idx, 'max'])), columns=range(1))                
                # set new index
                data_tmp.index = index_new
                types_tmp.index = index_new
                # accumulate new data
                data_new.append(data_tmp)
                types_new.append(types_tmp)
            # concatenate data
            data_new = pd.concat(data_new)
            types_new = pd.concat(types_new)
            return data_new, types_new
        
        def expandbyPrimary(data, types, prim_data, prim_idx):
            data_new = []
            types_new = []
            for idx in data.index:                
                index_new = []
                # build new index
                for i in range(int(self.ranges.loc[prim_idx, 'max'])):
                        index_new.append(idx + '_' + str(i+1))                
                # build structure
                data_tmp = pd.DataFrame(None, index=range(int(self.ranges.loc[prim_idx, 'max'])), columns=range(1))
                # fill in values
                for col in prim_data:
                    if not (pd.isnull(data.loc[idx,col]) or pd.isnull(prim_data.loc[prim_idx,col])):
                        data_tmp.loc[int(prim_data[col])-1, 0] = data.loc[idx,col]
                # set new types
                types_tmp = pd.DataFrame(types.loc[idx,0], index=range(int(self.ranges.loc[prim_idx, 'max'])), columns=range(1))                
                # set new index
                data_tmp.index = index_new
                types_tmp.index = index_new
                # accumulate new data
                data_new.append(data_tmp)
                types_new.append(types_tmp)
            # concatenate data
            data_new = pd.concat(data_new)            
            types_new = pd.concat(types_new)
            return data_new, types_new        
      
        data_new = []
        types_new = []        
        for section in Visit.tables:

            # extract subset
            subdata = {key: data[key] for key in data.keys() if section in key}
            subdata = pd.DataFrame.from_dict(subdata, orient='index')            
            # extract matching types
            subtypes = {key: types[key] for key in subdata.index}
            subtypes = pd.DataFrame.from_dict(subtypes, orient='index')
            
            # split data by types 134 = dichotomous/ordinal/interval/ratio & 2 = nominal
            subdata_134 = subdata.drop([idx for idx in subdata.index if subtypes.loc[idx,0]==2])            
            subdata_2 = subdata.drop(subdata_134.index)
            subtypes_134 = subtypes.drop(subdata_2.index)
            subtypes_2 = subtypes.drop(subdata_134.index)
            
            # if necessary: transform subdata by primary feature
            if section in self.sortby.keys():
                # get index of primary feature
                idx_primary = self.sortby[section]
                # split primary feature from nominal data
                subdata_primary = subdata_2.drop(idx for idx in subdata_2.index if idx != idx_primary)                
                subdata_2 = subdata_2.drop(idx_primary)
                subtypes_primary = subtypes_2.drop(subdata_2.index)
                subtypes_2 = subtypes_2.drop(idx_primary)
                # transform nominal data
                if not subdata_2.empty:
                    subdata_2, subtypes_2 = expandNominalbyPrimary(subdata_2, subdata_primary, idx_primary)
                else:
                    subdata_2 = pd.DataFrame()
                # transfrom dichotomous/ordinal/interval/ratio data
                if not subdata_134.empty:
                    subdata_134, subtypes_134 = expandbyPrimary(subdata_134, subtypes_134, subdata_primary, idx_primary)
                else:
                    subdata_134 = pd.DataFrame()    
                # transform primary feature
                subdata_primary, subtypes_primary = expandPrimary(subdata_primary)
                # merge primary feature and nominal data
                subdata_2 = pd.concat([subdata_primary, subdata_2])
                subtypes_2 = pd.concat([subtypes_primary, subtypes_2]) 
            # else: only expand/transform nominal subdata
            else:
                if not subdata_2.empty:
                    subdata_2, subtypes_2 = expandNominal(subdata_2)
                else:
                    subdata_2 = pd.DataFrame()
                # error: surplus column
                if not subdata_134.empty:
                    subdata_134 = pd.DataFrame(subdata_134[0])
                else:
                    subdata_134 = pd.DataFrame()
            # concatenate split data
            subdata = pd.concat([subdata_134, subdata_2])
            subtypes = pd.concat([subtypes_134, subtypes_2])
            
            # accumulate transformed subdata
            data_new.append(subdata)
            types_new.append(subtypes)
        
        # concatenate subsets 
        data_new = pd.concat(data_new)
        data_new = data_new.astype(np.float64)
        types_new = pd.concat(types_new)        
        
        return data_new, types_new


    def calcAffinity(self, data, weights_aff=pd.Series({"therapycurrent: Wirksamkeit":1,"therapycurrent: UAWja":1,"therapycurrent: DeltaPasi":1,"therapyprevious: Wirksamkeit":1,"therapyprevious: UAWJa":1})):
        
        def calc(outcome, index):
            ### get outcome measures
            measures = {"name":[],"data":[],"affinity":[],"div":[]}
            for ind in outcome["measures"]:
                idx_drop = [idx for idx in data.index if ind not in idx]
                data_tmp = data.drop(idx_drop)
                measures["name"].append(ind)
                measures["data"].append(data_tmp)
        
            ### calculate affinity of outcome measures
            for i, name in enumerate(measures["name"]):
                # get df
                aff_om = measures["data"][i]
                # calc
                if name in ["therapycurrent: Wirksamkeit", "therapyprevious: Wirksamkeit"]:                
                    aff_om = (1 - aff_om*0.25)*weights_aff[name]                    
                # UAWnein???
                elif name in ["therapycurrent: UAWja", "therapyprevious: UAWJa"]:
                    aff_om = (aff_om*(-0.25))*weights_aff[name]
                elif name == "therapycurrent: DeltaPasi":
                    aff_om = (-1*((-1) + 1/(1 + np.exp(-0.1*aff_om))))*weights_aff[name]
                # set new index
                aff_om.index = index
                # get divisor
                div_om = aff_om.notnull()*weights_aff[name]
                # gather affinities of outcome measures
                measures["affinity"].append(aff_om)                                
                measures["div"].append(div_om)
            
            ### calculate overall affinity
            affinity = reduce(lambda x, y: x.add(y), measures["affinity"])
            div = reduce(lambda x, y: x.add(y), measures["div"])
            div[div==0] = None
            affinity = affinity/div
            # negative values to zero?
            affinity[affinity < 0] = 0
            return affinity
        
        ### get settings
        current = self.outcome["current"]
        hist = self.outcome["hist"]

        ### current 
        # get dominant feature
        idx_drop = [idx for idx in data.index if current["primary"] not in idx]
        primary_current = data.drop(idx_drop)
        idx_new = []
        # set new index
        for idx in primary_current.index:
            idx_new.append(idx.replace("therapycurrent", "affinity"))
        affinity_current = pd.DataFrame(index=idx_new)
        # calculate current affinity
        affinity_current = calc(current, idx_new)
        
        ### hist
        # get dominant feature
        idx_drop = [idx for idx in data.index if hist["primary"] not in idx]
        primary_hist = data.drop(idx_drop)        
        idx_new = []
        # set new index
        for idx in primary_hist.index:
            idx_new.append(idx.replace("therapyprevious", "affinity"))
        affinity_hist = pd.DataFrame(index=idx_new)
        # calculate affinity_hist
        affinity_hist = calc(hist, idx_new)
        
        ### merge current & hist 
        affinity = affinity_current.mask(affinity_current.isnull(), other=affinity_hist, axis=0)

        return affinity


        
    def matchTrainingData(self):
        ### drop visits of current patient
        trainData_tmp = self.trainData.drop(columns=self.currentIDs["visitIDs"])
        trainIDs_tmp = self.trainIDs.copy()
        trainIDs_tmp["visitIDs"]    = [x for x in self.trainIDs["visitIDs"] if x not in self.currentIDs["visitIDs"]]
        trainIDs_tmp["patientIDs"]  = [x for x in self.trainIDs["patientIDs"] if x != self.currentIDs["patientID"]]
        # drop visits with other feature types??? (currentTypes==trainTypes)
        return trainData_tmp, trainIDs_tmp
            
    
    
    def prepareFeatures(self, currentData, trainData):
#        currentData = self.imputeFeatures(currentData)
#        trainData   = self.imputeFeatures(trainData)
        currentData = self.modifyFeatures(currentData)
        trainData   = self.modifyFeatures(trainData)

        return currentData, trainData 
 
    
    
    def imputeFeatures(self, data, filler='mode'):            
        for index, row in data.iterrows():
            ### fill NaNs with {filler} of feature 
            if row.isnull().any():
                data.loc[index].fillna(self.moct_adj.loc[index, filler], inplace=True)       
        return data



    def modifyFeatures(self, data):        
        ### feature normalization on 0-1 range
        
        ### numpy arrays for calculation:
        # minimum of features
        npranges_min = self.ranges_adj["min"].values
        npranges_min = npranges_min.repeat(data.shape[1])
        npranges_min = npranges_min.reshape(data.shape[0],data.shape[1])
        # maximum - minimum of features
        ranges_div = (self.ranges_adj["max"] - self.ranges_adj["min"])
        npranges_div = ranges_div.values
        npranges_div = npranges_div.repeat(data.shape[1])
        npranges_div = npranges_div.reshape(data.shape[0],data.shape[1])
        # feature types
        npcurrentTypes = self.currentTypes.values
        npcurrentTypes = npcurrentTypes.repeat(data.shape[1])
        npcurrentTypes = npcurrentTypes.reshape(data.shape[0],data.shape[1])
        
        ### normalize: (value - min)/(max - min)
        data_norm = data.sub(npranges_min)
        data_norm = data_norm.div(npranges_div)
        
        ### overwrite dataframe if dtype >= ordinal
        data = data.mask(npcurrentTypes > 2, other=data_norm, axis=0)
                
        return data
    
 
    
    def calcKNN(self, currentData, trainData, distfunc=None):
        ### calculate similarities
        currentSim = self.calcModGower(currentData, trainData)
        ### take k-nearest-neighbors        
        kNN = currentSim.take(list(range(self.prefilter)))
        
        return kNN



    def calcModGower(self, currentData, trainData, weights=None):
        ### numpy arrays for calculation
        npcurrentData = currentData.values
        npcurrentData = npcurrentData.repeat(trainData.shape[1])
        npcurrentData = npcurrentData.reshape(trainData.shape[0],trainData.shape[1])
        npcurrentTypes = self.currentTypes.values
        npcurrentTypes = npcurrentTypes.repeat(trainData.shape[1])
        npcurrentTypes = npcurrentTypes.reshape(trainData.shape[0],trainData.shape[1])
        
        ### calculate similarity for dtype: dichotomous
        score_bin = pd.DataFrame().reindex_like(trainData)
        mask_bin = trainData == npcurrentData
        score_bin[mask_bin] = 1
        score_bin[~mask_bin] = 0
        
        ### calculate similarity for dtype: ordinal/interval/ratio
        score_metr = 1 - abs(trainData - npcurrentData)
        
        ### merge results
        score = score_bin.mask(npcurrentTypes>2, other=score_metr, axis=0)
        
        ### remove invalid values
        mask_isnull = trainData.isnull() | pd.isnull(npcurrentData)
        score[mask_isnull] = None

        ### calculate overall similarity
        gsc = score.sum(axis=0, skipna=True)/score.count()
        # sort result (descending)
        gsc.sort_values(ascending=False, inplace=True)
        
        return gsc    



    def calcRecom(self, kNN):
        # get affinities of kNN
        kNN_aff = self.trainAffinity[kNN.index]
        # recom = mean        
        recom = kNN_aff.sum(axis=1)/kNN_aff.shape[1]
        # drop recommendations below threshold
        idx_drop = [idx for idx in recom.index if recom[idx]<self.affinity_thr]
        recom_thr = recom.drop(idx_drop)
        
        return recom, recom_thr
