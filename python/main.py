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
# recominput
ds = Dataset()
# recommender
recom = TherapyRecommender(config_recom)

#vis.patientID = 5
#vis.numVisit = 3
vis.visitID = 23
#vis.loadVisitInfo(vdb)
#vis.loadVisitData(vdb)


try:
    recom.doRecommendation(ds, vis, vdb)
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
    
    
    
    
    
    
### doRecommendation for all visits
#import pandas as pd
#recoms = pd.DataFrame()
#for ID in recom.trainIDs["visitIDs"]:
#    print("\n", ID, "\n")
#    vis = Visit()
#    vis.visitID = ID
#    s = time.time()
#    recom.doRecommendation(vdb,vis)
#    e = time.time()
#    print("dorecom:",e-s)
#    recoms[ID] = recom.currentRecom


### doRecommendation for requested visit
#while True:
#    vis = Visit()
#    vdb.cur.execute("SELECT tblinputinterface.Visite FROM tblinputinterface")
#    ID = vdb.cur.fetchall()
#    if ID:    
#        vis.visitID = ID[0][0]
#        recom.doRecommendation(vdb, vis)
#        vdb.cur.execute("DELETE FROM tblinputinterface")
#        vdb.conn.commit()
#    else:
#        vdb.cur.execute("DELETE FROM tblinputinterface")
#        vdb.conn.commit()
#        print("no request")
#    time.sleep(4)
                             
### END SESSION        
vdb.disconnect()

end = time.time()
print(end - start)