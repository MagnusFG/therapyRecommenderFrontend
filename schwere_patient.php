<?php

function show_schwere_patient() {

    // Daten Visite
    $visite = $_SESSION['idVisite'];
    $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $zufriedenheit = $row['BehandlungZufriedenheit'];

    if (isset($row['BehandlungUmgesetzt'])) {
        $tmp = $row['BehandlungUmgesetzt'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungBehandlung WHERE IDPatienteneinschaetzungBehandlung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $behandlung = $rowTmp['txtPatienteneinschaetzungBehandlung'];
    }
    
    if (isset($row['SchwereGeschaetzt'])) {
        $tmp = $row['SchwereGeschaetzt'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungSchwere WHERE IDPatienteneinschaetzungSchwere = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $schwere = $rowTmp['txtPatienteneinschaetzungSchwere'];
    }    

    if (isset($row['HautveraenderungenGesicht'])) {
        $tmp = $row['HautveraenderungenGesicht'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungGesicht = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }
    
    if (isset($row['HautveraenderungenFuesse'])) {
        $tmp = $row['HautveraenderungenFuesse'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungFuesse = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }
    
    if (isset($row['HautveraenderungenNaegel'])) {
        $tmp = $row['HautveraenderungenNaegel'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungNaegel = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }

        if (isset($row['HautveraenderungenHaende'])) {
        $tmp = $row['HautveraenderungenHaende'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungHaende = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }
    
        if (isset($row['HautveraenderungenGenital'])) {
        $tmp = $row['HautveraenderungenGenital'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungGenital = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }    
    ?>

    <form class="questionblock" action="" method="post">

        <p>Haben Sie die empfohlene Behandlung umgesetzt?</p>               

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Behandlung umgesetzt?</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$behandlung</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row -->     

        </br>

        <p>Wie schwer schätzen sie derzeit ihre Schuppenflechte?</p>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">geschätze Schwere: </span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$schwere</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                 
        </div><!-- /.row -->

        </br>
        </br>

        <p>Psoriatische Hautveränderungen an sensiblen Körperstellen:</p> 

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Gesicht:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$veraenderungGesicht</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                  
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Füße:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$veraenderungFuesse</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->          
        </div><!-- /.row -->

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Nägel:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$veraenderungNaegel</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->           
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Hände:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$veraenderungHaende</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->              
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Genital:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            echo "<option selected>$veraenderungGenital</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->          
        </div><!-- /.row --> 

    </form>

    <?php
}
?>