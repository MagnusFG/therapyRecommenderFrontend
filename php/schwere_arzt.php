<?php

function show_schwere_arzt($disabled, $connection) {

    // Daten Visite
    $visite = $_SESSION['idVisite'];


    // updated Patienteninformationen
    if (isset($_POST['speichern_pasi'])) {

        // new patient
        $results = mysqli_query($connection, "SELECT * FROM tblpasivisite WHERE Visite = $visite");
        $row = mysqli_fetch_array($results);
        if (!isset($row['IDpasi'])) {
            $sql = mysqli_query($connection, "INSERT INTO tblpasivisite (Visite) VALUES ($visite)");
            $retval = mysqli_query($connection, $sql);
        }

        // pasi
        $val = '';
        if (isset($_POST['pasi']) AND $_POST['pasi'] != '') {
            $val = $_POST['pasi'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET PasiScore=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        } else {
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET PasiScore=null WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }

        // pasi details
        // Kopf/Hals
        $val = '';
        if (isset($_POST['pasiKopfRoetung'])) {
            $val = $_POST['pasiKopfRoetung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET HalsRötung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiKopfInfiltration'])) {
            $val = $_POST['pasiKopfInfiltration'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET HalsInfiltration=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiKopfSchuppung'])) {
            $val = $_POST['pasiKopfSchuppung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET HalsSchuppung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiKopfFlaeche'])) {
            $val = $_POST['pasiKopfFlaeche'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET HalsFläche=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }

        // Stamm
        $val = '';
        if (isset($_POST['pasiStammRoetung'])) {
            $val = $_POST['pasiStammRoetung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET StammRötung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiStammInfiltration'])) {
            $val = $_POST['pasiStammInfiltration'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET StammInfiltration=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiStammSchuppung'])) {
            $val = $_POST['pasiStammSchuppung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET StammSchuppung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiStammFlaeche'])) {
            $val = $_POST['pasiStammFlaeche'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET StammFläche=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }

        // Arme
        $val = '';
        if (isset($_POST['pasiArmeRoetung'])) {
            $val = $_POST['pasiArmeRoetung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET ArmeRötung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiArmeInfiltration'])) {
            $val = $_POST['pasiArmeInfiltration'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET ArmeInfiltration=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiArmeSchuppung'])) {
            $val = $_POST['pasiArmeSchuppung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET ArmeSchuppung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiArmeFlaeche'])) {
            $val = $_POST['pasiArmeFlaeche'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET ArmeFläche=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }

        // Beine
        $val = '';
        if (isset($_POST['pasiBeineRoetung'])) {
            $val = $_POST['pasiBeineRoetung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET BeineRötung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiBeineInfiltration'])) {
            $val = $_POST['pasiBeineInfiltration'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET BeineInfiltration=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiBeineSchuppung'])) {
            $val = $_POST['pasiBeineSchuppung'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET BeineSchuppung=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
        $val = '';
        if (isset($_POST['pasiBeineFlaeche'])) {
            $val = $_POST['pasiBeineFlaeche'];
            $sql = mysqli_query($connection, "UPDATE tblpasivisite SET BeineFläche=$val WHERE Visite = $visite");
            $retval = mysqli_query($connection, $sql);
        }
    }

    // load data
    $results = mysqli_query($connection, "SELECT * FROM tblpasivisite WHERE Visite = $visite");
    $row = mysqli_fetch_array($results);

    $pasi = $row['PasiScore'];

    $pasiKopfRoetung = $row['HalsRötung'];
    $pasiKopfInfiltration = $row['HalsInfiltration'];
    $pasiKopfSchuppung = $row['HalsSchuppung'];
    $pasiKopfFlaeche = $row['HalsFläche'];

    $pasiStammRoetung = $row['StammRötung'];
    $pasiStammInfiltration = $row['StammInfiltration'];
    $pasiStammSchuppung = $row['StammSchuppung'];
    $pasiStammFlaeche = $row['StammFläche'];

    $pasiArmeRoetung = $row['ArmeRötung'];
    $pasiArmeInfiltration = $row['ArmeInfiltration'];
    $pasiArmeSchuppung = $row['ArmeSchuppung'];
    $pasiArmeFlaeche = $row['ArmeFläche'];

    $pasiBeineRoetung = $row['BeineRötung'];
    $pasiBeineInfiltration = $row['BeineInfiltration'];
    $pasiBeineSchuppung = $row['BeineSchuppung'];
    $pasiBeineFlaeche = $row['BeineFläche'];
    ?>

    <form class="questionblock" method="post" id="section_einschaetzungarzt" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_einschaetzungarzt">

        <div class="panel panel-primary">

            <div style="float: right; margin: 5px">
                <button type="submit" class="btn btn-success btn-md" name="speichern_pasi" value="speichern_pasi"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
            </div> 

            <div class="panel-heading">Psoriasis Area and Severity Index (PASI):</div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">PASI Score:</span>
                        <input type="number" max="72" name="pasi"<?php echo $disabled; ?> value="<?php echo $pasi; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row -->     

            </br>
            </br>

            <div style="margin: 5px;">
                <button class="btn btn-primary " type="button" data-toggle="collapse" data-target="#collapsePasiCalculator" aria-expanded="false" aria-controls="collapsePasiCalculator" <?php echo $disabled; ?>>
                    PASI Score Detail
                </button>            
            </div>                

            <div class="collapse" id="collapsePasiCalculator">
                <div class="card card-block">

                    </br>

                    <p style="margin: 5px">Kopf / Hals:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select name="pasiKopfRoetung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiKopfRoetung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select name="pasiKopfInfiltration" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiKopfInfiltration == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select name="pasiKopfSchuppung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiKopfSchuppung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select name="pasiKopfFlaeche" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            if ($pasiKopfFlaeche == $valTmp) {
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

                    <p style="margin: 5px">Stamm:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select name="pasiStammRoetung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiStammRoetung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select name="pasiStammInfiltration" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiStammInfiltration == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select name="pasiStammSchuppung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiStammSchuppung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select name="pasiStammFlaeche" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            if ($pasiStammFlaeche == $valTmp) {
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

                    <p style="margin: 5px">Arme:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select name="pasiArmeRoetung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiArmeRoetung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select name="pasiArmeInfiltration" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiArmeInfiltration == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select name="pasiArmeSchuppung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiArmeSchuppung == $valTmp) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                        }
                                        ?>>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select name="pasiArmeFlaeche" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            if ($pasiArmeFlaeche == $valTmp) {
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

                    <p style="margin: 5px">Beine/Gesäß:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select name="pasiBeineRoetung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiBeineRoetung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select name="pasiBeineInfiltration" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiBeineInfiltration == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select name="pasiBeineSchuppung" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore LIMIT 5");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            if ($pasiBeineSchuppung == $valTmp) {
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
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select name="pasiBeineFlaeche" <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysqli_query($connection, "SELECT * FROM tblpasiscore");
                                        echo "<option selected value=NULL></option>";
                                        while ($rowTmp = mysqli_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            if ($pasiBeineFlaeche == $valTmp) {
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
            </div>
        </div>
    </form>

    <?php
}
?>