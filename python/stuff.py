### TABLES ####################################################################

from helpfuncs import config
from VisitDatabase import VisitDatabase
from Visit import Visit
(config_recom, config_db, config_tables, config_features) = config.read()
vdb = VisitDatabase(config_db)
vdb.connect()
#vis = Visit()
#vis.visitID = 24
#vis.loadVisitInfo(vdb)
#query = "SELECT * FROM ((tblpatientendatenvisite INNER JOIN tblvisite ON tblpatientendatenvisite.Visite = tblvisite.IDVisite) INNER JOIN tblpatient ON tblvisite.Patient = tblpatient.IDPatient) WHERE tblvisite.Patient = 5 AND tblvisite.NumVisite = 3"
##query = "SELECT * FROM tblpatientendatenvisite WHERE tblvisite.Patient = 5 AND tblvisite.NumVisite = 3"
#query = "SELECT * FROM 	(tblvisite INNER JOIN (tblkomorbiditaeten INNER JOIN tblkomorbiditaetenvisite ON tblkomorbiditaeten.`IDKomorbiditäten`= tblkomorbiditaetenvisite.`Komorbidität`) ON tblvisite.IDVisite = tblkomorbiditaetenvisite.Visite) WHERE tblvisite.Patient = 5 AND tblvisite.NumVisite = 3"
#vdb.cur.execute(query)
#tblout = vdb.cur.fetchall()
#i = 0
#for description in vdb.cur.description:
#    vis.attributes[description[0]] = tblout[0][i]
#    i = i + 1
#vdb.cur.execute("SHOW TABLES")
#tblnames = vdb.cur.fetchall()
#tables = {}
#varnames = {}
#for x in range(0, len(tblnames)):
#    vdb.cur.execute("SELECT * FROM " + tblnames[x][0])
#    tables[tblnames[x][0]] = vdb.cur.fetchall()
#    varnames[tblnames[x][0]] = [description[0] for description in vdb.cur.description]
    
#vdb.cur.execute("SELECT * FROM tbldlqiscore")
#tbldlqiscore = vdb.cur.fetchall()
#tbldlqiscore_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tbldlqivisite") 
tbldlqivisite = vdb.cur.fetchall()
tbldlqivisite_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblinputinterface")
tblinputinterface = vdb.cur.fetchall()
tblinputinterface_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblkomorbiditaeten")
tblkomorbiditaeten = vdb.cur.fetchall()
tblkomorbiditaeten_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblkomorbiditaetentyp")
tblkomorbiditaetentyp = vdb.cur.fetchall()
tblkomorbiditaetentyp_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblkomorbiditaetenvisite")
tblkomorbiditaetenvisite = vdb.cur.fetchall()
tblkomorbiditaetenvisite_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblkomorbiditaetliegtvor")
tblkomorbiditaetliegtvor = vdb.cur.fetchall()
tblkomorbiditaetliegtvor_names = [description[0] for description in vdb.cur.description]
#
#vdb.cur.execute("SELECT * FROM tbllogin")
#tbllogin = vdb.cur.fetchall()
#
vdb.cur.execute("SELECT * FROM tblpasiscore")
tblpasiscore = vdb.cur.fetchall()
tblpasiscore_names = [description[0] for description in vdb.cur.description]

vdb.cur.execute("SELECT * FROM tblpasivisite")
tblpasivisite = vdb.cur.fetchall()
tblpasivisite_names = [description[0] for description in vdb.cur.description]

vdb.cur.execute("SELECT * FROM tblpatient")
tblpatient = vdb.cur.fetchall()
tblpatient_names = [description[0] for description in vdb.cur.description]

#vdb.cur.execute("SELECT * FROM tblpatientendatenberufsstand")
#tblpatientendatenberufsstand = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tblpatientendatenbildungsstand")
#tblpatientendatenbildungsstand = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tblpatientendatenfamilienanamnese")
#tblpatientendatenfamilienanamnese = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tblpatientendatenkinderwunsch")
#tblpatientendatenkinderwunsch = vdb.cur.fetchall()
#
vdb.cur.execute("SELECT * FROM tblpatientendatenpsoriasistyp")
tblpatientendatenpsoriasistyp = vdb.cur.fetchall()
tblpatientendatenpsoriasistyp_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblpatientendatenvisite")
tblpatientendatenvisite = vdb.cur.fetchall()
tblpatientendatenvisite_names = [description[0] for description in vdb.cur.description]

#vdb.cur.execute("SELECT * FROM tblpatienteneinschaetzungbehandlung")
#tblpatienteneinschaetzungbehandlung = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tblpatienteneinschaetzungschwere")
#tblpatienteneinschaetzungschwere = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tblpatienteneinschaetzungveraenderung")
#tblpatienteneinschaetzungveraenderung = vdb.cur.fetchall()
#
vdb.cur.execute("SELECT * FROM tblpatienteneinschaetzungvisite")
tblpatienteneinschaetzungvisite = vdb.cur.fetchall()
tblpatienteneinschaetzungvisite_names = [description[0] for description in vdb.cur.description]
#
#vdb.cur.execute("SELECT * FROM tblstationaeretherapie")
#tblstationaeretherapie = vdb.cur.fetchall()
#
vdb.cur.execute("SELECT * FROM tbltherapiejemals")
tbltherapiejemals = vdb.cur.fetchall()
tbltherapiejemals_names = [description[0] for description in vdb.cur.description]
#
#vdb.cur.execute("SELECT * FROM tbltherapiemasseinheit")
#tbltherapiemasseinheit = vdb.cur.fetchall()
#
vdb.cur.execute("SELECT * FROM tbltherapiename")
tbltherapiename = vdb.cur.fetchall()
tbltherapiename_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tbltherapiesvisitesystapplied")
tbltherapiesvisitesystapplied = vdb.cur.fetchall()
tbltherapiesvisitesystapplied_names = [description[0] for description in vdb.cur.description]
#
#vdb.cur.execute("SELECT * FROM tbltherapiesvisitesystlist")
#tbltherapiesvisitesystlist = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tbltherapiesvisitesystrecommended")
#tbltherapiesvisitesystrecommended = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tbltherapietyp")
#tbltherapietyp = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tbltherapieverabreichung")
#tbltherapieverabreichung = vdb.cur.fetchall()
#
#vdb.cur.execute("SELECT * FROM tbltherapievisite")
#tbltherapievisite = vdb.cur.fetchall()
#tbltherapievisite_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tbltherapiewirksamkeit")
tbltherapiewirksamkeit = vdb.cur.fetchall()
tbltherapiewirksamkeit_names = [description[0] for description in vdb.cur.description]
#
vdb.cur.execute("SELECT * FROM tblvisite")
tblvisite = vdb.cur.fetchall()
tblvisite_names = [description[0] for description in vdb.cur.description]

vdb.disconnect()

##### TBLINPUTINTERFACE #######################################################

#    def loadVisitFromDatabase(self, vis):
#        self.cur.execute("SELECT * FROM tblinputinterface")
#        tblinput = np.array(self.cur.fetchall())
#        
#        if tblinput.size and tblinput[0][1]>=0 and tblinput[0][2]>=0 and tblinput[0][3]>=0:
#            vis.visitID = tblinput[0][1]
#            vis.patientID = tblinput[0][2]
#            vis.numVisit = tblinput[0][3]
#            self.cur.execute("DELETE FROM tblinputinterface")
#            self.conn.commit()
#            return True        
#        else:
#            # no/insane request
#            self.cur.execute("DELETE FROM tblinputinterface")
#            self.conn.commit()
#            return False
            
#    def fetch_request(self):
#        sql = "SELECT * FROM tblinputinterface"
#        self.cur.execute(sql)
#        return self.cur.fetchall()
#    
#    def del_request(self):
#        sql = "DELETE FROM tblinputinterface"
#        self.cur.execute(sql)
#        self.conn.commit()

##### LOAD LOCAL DATA #########################################################
#affinity_trainAll   = np.genfromtxt('data/affinity_trainAll.csv',delimiter=',')
#affinity_trainHist  = np.genfromtxt('data/affinity_trainHist.csv',delimiter=',')
#dsAttributes        = np.genfromtxt('data/dsAttributes.csv',delimiter=',')
#dsInfo              = np.genfromtxt('data/dsInfo.csv',delimiter=',')
#rngAttributes       = np.genfromtxt('data/rngAttributes.csv',delimiter=',')
#typeAttributes      = np.genfromtxt('data/typeAttributes.csv',delimiter=',')

##### WRITE TABLE TO CSV ######################################################
#import csv
#vdb.cur.execute("SELECT * FROM ((tblpatientendatenvisite INNER JOIN tblvisite ON tblpatientendatenvisite.Visite = tblvisite.IDVisite) INNER JOIN tblpatient ON tblvisite.Patient = tblpatient.IDPatient) WHERE tblvisite.Patient = 5 AND tblvisite.NumVisite = 3")
#tbltherapiejemals = vdb.cur.fetchall()
#with open("test.csv","w") as outfile:
#    writer = csv.writer(outfile, quoting=csv.QUOTE_NONNUMERIC)
#    writer.writerow(col[0] for col in vdb.cur.description)
#    for row in vdb.cur:
#        writer.writerow(row)

##### former getFeatureRange ##################################################
#        for key in vis_tmp.attributes:
#            if not vis_tmp.attributes[key] == [None] * len(vis_tmp.attributes[key]):
#                #attributes_tmp = pd.DataFrame(vis_tmp.attributes[key])
#                # feature range
#                self.ranges.loc[key, 'min'] = min(x for x in vis_tmp.attributes[key] if x is not None)
#                self.ranges.loc[key, 'max'] = max(x for x in vis_tmp.attributes[key] if x is not None)
#                # measures of central tendency
#                #self.moct.loc[key, 'mode'] = mode(x for x in vis_tmp.attributes[key] if x is not None).mode[0]
#            else:
#                # feature range
#                self.ranges.loc[key, 'min'] = None
#                self.ranges.loc[key, 'max'] = None 
#                # measures of central tendency
#                #self.moct.loc[key, 'mode'] = None

##### former calcModGower #####################################################
#        gsc = pd.Series()
#        # for each column/visit in training data
#        for col in trainData:
#            score = pd.Series()
#            # for each feature
#            for index, _ in trainData.iterrows():
#                ### calculate feature similarity
#                dtype = self.currentTypes.loc[index, 0]
#                x_i = currentData.loc[index, 0]
#                x_j = trainData.loc[index, col]
#                # if both available
#                if not (pd.isnull(x_i) or pd.isnull(x_j)):
#                    ### if dichotomous                
#                    if dtype == 1:
#                        # if equal: feature similarity = 1
#                        if x_i == x_j:
#                            score[index] = 1                            
#                        # else: feature similarity = 0
#                        else:
#                            score[index] = 0
#                    ### if ordinal/interval/ratio
#                    elif dtype == 3 or dtype == 4:                    
#                        score[index] = 1 - abs(x_i - x_j)   
#
#            ### calculate overall similarity
#            if not score.empty:
#                if weights:
#                    div = 0
#                    # weights = pd.Series?
#                    for index in score:
#                        score[index] = score[index]*weights[index]
#                        div += weights[index]
#                    gsc[str(col)] = score.sum() / div
#                else:
#                    gsc[str(col)] = score.sum() / score.size
#            else:
#                gsc[str(col)] = 0
#        
#        gsc.sort_values(ascending=False, inplace=True)
#            
#        return gsc

##### former modifyFeatures x2 ################################################
#        ### feature normalization on 0-1 range
#        for index, row in data.iterrows():
#            dtype = self.currentTypes.loc[index, 0]
#            if dtype == 3 or dtype == 4:
#                for col, value in enumerate(row):
#                    value_new = (value - self.ranges_adj.loc[index, 'min'])/(self.ranges_adj.loc[index, 'max'] - self.ranges_adj.loc[index, 'min'])
#                    if trainIDs:
#                        data.loc[index, trainIDs["visitIDs"][col]] = value_new
#                    else:    
#                        data.loc[index, col] = value_new
#        return data
#
#        ### feature normalization on 0-1 range
#        data_tmp = pd.DataFrame()
#        for col in data:
#            data_new = data[col].sub(self.ranges_adj["min"])
#            data_new = data_new.div((self.ranges_adj["max"] - self.ranges_adj["min"]))
#            data_tmp[0] = data[col]            
#            data[col] = data_tmp.mask(self.currentTypes > 2, other=data_new, axis=0)
#        return data


#import numpy as np
#uaw = Dataset.trainData_static.filter(regex='UAW').values
#uaw[np.isnan(uaw)]=-12345
#uawhist = Dataset.trainUAWHist_static.values
#uawhist[np.isnan(uawhist)]=-12345
#uawvgl = uaw==uawhist
#wirk = Dataset.trainData_static.filter(regex='Wirksamkeit').values
#wirk[np.isnan(wirk)]=-12345
#wirkhist = Dataset.trainWirksamkeitHist_static.values
#wirkhist[np.isnan(wirkhist)]=-12345
#wirkvgl = wirk==wirkhist
#dpasi = Dataset.trainData_static.filter(regex='DeltaPasi').values
#dpasi[np.isnan(dpasi)]=-12345
#dpasihist = Dataset.trainDeltaPasiHist_static.values
#dpasihist[np.isnan(dpasihist)]=-12345
#dpasivgl = dpasi==dpasihist



    
    
    
    
    
    
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