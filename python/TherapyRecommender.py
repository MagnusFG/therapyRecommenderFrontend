import pandas as pd
import numpy as np
import json
#import time
#from functools import reduce
#import pickle

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
        self.outcomeTrain = pd.DataFrame()
        self.outcomeTest = pd.DataFrame()
        # metadata
        self.fType = pd.DataFrame()        
        self.fRange = pd.DataFrame()
        self.fWeights = pd.DataFrame()
        
        ### computed       
        self.similarity = pd.Series()
        self.kNN = pd.Series()
        self.prediction = pd.Series()
        
        ### output
        ...

        
    def doRecommendation(self, ds, vis, vdb):        
        ds.create(vis, vdb)
        self.preprocess(ds)
        self.process()
        self.postprocess()
        #return self.prediction
#        ### prepare features for calculation (currently: feature normalization)
#        s = time.time()
#        currentData, trainData = self.prepareFeatures(currentData, trainData)
#        e = time.time()
#        print("prepareFeatures:", e-s)
#        ### find k-nearest neighbors of current visit
#        s = time.time()
#        self.currentkNN = self.calcKNN(currentData, trainData)
#        e = time.time()
#        print("calcKNN:", e-s)
#        ### estimate affinities of current visits based on kNN 
#        s = time.time()
#        self.currentRecom, currentRecom_thr = self.calcRecom(self.currentkNN)
#        e = time.time()
#        print("calcRecom:", e-s)
#        ### print recommendations above threshold
#        if not currentRecom_thr.empty:
#            for idx, val in currentRecom_thr.iteritems():
#                print(idx, "=", val)


    def preprocess(self, ds):
        # unzip dataset
        self.dsTrain = ds.trainData
        self.dsTest = ds.currentData
        self.IDTest = ds.currentID
        self.outcomeTrain = ds.trainOutcome_static
        self.outcomeTest = ds.currentOutcome
        self.fType = ds.trainTypes
        self.fRange = ds.featureRange
        self.fWeights = ds.currentWeights
        
        # eliminate zero attributes
        self.dsTest = self.dsTest.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.fType = self.fType.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.fRange = self.fRange.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.fWeights = self.fWeights.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        self.dsTrain = self.dsTrain.loc[:, self.dsTrain.sum(axis=0, skipna=False) != 0]
        
        # for comparison
        self.gsc23mat = ds.D_mat_23

                    
    def process(self):
        self.calcKNN(distfunc='gower')
        self.calcRecom()


    def calcRecom(self):
        # mean of present ratings w.r.t. therapies        
        all_ratings = self.outcomeTrain.values.copy()
        all_ratings[np.isnan(all_ratings)] = 0
        nonzero_ratings = np.sum(all_ratings!=0, axis=0)# avoid division by zero
        nonzero_ratings[nonzero_ratings==0] = 1         # avoid division by zero
        mean_ratings = np.sum(all_ratings, axis=0) / nonzero_ratings
        # ground truth
        t_rating = self.outcomeTrain.loc[self.IDTest['Visite'], :]
        # nearest ratings
        nn_ratings = self.outcomeTrain.loc[self.kNN.index, :]
        
        # if no similarity
        if np.sum(self.kNN) == 0:
            # prediction = ground truth
            r_rating = t_rating
        else:
            # normalize = 0
            x_rating = nn_ratings.values.copy()
            w_rating = np.broadcast_to(self.kNN.values, (x_rating.shape[1], x_rating.shape[0])).copy().T
            w_rating[np.isnan(x_rating) + (x_rating==0)] = 0
            w_rating_sum = np.sum(w_rating, axis=0) # avoid division by zero
            w_rating_sum[w_rating_sum==0] = 1       # avoid division by zero
            w_rating = w_rating / w_rating_sum
            w_rating[np.isnan(w_rating)] = 0
            x_rating[np.isnan(x_rating)] = 0            
            r_rating = np.sum(x_rating * w_rating, axis=0)
            
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
        self.prediction = pd.Series(r_rating, name='affinity')
    
    
    def calcKNN(self, distfunc='gower'):
        ### define distance function
        if distfunc == 'gower':
            calcSimilarity = self.calcGower            
        
        ### calculate similarity
        self.similarity = calcSimilarity()        
        
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
        # ???????? -> sqrt(distance)
        #gsc = np.sqrt(1-gsc)                                                    
        gsc = pd.Series(gsc, index=self.dsTrain.index, name='similarity')
        #######################################################################
        gsc23mat = self.gsc23mat.T
        # python: similarity
        gsc_sort = gsc.sort_values(ascending=False)
        # matlab: sqrt(distance)
        gsc23mat_sort = gsc23mat.sort_values(by=[0], ascending=True)
        #######################################################################
        return gsc        

    
    def postprocess(self):
        self.JSONOut()


    def JSONOut(self):
        ### neighbourhood 
               
        # nodes
#        def node_format(data):
#            for key, value in data.items():
#                if None in value and len(value) > 1:
#                    data[key] = ['k.A.' if val is None else val for val in value]
#                elif len(value) == 1:
#                    if None in value:
#                         data[key] = 'k.A.'
#                    else:     
#                        data[key] = value[0]
#            return data
#           
#        nodes = []
#        nodes.append({"id": str(vis.visitID).zfill(4),
#                      "Patientendaten": node_format(vis.attributes)})
#        for idx in self.currentkNN.index.values.tolist():
#            idx_new = self.trainIDs["visitIDs"].index(idx)
#            nodes.append({"id": str(idx).zfill(4),
#                          "Patientendaten": node_format(self.trainVisits[idx_new].attributes)})

        # links
        links = []     
        for k in range(len(self.kNN)):
            links.append({"source": str(self.IDTest['Visite'].values[0]).zfill(4),
                          "target": str(self.kNN.index.values[k]).zfill(4),
                          "similarity": self.kNN.values[k]})        
        
#        with open('output/neighbourhood.json', 'w') as fp:
#            fp.write('{' +
#                    '\n\t"nodes": [\n' +
#                    ',\n'.join('\t\t' + json.dumps(dictx, ensure_ascii=False) for dictx in nodes) +
#                    '\n\t]' +
#                    ',' +
#                    '\n\t"links": [\n' +
#                    ',\n'.join('\t\t' + json.dumps(dictx, ensure_ascii=False) for dictx in links) +
#                    '\n\t]' +
#                    '\n}')
    
        ### recommendation
        # static therapy names
        therapy_names = ['Methotrexat','Ciclosporin','Acitretin','Fumaderm','Infliximab','Etanercept','Golimumab','Adalimumab','Ustekinumab','Certolizumab','Apremilast','Secukinumab','PUVA','Andere UV-Therapie','Andere Therapie (Systemische Therapie)','Methotrexat / Adalimumab','Methotrexat / Etanercept','Methotrexat / Infliximab','Methotrexat / Secukinumab','Methotrexat / Ustekinumab','Methotrexat / Golimumab']
            
        therapyData = []
        for tx in range(len(self.prediction)):
            therapyData.append({"Therapy": therapy_names[tx],
                                "Affinity": self.prediction[tx],
                                "prediction": {"Wirksamkeit": self.prediction[tx],
                                               "deltaPasi": self.prediction[tx],
                                               "UAW": self.prediction[tx]}
                                })
    
        with open('output/recommendation.json', 'w') as fp:
            fp.write('{' +
                    '\n\t"therapyData": [\n' +
                    ',\n'.join('\t\t' + json.dumps(dictx, ensure_ascii=False) for dictx in therapyData) +
                    '\n\t]' +
                    '\n}')


                             
#    def imputeFeatures(self, data, filler='mode'):            
#        for index, row in data.iterrows():
#            ### fill NaNs with {filler} of feature 
#            if row.isnull().any():
#                data.loc[index].fillna(self.moct_adj.loc[index, filler], inplace=True)       
#        return data
#
#
#    def modifyFeatures(self, data):        
#        ### feature normalization on 0-1 range
#        
#        ### numpy arrays for calculation:
#        # minimum of features
#        npranges_min = self.ranges_adj["min"].values
#        npranges_min = npranges_min.repeat(data.shape[1])
#        npranges_min = npranges_min.reshape(data.shape[0],data.shape[1])
#        # maximum - minimum of features
#        ranges_div = (self.ranges_adj["max"] - self.ranges_adj["min"])
#        npranges_div = ranges_div.values
#        npranges_div = npranges_div.repeat(data.shape[1])
#        npranges_div = npranges_div.reshape(data.shape[0],data.shape[1])
#        # feature types
#        npcurrentTypes = self.currentTypes.values
#        npcurrentTypes = npcurrentTypes.repeat(data.shape[1])
#        npcurrentTypes = npcurrentTypes.reshape(data.shape[0],data.shape[1])
#        
#        ### normalize: (value - min)/(max - min)
#        data_norm = data.sub(npranges_min)
#        data_norm = data_norm.div(npranges_div)
#        
#        ### overwrite dataframe if dtype >= ordinal
#        data = data.mask(npcurrentTypes > 2, other=data_norm, axis=0)
#                
#        return data
    
 

