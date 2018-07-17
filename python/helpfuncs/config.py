import configparser

def read():
    config = configparser.ConfigParser()
    config.read('config/config.ini')
    
    config_recom = {}
    config_db = {}
    config_tables = {}
    config_features = {}
    featureNames = []
    featureTypes = []
    
    try:
        # Recommender Settings
        config_recom["impute"]       = int(config['RECOMMENDER']['IMPUTE']) 
        config_recom["extended"]     = int(config['RECOMMENDER']['EXTENDED'])
        config_recom["prefilter"]    = int(config['RECOMMENDER']['PREFILTER'])
        config_recom["affinity_thr"] = float(config['RECOMMENDER']['AFFINITY_THR'])
        config_recom["rules"]        = int(config['RECOMMENDER']['RULES'])
        # Connection Settings
        config_db["host"]    = config['SQL']['HOST'] 
        config_db["port"]    = int(config['SQL']['PORT'])
        config_db["user"]    = config['SQL']['USER']
        config_db["passwd"]  = config['SQL']['PASSWD']
        config_db["db"]      = config['SQL']['DB']
        config_db["charset"] = config['SQL']['CHARSET']
        # Table Settings
        config_tables["patientdata"]        = config['TABLES']['PATIENTDATA'].split(',')
        config_tables["status"]             = config['TABLES']['STATUS'].split(',')
        config_tables["comorbidities"]      = config['TABLES']['COMORBIDITIES'].split(',')
        config_tables["therapyprevious"]    = config['TABLES']['THERAPYPREVIOUS'].split(',')
        config_tables["therapycurrent"]     = config['TABLES']['THERAPYCURRENT'].split(',') 
        # Feature Settings
        featureNames    = config['FEATURES']['NAMES'].split(',')
        featureTypes    = config['FEATURES']['TYPES'].split(',')       
        config_features = dict(zip(featureNames, featureTypes))
        
    except KeyError:
        print("ERROR: Configuration file incomplete.")
        
    if config_recom["impute"] < 0 or config_recom["impute"] > 2:
        config_recom["impute"] = 0
        
    if config_recom["extended"] < 0 or config_recom["extended"] > 1:
        config_recom["extended"] = 0
        
    if config_recom["prefilter"] < 1 or config_recom["prefilter"] > 100:
        config_recom["prefilter"] = 15
        
    if config_recom["affinity_thr"] < 0 or config_recom["affinity_thr"] > 1:
        config_recom["affinity_thr"] = 0.5
        
    if config_recom["rules"] < 0 or config_recom["rules"] > 4:
        config_recom["rules"] = 0
        
    return (config_recom, config_db, config_tables, config_features)

def write():
    config = configparser.ConfigParser()

    config['RECOMMENDER'] = {}
    config['RECOMMENDER']['IMPUTE']         = '1'
    config['RECOMMENDER']['EXTENDED']       = '1'
    config['RECOMMENDER']['PREFILTER']      = '25'
    config['RECOMMENDER']['AFFINITY_THR']   = '0.25'
    config['RECOMMENDER']['RULES']          = '2'

    config['SQL'] = {}
    config['SQL']['HOST']       = "e58259-mysql.services.easyname.eu" 
    config['SQL']['PORT']       = '3306'
    config['SQL']['USER']       = "u76520db2"
    config['SQL']['PASSWD']     = "yx64jvxk"
    config['SQL']['DB']         = "u76520db2"
    config['SQL']['CHARSET']    = "utf8"
    
    config['TABLES'] = {}
    config['TABLES']['PATIENTDATA']       = 'tblpatient,tblpatientendatenvisite'
    config['TABLES']['STATUS']            = 'tblpatienteneinschaetzungvisite,tblpasivisite,tbldlqivisite'
    config['TABLES']['COMORBIDITIES']     = 'tblkomorbiditaetenvisite'
    config['TABLES']['THERAPYPREVIOUS']   = 'tbltherapiejemals'
    config['TABLES']['THERAPYCURRENT']    = 'tbltherapiesvisitesystapplied'    
    
    config['FEATURES'] = {}
    config['FEATURES']['NAMES'] = 'GeburtJahr,ErstdiagnoseJahr,Geschlecht,Gewicht,Größe,Familienanamnese,Psoriasistyp1,Psoriasistyp2,Psoriasistyp3,FamilienstandJa,FamilienstandNein,Bildungsstand,Berufsstand,Kinderwunsch,SchwereGeschaetzt,PasiScore,DlqiScore,Komorbidität,LiegtVor,ErkrankungsfreiSeit,WirdBehandelt,Therapie,UAWJa,UAWNein,UAWja,UAWnein,Wirksamkeit'
    config['FEATURES']['TYPES'] = '4,4,2,4,4,3,2,2,2,1,1,2,2,2,3,4,4,2,2,4,1,2,1,1,1,1,3'
    
    with open('config/config.ini', 'w') as configfile: config.write(configfile)