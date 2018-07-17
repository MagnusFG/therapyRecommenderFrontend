import MySQLdb

class VisitDatabase:
        
    def __init__(self, config_db):
        
        self.host       = config_db["host"]
        self.port       = config_db["port"]
        self.user       = config_db["user"]
        self.passwd     = config_db["passwd"]
        self.db         = config_db["db"]
        self.charset    = config_db["charset"]
    
    def connect(self):
        self.conn = MySQLdb.connect(host    = self.host,
                                    port    = self.port,
                                    user    = self.user,
                                    passwd  = self.passwd,
                                    db      = self.db,
                                    charset = self.charset)        
        self.cur = self.conn.cursor()        
    
    def disconnect(self):
        if self.conn:
           self.conn.close()