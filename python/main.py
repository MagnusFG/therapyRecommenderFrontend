### Python Modules
import time
start = time.time()

### Project Modules
from VisitDatabase import VisitDatabase
from Visit import Visit
from Dataset import Dataset
from TherapyRecommender import TherapyRecommender
from helpfuncs import config

### READ SETTINGS
config.write()
(config_recom, config_db, config_tables, config_features) = config.read()

### START SESSION

# connecion
vdb = VisitDatabase(config_db)
vdb.connect()

# visit
#Visit.tables = config_tables
#Visit.features = config_features       
vis = Visit()

# dataset
print('*****DATASET*****')
s = time.time()
ds = Dataset()
e = time.time()
print('loadTrainingData:', e-s, '\n')

# recommender
recom = TherapyRecommender(config_recom)

#vis.patientID = 5
#vis.numVisit = 2
vis.visitID = 23

try:
    print('*****THERAPY RECOMMENDER*****')
    s = time.time()
    recom.doRecommendation(ds, vis, vdb)
    e = time.time()
    print('doRecommendation:', e-s)
except:
    print('some error')
    vdb.disconnect()


#import pandas as pd    
#ds = Dataset()
#recom = TherapyRecommender(config_recom)
#predictions = []
#ids = []    
#dsInfoTrain = pd.read_csv(Dataset.filepath + 'dsInfoTrain.csv')    
#
#for idv in dsInfoTrain['Visite']:
#    print('ID:', idv)
#    vis = Visit()
#    vis.visitID = idv
#    ids.append(idv)
#    predictions.append(recom.doRecommendation(ds, vis, vdb))     

                             
### END SESSION        
vdb.disconnect()

end = time.time()
print(end - start)