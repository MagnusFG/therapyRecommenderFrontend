<?php

function show_schwere_patient($disabled, $connection) {

    // Daten Visite
    $visite = $_SESSION['idVisite'];

    // updated Patienteneinschätzung
    if (isset($_POST['speichern_patienteneinschaetzung']) OR isset($_POST['speichern_dlqi'])) {

        // new patient
        $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungvisite WHERE Visite = $visite");
        $row = mysql_fetch_array($results);
        if (!isset($row['IDPatienteneinschaetzung'])) {
            $sql = mysql_query("INSERT INTO tblpatienteneinschaetzungvisite (Visite) VALUES ($visite)");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['zufriedenheit'])) {
            $val = $_POST['zufriedenheit'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET BehandlungZufriedenheit=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['behandlung'])) {
            $val = $_POST['behandlung'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET BehandlungUmgesetzt=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['schwere'])) {
            $val = $_POST['schwere'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET SchwereGeschaetzt=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['veraenderungGesicht'])) {
            $val = $_POST['veraenderungGesicht'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET HautveraenderungenGesicht=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['veraenderungFuesse'])) {
            $val = $_POST['veraenderungFuesse'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET HautveraenderungenFuesse=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['veraenderungNaegel'])) {
            $val = $_POST['veraenderungNaegel'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET HautveraenderungenNaegel=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['veraenderungHaende'])) {
            $val = $_POST['veraenderungHaende'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET HautveraenderungenHaende=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['veraenderungGenital'])) {
            $val = $_POST['veraenderungGenital'];
            $sql = mysql_query("UPDATE tblpatienteneinschaetzungvisite SET HautveraenderungenGenital=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }
    }

    // updated dlqi
    if (isset($_POST['speichern_patienteneinschaetzung']) OR isset($_POST['speichern_dlqi'])) {

        // new patient
        $results = mysql_query("SELECT * FROM tbldlqivisite WHERE Visite = $visite");
        $row = mysql_fetch_array($results);
        if (!isset($row['IDPatienteneinschaetzung'])) {
            $sql = mysql_query("INSERT INTO tbldlqivisite (Visite) VALUES ($visite)");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['dlqi']) AND $_POST['dlqi'] != '') {
            $val = $_POST['dlqi'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DlqiScore=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        } else {
            $sql = mysql_query("UPDATE tbldlqivisite SET DlqiScore=null WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['DLQIgejuckt_1'])) {
            $val = $_POST['DLQIgejuckt_1'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIgejuckt_1=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['DLQIverlegen_2'])) {
            $val = $_POST['DLQIverlegen_2'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIverlegen_2=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['DLQIbehindert_3'])) {
            $val = $_POST['DLQIbehindert_3'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIbehindert_3=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_3'])) {
            $val = $_POST['BetrifftNicht_3'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_3=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIkleidung_4'])) {
            $val = $_POST['DLQIkleidung_4'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIkleidung_4=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_4'])) {
            $val = $_POST['BetrifftNicht_4'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_4=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIaktivitäten_5'])) {
            $val = $_POST['DLQIaktivitäten_5'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIaktivitäten_5=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_5'])) {
            $val = $_POST['BetrifftNicht_5'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_5=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIsport_6'])) {
            $val = $_POST['DLQIsport_6'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIsport_6=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_6'])) {
            $val = $_POST['BetrifftNicht_6'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_6=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIberuf_7'])) {
            $val = $_POST['DLQIberuf_7'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIberuf_7=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_7'])) {
            $val = $_POST['BetrifftNicht_7'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_7=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIfreunde_8'])) {
            $val = $_POST['DLQIfreunde_8'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIfreunde_8=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_8'])) {
            $val = $_POST['BetrifftNicht_8'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_8=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIliebe_9'])) {
            $val = $_POST['DLQIliebe_9'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIliebe_9=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_9'])) {
            $val = $_POST['BetrifftNicht_9'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_9=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);

        $val = '';
        if (isset($_POST['DLQIbehandlung_10'])) {
            $val = $_POST['DLQIbehandlung_10'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DLQIbehandlung_10=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['BetrifftNicht_10'])) {
            $val = $_POST['BetrifftNicht_10'];
        } else {
            $val = 0;
        }
        $sql = mysql_query("UPDATE tbldlqivisite SET BetrifftNicht_10=$val WHERE Visite = $visite");
        $retval = mysql_query($sql, $connection);
    }

    // load data: patienteneinschätzung
    $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungvisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $zufriedenheit = $row['BehandlungZufriedenheit'];
    $behandlung = $row['BehandlungUmgesetzt'];
    $schwere = $row['SchwereGeschaetzt'];
    $veraenderungGesicht = $row['HautveraenderungenGesicht'];
    $veraenderungFuesse = $row['HautveraenderungenFuesse'];
    $veraenderungNaegel = $row['HautveraenderungenNaegel'];
    $veraenderungHaende = $row['HautveraenderungenHaende'];
    $veraenderungGenital = $row['HautveraenderungenGenital'];

    // load data: dlqi
    $results = mysql_query("SELECT * FROM tbldlqivisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $dlqi = $row['DlqiScore'];
    $DLQIgejuckt_1 = $row['DLQIgejuckt_1'];
    $DLQIverlegen_2 = $row['DLQIverlegen_2'];
    $DLQIbehindert_3 = $row['DLQIbehindert_3'];
    $BetrifftNicht_3 = $row['BetrifftNicht_3'];
    $DLQIkleidung_4 = $row['DLQIkleidung_4'];
    $BetrifftNicht_4 = $row['BetrifftNicht_4'];
    $DLQIaktivitäten_5 = $row['DLQIaktivitäten_5'];
    $BetrifftNicht_5 = $row['BetrifftNicht_5'];
    $DLQIsport_6 = $row['DLQIsport_6'];
    $BetrifftNicht_6 = $row['BetrifftNicht_6'];
    $DLQIberuf_7 = $row['DLQIberuf_7'];
    $BetrifftNicht_7 = $row['BetrifftNicht_7'];
    $DLQIfreunde_8 = $row['DLQIfreunde_8'];
    $BetrifftNicht_8 = $row['BetrifftNicht_8'];
    $DLQIliebe_9 = $row['DLQIliebe_9'];
    $BetrifftNicht_9 = $row['BetrifftNicht_9'];
    $DLQIbehandlung_10 = $row['DLQIbehandlung_10'];
    $BetrifftNicht_10 = $row['BetrifftNicht_10'];
    ?>

    <form class="questionblock" method="post" id="section_einschaetzungpatient" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_einschaetzungpatient">

        <div class="panel panel-primary">

            <div style="float: right; margin: 5px">
                <button type="submit" class="btn btn-success btn-md" name="speichern_patienteneinschaetzung" value="speichern_patienteneinschaetzung"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
            </div> 

            <div class="panel-heading">Patienteneinschätzung:</div>

            <p style="margin: 5px">Haben Sie die empfohlene Behandlung umgesetzt?</p>               

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Behandlung umgesetzt?</span>
                        <div class="form-group">
                            <select name="behandlung"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungbehandlung");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungBehandlung'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungBehandlung'];
                                    if ($behandlung == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row -->     

            </br>

            <p style="margin: 5px">Wie schwer schätzen sie derzeit ihre Schuppenflechte?</p>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">geschätze Schwere: </span>
                        <div class="form-group">
                            <select name="schwere"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungschwere");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungSchwere'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungSchwere'];
                                    if ($schwere == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                 
            </div><!-- /.row -->

            </br>

            <p style="margin: 5px">Psoriatische Hautveränderungen an sensiblen Körperstellen:</p> 

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Gesicht/behaarter Kopf:</span>
                        <div class="form-group">
                            <select name="veraenderungGesicht"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungveraenderung");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungVeraenderung'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
                                    if ($veraenderungGesicht == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                  
            </div><!-- /.row --> 

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Füße:</span>
                        <div class="form-group">
                            <select name="veraenderungFuesse"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungveraenderung");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungVeraenderung'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
                                    if ($veraenderungFuesse == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->          
            </div><!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Nägel:</span>
                        <div class="form-group">
                            <select name="veraenderungNaegel"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungveraenderung");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungVeraenderung'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
                                    if ($veraenderungNaegel == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->           
            </div><!-- /.row --> 

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Hände:</span>
                        <div class="form-group">
                            <select name="veraenderungHaende"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungveraenderung");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungVeraenderung'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
                                    if ($veraenderungHaende == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->              
            </div><!-- /.row --> 

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Genital:</span>
                        <div class="form-group">
                            <select name="veraenderungGenital"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblpatienteneinschaetzungveraenderung");
                                echo "<option selected value=NULL></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPatienteneinschaetzungVeraenderung'];
                                    $nameTmp = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
                                    if ($veraenderungGenital == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->          
            </div><!-- /.row --> 
        </div>

        <div class="panel panel-primary">
            <div style="float: right; margin: 5px">
                <button type="submit" class="btn btn-success btn-md" name="speichern_dlqi" value="speichern_dlqi"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
            </div> 

            <div class="panel-heading">Dermatology Life Quality Index (DLQI):</div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">DLQI Score:</span>
                        <input type="number" name="dlqi"<?php echo $disabled; ?> value="<?php echo $dlqi; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row -->     

            </br>
            </br>

            <p style="margin: 5px">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsePasiCalculator" aria-expanded="false" aria-controls="collapsePasiCalculator" <?php echo $disabled; ?>>
                    DLQI Score Detail
                </button>
            </p>

            <div class="collapse" id="collapsePasiCalculator">
                <div class="card card-block">

                    </br>

                    <p style="margin: 5px">1. Wie sehr hat Ihre Haut in den vergangenen 7 Tagen gejuckt, war wund, hat geschmerzt oder gebrannt?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIgejuckt_1"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIgejuckt_1 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>                                                        <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->                     

                    </br>

                    <p style="margin: 5px">2. Wie sehr hat Ihre Hauterkrankung Sie in den vergangenen 7 Tagen verlegen oder befangen gemacht?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIverlegen_2"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIverlegen_2 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>                                                        <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">3. Wie sehr hat Ihre Hauterkrankung Sie in den vergangenen 7 Tagen bei Einkäufen oder bei Haus- oder Gartenarbeit behindert?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIbehindert_3"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIbehindert_3 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_3 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                     
                                    <input type="checkbox" value=1 name="BetrifftNicht_3"<?php
                                    echo $disabled;
                                    echo $checked;
                                    ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">4. Wie sehr hat Ihre Hauterkrankung die Wahl der Kleidung beeinflusst, die Sie in den vergangenen 7 Tagen getragen haben?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIkleidung_4"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIkleidung_4 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_4 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                     
                                    <input type="checkbox" value=1 name="BetrifftNicht_4"<?php
                                           echo $disabled;
                                           echo $checked;
                                           ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">5. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Ihre Aktivitäten mit anderen Menschen oder Ihre Freizeitgestaltung beeinflusst?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIaktivitäten_5"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIaktivitäten_5 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_5 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                     
                                    <input type="checkbox" value=1 name="BetrifftNicht_5"<?php
                                echo $disabled;
                                echo $checked;
                                ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">6. Wie sehr hat Ihre Hauterkrankung es Ihnen in den vergangenen 7 Tagen erschwert, sportlich aktiv zu sein?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIsport_6"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIsport_6 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_6 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                     
                                    <input type="checkbox" value=1 name="BetrifftNicht_6"<?php
                                       echo $disabled;
                                       echo $checked;
                                       ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">7. Hat Ihre Hauterkrankung in den vergangenen 7 Tagen dazu geführt, dass Sie ihrer beruflichen Tätigkeit nicht nachgehen oder nicht studieren konnten?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIberuf_7"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIberuf_7 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_7 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                     
                                    <input type="checkbox" value=1 name="BetrifftNicht_7"<?php
                                    echo $disabled;
                                    echo $checked;
                                    ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">8. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Probleme im Umgang mit Ihrem Partner, Freunden oder Verwandten verursacht?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIfreunde_8"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIfreunde_8 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_8 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                     
                                    <input type="checkbox" value=1 name="BetrifftNicht_8"<?php
                                    echo $disabled;
                                    echo $checked;
                                    ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">9. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Ihr Liebesleben beeinträchtigt?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIliebe_9"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIliebe_9 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_9 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                      
                                    <input type="checkbox" value=1 name="BetrifftNicht_9"<?php
                                    echo $disabled;
                                    echo $checked;
                                    ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">10. Inwieweit war die Behandlung Ihrer Haut in den vergangenen 7 Tagen für Sie mit Problemen verbunden (z. B. weil die Behandlung Zeit in Anspruch nahm oder dadurch Ihr Haushalt unsauber wurde)?</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select name="DLQIbehandlung_10"<?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tbldlqiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['IDdlqiScore'];
                                            $nameTmp = $rowTmp['txtDlqiScore'];
                                            if ($DLQIbehandlung_10 == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <?php
                                    if ($BetrifftNicht_10 == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>                                    
                                    <input type="checkbox" value=1 name="BetrifftNicht_10"<?php
                                    echo $disabled;
                                    echo $checked;
                                    ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->        

                </div>
            </div>
        </div>
    </form>


    <?php
}
?>