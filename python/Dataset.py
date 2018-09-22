import pandas as pd
import numpy as np
import time

class Dataset:
    # filepath
    filepath = './data/impute_0/'    
    # attribute ranges
    featureRange = pd.DataFrame()    
    # training data
    trainData_static = pd.DataFrame()
    trainTypes_static = pd.DataFrame()
    # training info
    trainInfo_static = pd.DataFrame()
    # training outcome
    trainAffinityAll_static = pd.DataFrame()
    trainUAWAll_static = pd.DataFrame()
    trainWirksamkeitAll_static = pd.DataFrame()
    trainDeltaPasiAll_static = pd.DataFrame()
    
    def __init__(self):
        # current visit 
        self.currentData = pd.DataFrame()
        self.currentTypes = pd.DataFrame()
        self.currentInfo = pd.DataFrame()
        self.currentID = pd.DataFrame()
        self.currentWeights = pd.DataFrame()
        self.currentAffinityAll = pd.DataFrame()
        self.currentUAWAll = pd.DataFrame()
        self.currentWirksamkeitAll = pd.DataFrame()
        self.currentDeltaPasiAll = pd.DataFrame()
        # current training data
        self.trainData = pd.DataFrame()
        self.trainTypes = pd.DataFrame()
        self.trainInfo = pd.DataFrame()
        
        # fill class variables
        self.getMetaData()
        self.loadTrainingData()
        
        # unused        
        affinity_trainHist = pd.read_csv(Dataset.filepath + 'affinity_trainHist.csv', header=None)        
        labelsTrain = pd.read_csv(Dataset.filepath + 'labelsTrain.csv')
        namesAttributes = pd.read_csv(Dataset.filepath + 'namesAttributes.csv', header=None)
        namesLabel = pd.read_csv(Dataset.filepath + 'namesLabel.csv', header=None)


    # called by therapyrecommender
    def create(self, vis, vdb):        
        self.loadCurrentData(vis, vdb)
        self.matchTrainingData()
        
    
    # get statistics of database
    def getMetaData(self):
        # load from local repository
        rngAttributesTrain = pd.read_csv(Dataset.filepath + 'rngAttributesTrain.csv')        
        Dataset.featureRange = rngAttributesTrain
    
    
    # load static training data (from local repository)
    def loadTrainingData(self):
        ### load from local repository        
        dsAttributesTrain = pd.read_csv(Dataset.filepath + 'dsAttributesTrain.csv')             # attributes        
        typeAttributesTrain = pd.read_csv(Dataset.filepath + 'typeAttributesTrain.csv')         # attribute type
        dsInfoTrain = pd.read_csv(Dataset.filepath + 'dsInfoTrain.csv')                         # visitIDs, patientIDs, numVisits
        affinity_trainAll = pd.read_csv(Dataset.filepath + 'affinity_trainAll.csv', header=None) # affinityHistAll        
        dsTherapieAppliedSystTrain = pd.read_csv(Dataset.filepath + 'dsTherapieAppliedSystTrain.csv') # UAW, Wirksamkeit, DeltaPasi 
        dsTherapieAppliedSystHistTrain = pd.read_csv(Dataset.filepath + 'dsTherapieAppliedSystHistTrain.csv') # UAWHist, WirksamkeitHist, DeltaPasiHist
        ### adjust        
        dsAttributesTrain.set_index(dsInfoTrain['Visite'], inplace=True)            # index = visitIDs
        typeAttributesTrain.loc[:, typeAttributesTrain.isin([2,3]).values[0]] += 1  # type = type+1
        typeAttributesTrain.loc[:, ['Geschlecht']] = 2                              # type nominal = 2
        affinity_trainAll = affinity_trainAll.T                                     # same format as attributes
        affinity_trainAll.set_index(dsInfoTrain['Visite'], inplace=True)            # index = visitIDs 
        dsTherapieAppliedSystTrain.set_index(dsInfoTrain['Visite'], inplace=True)   # index = visitIDs
        dsTherapieAppliedSystHistTrain.set_index(dsInfoTrain['Visite'], inplace=True)   # index = visitIDs
        ### -> class variables
        Dataset.trainData_static = dsAttributesTrain
        Dataset.trainTypes_static = typeAttributesTrain
        Dataset.trainInfo_static = dsInfoTrain
        Dataset.trainAffinityAll_static = affinity_trainAll
        ### get history of outcome measures -> class variables
        s = time.time()
        UAWNew = dsTherapieAppliedSystTrain.filter(regex='UAW').copy()
        WirksamkeitNew = dsTherapieAppliedSystTrain.filter(regex='Wirksamkeit').copy()
        DeltaPasiNew = dsTherapieAppliedSystTrain.filter(regex='DeltaPasi').copy()
        UAWHist = dsTherapieAppliedSystHistTrain.filter(regex='UAW').copy()
        WirksamkeitHist = dsTherapieAppliedSystHistTrain.filter(regex='Wirksamkeit').copy()
        DeltaPasiHist = dsTherapieAppliedSystHistTrain.filter(regex='DeltaPasi').copy()
        Dataset.trainUAWAll_static = self.getAll(UAWNew, UAWHist, dsInfoTrain, dsInfoTrain['Visite'])
        Dataset.trainWirksamkeitAll_static = self.getAll(WirksamkeitNew, WirksamkeitHist, dsInfoTrain, dsInfoTrain['Visite'])
        Dataset.trainDeltaPasiAll_static = self.getAll(DeltaPasiNew, DeltaPasiHist, dsInfoTrain, dsInfoTrain['Visite'])
        e = time.time()
        print('--getHist:', e-s)
    
    def merge(self, data_current, data_hist):
        pass
    
    # load data of current visit (from DB)
    def loadCurrentData(self, vis, vdb):
        ### load from local repository
        dsAttributesTrain = pd.read_csv(Dataset.filepath + 'dsAttributesTrain.csv')             # attributes 
        typeAttributesTrain = pd.read_csv(Dataset.filepath + 'typeAttributesTrain.csv')         # attribute type
        dsInfoTrain = pd.read_csv(Dataset.filepath + 'dsInfoTrain.csv')                         # visitIDs, patientIDs, numVisits
        affinity_trainAll = pd.read_csv(Dataset.filepath + 'affinity_trainAll.csv', header=None) # affinityHistAll
        dsTherapieAppliedSystTrain = pd.read_csv(Dataset.filepath + 'dsTherapieAppliedSystTrain.csv') # UAW, Wirksamkeit, DeltaPasi 
        dsTherapieAppliedSystHistTrain = pd.read_csv(Dataset.filepath + 'dsTherapieAppliedSystHistTrain.csv') # UAWHist, WirksamkeitHist, DeltaPasiHist
        ### adjust        
        dsAttributesTrain.set_index(dsInfoTrain['Visite'], inplace=True)            # index = visitIDs
        typeAttributesTrain.loc[:, typeAttributesTrain.isin([2,3]).values[0]] += 1  # type = type+1
        typeAttributesTrain.loc[:, ['Geschlecht']] = 2                              # type nominal = 2
        affinity_trainAll = affinity_trainAll.T                                     # same format as attributes
        affinity_trainAll.set_index(dsInfoTrain['Visite'], inplace=True)            # index = visitIDs
        dsTherapieAppliedSystTrain.set_index(dsInfoTrain['Visite'], inplace=True)   # index = visitIDs
        dsTherapieAppliedSystHistTrain.set_index(dsInfoTrain['Visite'], inplace=True)   # index = visitIDs
        ### load info of current visit
        vis.loadVisitInfo(vdb)
        ### extract data of current visit
        self.currentData = dsAttributesTrain.loc[dsAttributesTrain.index == vis.visitID]
        self.currentTypes = typeAttributesTrain
        self.currentInfo = dsInfoTrain.loc[dsInfoTrain['Patient'] == vis.patientID]
        self.currentID = dsInfoTrain.loc[dsInfoTrain['Visite'] == vis.visitID]
        self.currentAffinityAll = affinity_trainAll.loc[affinity_trainAll.index == vis.visitID]
        ### weights of features
        self.currentWeights = pd.DataFrame(np.ones([1, self.currentData.shape[1]]), columns=self.currentData.columns)
        ### get history of outcome measures for current patient
        UAWNew = dsTherapieAppliedSystTrain.filter(regex='UAW').copy()
        WirksamkeitNew = dsTherapieAppliedSystTrain.filter(regex='Wirksamkeit').copy()
        DeltaPasiNew = dsTherapieAppliedSystTrain.filter(regex='DeltaPasi').copy()
        UAWHist = dsTherapieAppliedSystHistTrain.filter(regex='UAW').copy()
        WirksamkeitHist = dsTherapieAppliedSystHistTrain.filter(regex='Wirksamkeit').copy()
        DeltaPasiHist = dsTherapieAppliedSystHistTrain.filter(regex='DeltaPasi').copy()
        self.currentUAWAll = self.getAll(UAWNew, UAWHist, self.currentInfo, self.currentID['Visite'])
        self.currentWirksamkeitAll = self.getAll(WirksamkeitNew, WirksamkeitHist, self.currentInfo, self.currentID['Visite'])
        self.currentDeltaPasiAll = self.getAll(DeltaPasiNew, DeltaPasiHist, self.currentInfo, self.currentID['Visite'])

                
    # adjust training data to current data format
    def matchTrainingData(self):
        # remove current patient from training data
        mask = pd.Series(~Dataset.trainInfo_static['Patient'].isin(self.currentID['Patient'].values))
        self.trainData = Dataset.trainData_static[mask.values]
        self.trainTypes = Dataset.trainTypes_static
        self.trainInfo = Dataset.trainInfo_static[mask.values]
        
        # match attributes
        self.trainData = self.trainData.loc[:, self.currentData.columns]
        self.trainTypes = self.trainTypes.loc[:, self.currentTypes.columns]
        
    
    # combine current and historical <outcome>
    def getAll(self, data, data_hist, info, IDs):
        df_new = pd.DataFrame()
        # for each given visitID
        for visitID in IDs:
            # get current patient ID and number of visit
            patientID = np.asscalar(info.loc[info['Visite']==visitID, 'Patient'].values)
            numVisit = np.asscalar(info.loc[info['Visite']==visitID, 'numVisite'].values)
            # get the current & all previous visits of patient
            ishist = (info['Patient'].values==patientID) * (info['numVisite'].values<=numVisit)
            info_hist = info.loc[ishist, :].copy()
            info_hist.sort_values(by=['numVisite'], ascending=True, inplace=True)
            # nan array
            data_new = np.empty([1, data.shape[1]])
            data_new.fill(np.nan)
            # merge current & previous <outcome>
            for vid in info_hist['Visite']:                
                # get data
                data_vid = data.loc[vid, :].values
                # only overwrite with new values != nan 
                mask = ~np.isnan(data_vid)
                np.place(data_new, mask, data_vid[mask])
            # merge with historical <outcome>
            data_hist_vid = data_hist.loc[visitID, :].values
            data_hist_vid_15 = data_hist_vid[0:15]
            mask = ~np.isnan(data_new)
            np.place(data_hist_vid_15, mask, data_new[mask])
            data_hist_vid = data_hist_vid.reshape((1, data_hist_vid.shape[0]))
            data_all = pd.DataFrame(data_hist_vid, index=[visitID], columns=data_hist.columns)
            # append
            df_new = pd.concat([df_new, data_all], axis=0)           
        return df_new
                
        
    # manual update of training data (from DB)
    def updateTrainingData(self):
        pass

        
