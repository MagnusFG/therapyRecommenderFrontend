<?php

function show_schwere_patient($disabled, $connection) {

    // Daten Visite
    $visite = $_SESSION['idVisite'];

    // updated Patienteneinschätzung
    if (isset($_POST['speichern_patienteneinschaetzung'])) {

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
    if (isset($_POST['speichern_dlqi'])) {

        // new patient
        $results = mysql_query("SELECT * FROM tbldlqivisite WHERE Visite = $visite");
        $row = mysql_fetch_array($results);
        if (!isset($row['IDPatienteneinschaetzung'])) {
            $sql = mysql_query("INSERT INTO tbldlqivisite (Visite) VALUES ($visite)");
            $retval = mysql_query($sql, $connection);
        }

        $val = '';
        if (isset($_POST['dlqi'])) {
            $val = $_POST['dlqi'];
            $sql = mysql_query("UPDATE tbldlqivisite SET DlqiScore=$val WHERE Visite = $visite");
            $retval = mysql_query($sql, $connection);
        }
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
                        <span class="input-group-addon" id="basic-addon1">Gesicht:</span>
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
    </form>


    <form class="questionblock" method="post" id="section_dlqi" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_dlqi">

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

                    <?php
                    if (isset($row['DLQIgejuckt_1'])) {
                        $tmp = $row['DLQIgejuckt_1'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>

                    <div class = "row">
                        <div class = "col-lg-6">
                            <div class = "input-group">
                                <span class = "input-group-addon" id = "basic-addon1">Bewertung:</span>
                                <div class = "form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">2. Wie sehr hat Ihre Hauterkrankung Sie in den vergangenen 7 Tagen verlegen oder befangen gemacht?</p>

                    <?php
                    if (isset($row['DLQIverlegen_2'])) {
                        $tmp = $row['DLQIverlegen_2'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>        

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>                                                        <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">3. Wie sehr hat Ihre Hauterkrankung Sie in den vergangenen 7 Tagen bei Einkäufen oder bei Haus- oder Gartenarbeit behindert?</p>

                    <?php
                    if (isset($row['DLQIbehindert_3'])) {
                        $tmp = $row['DLQIbehindert_3'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>           

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">4. Wie sehr hat Ihre Hauterkrankung die Wahl der Kleidung beeinflusst, die Sie in den vergangenen 7 Tagen getragen haben?</p>

                    <?php
                    if (isset($row['DLQIkleidung_4'])) {
                        $tmp = $row['DLQIkleidung_4'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>           

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">5. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Ihre Aktivitäten mit anderen Menschen oder Ihre Freizeitgestaltung beeinflusst?</p>

                    <?php
                    if (isset($row['DLQIaktivitäten_5'])) {
                        $tmp = $row['DLQIaktivitäten_5'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>          

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">6. Wie sehr hat Ihre Hauterkrankung es Ihnen in den vergangenen 7 Tagen erschwert, sportlich aktiv zu sein?</p>

                    <?php
                    if (isset($row['DLQIsport_6'])) {
                        $tmp = $row['DLQIsport_6'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>            

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">7. Hat Ihre Hauterkrankung in den vergangenen 7 Tagen dazu geführt, dass Sie ihrer beruflichen Tätigkeit nicht nachgehen oder nicht studieren konnten?</p>

                    <?php
                    if (isset($row['DLQIberuf_7'])) {
                        $tmp = $row['DLQIberuf_7'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>          

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">8. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Probleme im Umgang mit Ihrem Partner, Freunden oder Verwandten verursacht?</p>

                    <?php
                    if (isset($row['DLQIfreunde_8'])) {
                        $tmp = $row['DLQIfreunde_8'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>         

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">9. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Ihr Liebesleben beeinträchtigt?</p>

                    <?php
                    if (isset($row['DLQIliebe_9'])) {
                        $tmp = $row['DLQIliebe_9'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>           

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->

                    </br>

                    <p style="margin: 5px">10. Inwieweit war die Behandlung Ihrer Haut in den vergangenen 7 Tagen für Sie mit Problemen verbunden (z. B. weil die Behandlung Zeit in Anspruch nahm oder dadurch Ihr Haushalt unsauber wurde)?</p>

                    <?php
                    if (isset($row['DLQIbehandlung_10'])) {
                        $tmp = $row['DLQIbehandlung_10'];
                        $results = mysql_query("SELECT * FROM tblDlqiScore WHERE IDDlqiScore = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtDlqiScore'];
                    }
                    ?>           

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Bewertung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class = "form-control" id = "sel1">
                                        <?php
                                        echo "<option selected>$val</option>";
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon">
                                    <input type="checkbox" <?php echo $disabled; ?> aria-label="...">
                                </span>
                                <input type="text" disabled value="Frage betrifft mich nicht" class="form-control" aria-label="...">
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                      
                    </div><!-- /.row -->        

                </div>
            </div>
        </div>
    </div>
    </form>


    <?php
}
?>