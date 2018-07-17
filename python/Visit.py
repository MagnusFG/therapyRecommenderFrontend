

class Visit:
    
    tables = {}
    features = {}
    
    def __init__(self):
        
        self.patientID = 0
        self.numVisit = 0
        self.visitID = 0
        self.attributes = {}
        self.typeAttributes = {}
        self.preVisits = []
        self.nextVisits = []
        
                                       
    def loadVisitData(self, vdb, single=None):
        # for each section of tables
        for section in self.tables:
            # for each corresponding table
            for tblname in self.tables[section]:                
                
                ### build query 
                query = "SELECT * FROM " + tblname
                # if only one visit
                if single:
                    query = query + " WHERE " + tblname                                    
                    if tblname == "tblpatient":
                        query = query + ".IDPatient = " + str(self.patientID)                   
                    elif tblname == "tbltherapiejemals":
                        query = query + ".Patient = " + str(self.patientID)                    
                    else:
                        query = query + ".Visite = " + str(self.visitID)
                        
                ### execute query and fetch data    
                vdb.cur.execute(query)
                tblout = vdb.cur.fetchall()
                
                ### extract features
                # for each attribute in table
                for numFeat, description in enumerate(vdb.cur.description):
                    # if feature is required                       
                    if description[0] in self.features.keys():
                        # build feature key
                        key = section + ": " + description[0]
                        # init. feature
                        self.attributes[key] = []
                        # if table exists for current visit
                        if tblout:
                            for row in range(len(tblout)):
                                self.attributes[key].append(tblout[row][numFeat])
                        else:
                            self.attributes[key].append(None)
                        # get measurement level of feature 
                        self.typeAttributes[key] = int(self.features[description[0]])
 
                       
    def saveVisitData(self, vdb):
        pass

    
    def loadVisitInfo(self, vdb):  
        # load missing values of patientID, numVisit and visitID 
        # fetch all previous & next visitIDs of current patient
        # add option of defining patientID & numVisit / visitID / all of them within function call??? (e.g. (self, vdb, *args))       
        if not self.patientID and self.visitID:
            # load patientID and numVisit
            query = "SELECT tblvisite.Patient, tblvisite.NumVisite FROM tblvisite WHERE tblvisite.IDVisite = " + str(self.visitID)
            vdb.cur.execute(query)
            tblout = vdb.cur.fetchall()
            self.patientID = tblout[0][0]
            self.numVisit = tblout[0][1]

        elif not self.visitID and self.patientID:
            # load visitID
            query = "SELECT tblvisite.IDVisite FROM tblvisite WHERE tblvisite.Patient = " + str(self.patientID) + " AND tblvisite.NumVisite = " + str(self.numVisit)
            vdb.cur.execute(query)
            tblout = vdb.cur.fetchall()
            self.visitID = tblout[0][0]

        if self.patientID and self.visitID:
            # load previous visitIDs
            query = "SELECT tblvisite.IDVisite FROM tblvisite WHERE tblvisite.Patient = " + str(self.patientID) + " AND tblvisite.NumVisite < " + str(self.numVisit)
            vdb.cur.execute(query)
            tblout = vdb.cur.fetchall()
            for entry in tblout:
                if entry[0] not in self.preVisits:
                    self.preVisits.append(entry[0])
            # load next visitIDs
            query = "SELECT tblvisite.IDVisite FROM tblvisite WHERE tblvisite.Patient = " + str(self.patientID) + " AND tblvisite.NumVisite > " + str(self.numVisit)
            vdb.cur.execute(query)
            tblout = vdb.cur.fetchall()
            for entry in tblout:
                if entry[0] not in self.nextVisits:
                    self.nextVisits.append(entry[0])                    
        else:
            print("Error: patientID, numVisit and visitID not yet defined")

    
    def saveVisitInfo(self, vdb):
        pass

        
    def newVisit(self):    
        pass