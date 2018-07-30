import pandas as pd
import numpy as np

class Dataset:
    # filepath
    filepath = './data/impute_0/'    
    # attribute ranges
    featureRange = pd.DataFrame()    
    # training data
    trainData_static = pd.DataFrame()
    trainTypes_static = pd.DataFrame()
    trainInfo_static = pd.DataFrame()
    trainOutcome_static = pd.DataFrame()
    
    def __init__(self):
        # current visit 
        self.currentData = pd.DataFrame()
        self.currentTypes = pd.DataFrame()
        self.currentInfo = pd.DataFrame()
        self.currentID = pd.DataFrame()
        self.currentWeights = pd.DataFrame()
        self.currentOutcome = pd.DataFrame()
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
        # load from local repository
        dsAttributesTrain = pd.read_csv(Dataset.filepath + 'dsAttributesTrain.csv')
        typeAttributesTrain = pd.read_csv(Dataset.filepath + 'typeAttributesTrain.csv')
        dsInfoTrain = pd.read_csv(Dataset.filepath + 'dsInfoTrain.csv')
        affinity_trainAll = pd.read_csv(Dataset.filepath + 'affinity_trainAll.csv', header=None)
        # adjust        
        dsAttributesTrain.set_index(dsInfoTrain['Visite'], inplace=True)
        typeAttributesTrain.loc[:, typeAttributesTrain.isin([2,3]).values[0]] += 1
        typeAttributesTrain.loc[:, ['Geschlecht']] = 2
        affinity_trainAll = affinity_trainAll.T
        affinity_trainAll.set_index(dsInfoTrain['Visite'], inplace=True) 
        
        Dataset.trainData_static = dsAttributesTrain
        Dataset.trainTypes_static = typeAttributesTrain
        Dataset.trainInfo_static = dsInfoTrain
        Dataset.trainOutcome_static = affinity_trainAll
    
    
    # load data of current visit (from DB)
    def loadCurrentData(self, vis, vdb):
        # load from local repository
        dsAttributesTrain = pd.read_csv(Dataset.filepath + 'dsAttributesTrain.csv')
        typeAttributesTrain = pd.read_csv(Dataset.filepath + 'typeAttributesTrain.csv')
        dsInfoTrain = pd.read_csv(Dataset.filepath + 'dsInfoTrain.csv')
        affinity_trainAll = pd.read_csv(Dataset.filepath + 'affinity_trainAll.csv', header=None)
        # adjust        
        dsAttributesTrain.set_index(dsInfoTrain['Visite'], inplace=True)
        typeAttributesTrain.loc[:, typeAttributesTrain.isin([2,3]).values[0]] += 1
        typeAttributesTrain.loc[:, ['Geschlecht']] = 2
        affinity_trainAll = affinity_trainAll.T
        affinity_trainAll.set_index(dsInfoTrain['Visite'], inplace=True) 
       
        # load info of current visit
        vis.loadVisitInfo(vdb)
        # extract data of current visit
        self.currentData = dsAttributesTrain.loc[dsAttributesTrain.index == vis.visitID]
        self.currentTypes = typeAttributesTrain
        self.currentInfo = dsInfoTrain.loc[dsInfoTrain['Patient'] == vis.patientID]
        self.currentID = dsInfoTrain.loc[dsInfoTrain['Visite'] == vis.visitID]
        self.currentOutcome = affinity_trainAll.loc[affinity_trainAll.index == vis.visitID]
        
        self.currentWeights = pd.DataFrame(np.ones([1, self.currentData.shape[1]]), columns=self.currentData.columns)
        
                
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
        
        # matlab result visitID 23
        self.D_mat_23 = pd.read_csv(Dataset.filepath + 'D_matlab_23.csv')
        self.D_mat_23.columns = Dataset.trainInfo_static['Visite']
        self.D_mat_23 = self.D_mat_23.loc[:,mask.values]


    # manual update of training data (from DB)
    def updateTrainingData(self):
        pass

        
