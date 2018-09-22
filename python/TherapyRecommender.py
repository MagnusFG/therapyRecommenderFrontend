import pandas as pd
import numpy as np
import json
import time


class TherapyRecommender:
            
    def __init__(self, config_recom):                

        ### settings
        self.impute         = config_recom["impute"]
        self.extended       = config_recom["extended"]
        self.prefilter      = config_recom["prefilter"]
        self.affinity_thr   = config_recom["affinity_thr"]
        self.rules          = config_recom["rules"]
        
        ### input
        # attributes
        self.dsTrain = pd.DataFrame()
        self.dsTest = pd.DataFrame()
        # info
        self.IDTest = pd.DataFrame()
        # outcome
        self.outcomeTrain = {'affinity': pd.DataFrame(),
                             'uaw': pd.DataFrame(),
                             'wirksamkeit': pd.DataFrame(),
                             'deltapasi': pd.DataFrame()}      
        self.outcomeTest = {'affinity': pd.DataFrame(),
                            'uaw': pd.DataFrame(),
                            'wirksamkeit': pd.DataFrame(),
                            'deltapasi': pd.DataFrame()}
        # metadata
        self.fType = pd.DataFrame()        
        self.fRange = pd.DataFrame()
        self.fWeights = pd.DataFrame()
        
        ### computed       
        self.similarity = pd.Series()
        self.kNN = pd.Series()
        self.prediction = {'affinity': pd.Series(),
                           'uaw': pd.Series(),
                           'wirksamkeit': pd.Series(),
                           'deltapasi': pd.Series()}
        
        ### output
        ...

        
    def doRecommendation(self, ds, vis, vdb, predict=['affinity','uaw', 'wirksamkeit', 'deltapasi']):
        # create dataset
        s = time.time()
        ds.create(vis, vdb)
        e = time.time()
        print('--create dataset:', e-s)
        # preprocess data
        s = time.time()
        self.preprocess(ds)
        e = time.time()        
        print('--preprocess:', e-s)
        # process data
        s = time.time()
        self.process(predict)
        e = time.time()
        print('--process:', e-s)
        # postprocess results
        s = time.time()
        self.postprocess(ds)
        e = time.time()
        print('--postprocess:', e-s)
        #return self.prediction


    def preprocess(self, ds):
        # unzip dataset
        self.dsTrain = ds.trainData.copy()
        self.dsTest = ds.currentData.copy()
        self.IDTest = ds.currentID.copy()
        
        self.outcomeTrain['affinity'] = ds.trainAffinityAll_static.copy()
        self.outcomeTrain['uaw'] = ds.trainUAWAll_static.copy()
        self.outcomeTrain['wirksamkeit'] = ds.trainWirksamkeitAll_static.copy()
        self.outcomeTrain['deltapasi'] = ds.trainDeltaPasiAll_static.copy()

        self.outcomeTest['affinity'] = ds.currentAffinityAll.copy()
        self.outcomeTest['uaw'] = ds.currentUAWAll.copy()
        self.outcomeTest['wirksamkeit'] = ds.currentWirksamkeitAll.copy()
        self.outcomeTest['deltapasi'] = ds.currentDeltaPasiAll.copy()
        
        self.fType = ds.trainTypes.copy()
        self.fRange = ds.featureRange.copy()
        self.fWeights = ds.currentWeights.copy()
        
        # adjust attributes
#        s = time.time()
#        self.convertNominal()
#        e = time.time()
#        print('----convertNominal:', e-s)
        
        # eliminate zero attributes
        self.dsTest = self.dsTest.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.fType = self.fType.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.fRange = self.fRange.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.fWeights = self.fWeights.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.dsTrain = self.dsTrain.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        
    
#    def convertNominal(self):        
#        def onehot(df):
#            df_converted = pd.DataFrame()
#            for attribute in df.columns:
#                # get range
#                rng = self.fRange[attribute][0]
#                # build onehot indices
#                idx = df[attribute].values - 1
#                isnan = np.isnan(idx)
#                idx[isnan] = 0
#                idx = np.int64(idx)
#                # convert
#                onehot = np.zeros([idx.shape[0], rng+1])
#                onehot[np.arange(idx.shape[0]), idx] = 1
#                onehot[isnan, :] = 0
#                # get new names (by numbering old name)
#                attributes_new = []
#                for i in range(onehot.shape[1]):
#                    attributes_new.append(attribute + '_' + str(i+1))
#                # array to dataframe
#                df_new = pd.DataFrame(onehot, index=df.index, columns=attributes_new)
#                # concatenate converted features
#                df_converted = pd.concat([df_converted, df_new])
#            return df_converted
#        
#        # extract nominal attributes                                
#        dsNominalTrain = self.dsTrain.loc[:, (self.fType.values==2)[0]]
#        dsNominalTest = self.dsTest.loc[:, (self.fType.values==2)[0]]
#        # extract other attributes
#        dsTrain = self.dsTrain.loc[:, (self.fType.values!=2)[0]]
#        dsTest = self.dsTest.loc[:, (self.fType.values!=2)[0]]
#        # combine other attributes and converted nominal attributes
#        dsTrain = pd.concat([dsTrain, onehot(dsNominalTrain)], axis=1)
#        dsTest = pd.concat([dsTest, onehot(dsNominalTest)], axis=1)
#        # overwrite
#        #self.dsTrain = dsTrain
#        #self.dsTest = dsTest
            
            
            
    def process(self, predict):
        # get k-nearest-neighbours
        s = time.time()
        self.calcKNN(distfunc='gower')
        e = time.time()
        print('----calcKNN:', e-s)
        # predict outcome
        s = time.time()
        for measure in predict:
            self.prediction[measure] = self.calcRecom(self.outcomeTrain[measure], measure)
        e = time.time()
        print('----calcRecom:', e-s)
            
            
    def calcRecom(self, data, measure):                
        # ground truth
        t_rating = data.loc[self.IDTest['Visite'], :]
        # nearest ratings
        nn_ratings = data.loc[self.kNN.index, :]
        
        # if no similarity
        if np.sum(self.kNN) == 0:
            # prediction = ground truth
            r_rating = t_rating
        else:
            ## normalize = 0
            # nearest ratings
            x_rating = nn_ratings.values.copy()
            # weights w.r.t kNN
            w_rating = np.broadcast_to(self.kNN.values, (x_rating.shape[1], x_rating.shape[0])).copy().T
            w_rating[np.isnan(x_rating)] = 0
            if measure == 'affinity':
                w_rating[(x_rating==0)] = 0
            w_rating_sum = np.sum(w_rating, axis=0) # avoid division by zero
            w_rating_sum[w_rating_sum==0] = 1       # avoid division by zero
            w_rating = w_rating / w_rating_sum
            w_rating[np.isnan(w_rating)] = 0
            x_rating[np.isnan(x_rating)] = 0            
            # regression
            r_rating = np.sum(x_rating * w_rating, axis=0)
        
        if measure == 'affinity':
            # mean of present ratings w.r.t. therapies        
            all_ratings = data.values.copy()
            all_ratings[np.isnan(all_ratings)] = 0
            nonzero_ratings = np.sum(all_ratings!=0, axis=0)# avoid division by zero
            nonzero_ratings[nonzero_ratings==0] = 1         # avoid division by zero
            mean_ratings = np.sum(all_ratings, axis=0) / nonzero_ratings    
            
            # ignore recommendations below threshhold
            r_rating[r_rating <= self.affinity_thr] = 0   
                
            # break ties
            eps = 1e-6
            unique_ratings = np.unique(r_rating[r_rating > 0])
            for val in unique_ratings:
                isval = r_rating == val
                if np.sum(isval) > 1:
                    r_rating[isval] = r_rating[isval] + (eps * mean_ratings[isval])
            
            # normalize
            r_rating = r_rating / np.sum(r_rating)            

        return pd.Series(r_rating, name=measure)
    
    
    def calcKNN(self, distfunc='gower'):
        ### define distance function
        if distfunc == 'gower':            
            calcDist = self.calcGower                       
        
        ### calculate (rooted) distance & similarity
        s = time.time()
        root_distance = calcDist()
        similarity = 1 - np.square(root_distance)
        self.similarity = pd.Series(similarity, index=self.dsTrain.index, name='similarity')
        e = time.time()
        print('--------calcSimilarity:', e-s)        
        
        ### take k-nearest-neighbors
        similarity_sorted = self.similarity.sort_values(ascending=False)        
        self.kNN = similarity_sorted.take(np.arange(self.prefilter))

        
    def calcGower(self):        
        # masks: dtype
        mask_bin = (self.fType==1).values[0]
        mask_nom = (self.fType==2).values[0]
        mask_ord = (self.fType==3).values[0]
        mask_int = (self.fType==4).values[0]
                                                        
        '''qualitative similartity'''                
        ### data
        # dichotomous and nominal data
        dsQualTest, dsQualTrain = self.dsTest.loc[:, mask_bin+mask_nom].values, self.dsTrain.loc[:, mask_bin+mask_nom].values
        fWeights_qual = self.fWeights.loc[:, mask_bin+mask_nom].values        
        
        ### masks
        # mask ~dij: (x = nan) or (y = nan) or (x = 0 and y = 0)
        indicator_qual = np.isnan(dsQualTest) + np.isnan(dsQualTrain) + ((dsQualTest==0) * (dsQualTrain==0))        
        
        ### compute + apply rules
        # if x==y: score = 1 , else: score = 0
        score_qual = (dsQualTest == dsQualTrain).astype(float)        
        # score = score * fweight
        score_qual = score_qual * fWeights_qual
        # score[~dij] = None
        score_qual[indicator_qual] = None
        
        ### sum
        score_qual = np.nansum(score_qual, axis=1)
        div_qual = ((~indicator_qual).astype(float)*fWeights_qual).sum(axis=1)
                
        '''quantitative similartity'''        
        ### data
        # ordinal, interval, ratio data
        dsQuantTest, dsQuantTrain = self.dsTest.loc[:, mask_ord+mask_int].values, self.dsTrain.loc[:, mask_ord+mask_int].values
        fWeights_quant = self.fWeights.loc[:, mask_ord+mask_int].values
        fRange_quant = self.fRange.loc[:, mask_ord+mask_int].values
        
        ### masks
        # mask: range = 0, avoid division by zero       
        range_zero = (fRange_quant==0)     
        fRange_quant[range_zero] += 1
        range_zero = np.broadcast_to(range_zero, (dsQuantTrain.shape[0], dsQuantTrain.shape[1]))
        # mask ~dij: (x = nan) or (y = nan)'
        indicator_quant = np.isnan(dsQuantTest) + np.isnan(dsQuantTrain)
        
        ### compute + apply rules
        # score = 1 - |Xn-Yn|/Rn;  if range == 0 -> score = 1
        score_quant = 1 - (np.absolute(dsQuantTrain - dsQuantTest) / fRange_quant)        
        score_quant[range_zero] = 1
        # score = score * fweight
        score_quant = score_quant * fWeights_quant
        # score[~dij] = None
        score_quant[indicator_quant] = None
        
        ### sum
        score_quant = np.nansum(score_quant, axis=1)
        div_quant = ((~indicator_quant).astype(float)*fWeights_quant).sum(axis=1)

        '''overall similarity'''
        score = score_qual + score_quant
        div = div_qual + div_quant
        gsc = score / div        
        
        # sqrt(distance)
        gsc = np.sqrt(1 - gsc)                                                    
        return gsc        

    
    def postprocess(self, ds):
        self.JSONOut(ds)


    def JSONOut(self, ds):
        
        '''neighbourhood.json'''                        
        
        ### nodes         
        # static psoriasis type names
        psoriasis_names = ['Chronischer Plaque-Typ (Psoriasis vulgaris)','Psoriasis pustulosa palmoplantaris','Psoriasis guttata','Psoriasis inversa','Nagelbeteiligung','Psoriasis Arthritis']
        # convert dataframe to dictionary (for patientdata)
        def to_dict(df):
            patientdata = {}
            data = df.values.copy()
            attributes = df.columns.values.copy()
            # remove attribute numbering
            for i, name in enumerate(attributes):
                attributes[i] = name.split('_')[0]
            # get unique names   
            unique_attributes = np.unique(attributes)
            # df to dict
            for name in unique_attributes:
                idx = attributes == name
                if data[:, idx].shape[1] > 1:
                    # special treatment
                    if name=='Psoriasistyp':
                        patientdata[name] = []
                        psoriasisdata = data[:, idx].tolist()[0]
                        for i, val in enumerate(psoriasisdata):
                            if val == 1:
                                patientdata[name].append(psoriasis_names[i])
                    else:
                        # return connected attributes as list
                        patientdata[name] = data[:, idx].tolist()[0]                                                    
                else:
                    # return stand-alone attributes as scalar
                    patientdata[name] = np.asscalar(data[:, idx])
            return patientdata
                          
        nodes = []
        nodes.append({"id": str(self.IDTest['Visite'].values[0]).zfill(4),
                      "Patientendaten": to_dict(ds.currentData)})
        for idx in self.kNN.index:
            nodes.append({"id": str(idx).zfill(4),
                          "Patientendaten": to_dict(pd.DataFrame(ds.trainData.loc[idx, :]).T)})

        ### links
        links = []     
        for k in range(len(self.kNN)):
            links.append({"source": str(self.IDTest['Visite'].values[0]).zfill(4),
                          "target": str(self.kNN.index.values[k]).zfill(4),
                          "similarity": self.kNN.values[k]})  
      
        ### write output
        with open('output/neighbourhood.json', 'w') as fp:
            fp.write('{' +
                    '\n\t"nodes": [\n' +
                    ',\n'.join('\t\t' + json.dumps(dictx, ensure_ascii=False) for dictx in nodes) +
                    '\n\t]' +
                    ',' +
                    '\n\t"links": [\n' +
                    ',\n'.join('\t\t' + json.dumps(dictx, ensure_ascii=False) for dictx in links) +
                    '\n\t]' +
                    '\n}')

    
        '''recommendation.sjon'''        
        # static therapy names
        therapy_names = ['Methotrexat','Ciclosporin','Acitretin','Fumaderm','Infliximab','Etanercept','Golimumab','Adalimumab','Ustekinumab','Certolizumab','Apremilast','Secukinumab','PUVA','Andere UV-Therapie','Andere Therapie (Systemische Therapie)','Methotrexat / Adalimumab','Methotrexat / Etanercept','Methotrexat / Infliximab','Methotrexat / Secukinumab','Methotrexat / Ustekinumab','Methotrexat / Golimumab']
        
        ### therapyData    
        therapyData = []
        for tx in range(len(self.prediction['affinity'])):
            therapyData.append({"Therapy": therapy_names[tx],
                                "Affinity": self.prediction['affinity'][tx],
                                "prediction": {"Wirksamkeit": self.prediction['wirksamkeit'][tx],
                                               "deltaPasi": self.prediction['deltapasi'][tx],
                                               "UAW": self.prediction['uaw'][tx]}
                                }) 
    
        ### write output
        with open('output/recommendation.json', 'w') as fp:
            fp.write('{' +
                    '\n\t"therapyData": [\n' +
                    ',\n'.join('\t\t' + json.dumps(dictx, ensure_ascii=False) for dictx in therapyData) +
                    '\n\t]' +
                    '\n}')

