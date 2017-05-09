<?php

function show_patientendaten($disabled) {

    $select = 0;


// Daten Patient
    $patient = $_SESSION['idPatient'];
    $results = mysql_query("SELECT * FROM tblPatient WHERE IDPatient = $patient");
    $row = mysql_fetch_array($results);
    $geburtJahr = $row['GeburtJahr'];
    $erstdiagnoseJahr = $row['ErstdiagnoseJahr'];
    $geschlecht = $row['Geschlecht'];

// Daten Visite
    $visite = $_SESSION['idVisite'];
    $results = mysql_query("SELECT * FROM tblPatientendatenVisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $gewicht = $row['Gewicht'];
    $groesse = $row['Größe'];
    $familienstandJa = $row['FamilienstandJa'];
    $familienstandNein = $row['FamilienstandNein'];

    if (isset($row['Berufsstand'])) {
        $tmp = $row['Berufsstand'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenBerufsstand WHERE IDBerufsstand = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $berufsstand = $rowTmp['txtBerufsstand'];
        $berufsstand = $tmp;
    }

    if (isset($row['Bildungsstand'])) {
        $tmp = $row['Bildungsstand'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenBildungsstand WHERE IDBildungsstand = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $bildungsstand = $rowTmp['txtBildungsstand'];
        $bildungsstand = $tmp;
    }

    if (isset($row['Familienanamnese'])) {
        $tmp = $row['Familienanamnese'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenFamilienanamnese WHERE IDFamilienanamnese = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $familienanamnese = $rowTmp['txtFamilienanamnese'];
        $familienanamnese = $tmp;
    }

    if (isset($row['Kinderwunsch'])) {
        $tmp = $row['Kinderwunsch'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenKinderwunsch WHERE IDKinderwunsch = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $kinderwunsch = $rowTmp['txtKinderwunsch'];
        $kinderwunsch = $tmp;
    }

    if (isset($row['Psoriasistyp1'])) {
        $tmp = $row['Psoriasistyp1'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp WHERE IDPsoriasis = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $psoriasistyp1 = $rowTmp['txtTyp'];
        $psoriasistyp1 = $tmp;
    }

    if (isset($row['Psoriasistyp2'])) {
        $tmp = $row['Psoriasistyp2'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp WHERE IDPsoriasis = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $psoriasistyp2 = $rowTmp['txtTyp'];
        $psoriasistyp2 = $tmp;
    }

    if (isset($row['Psoriasistyp3'])) {
        $tmp = $row['Psoriasistyp3'];
//        $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp WHERE IDPsoriasis = $tmp");
//        $rowTmp = mysql_fetch_array($results);
//        $psoriasistyp3 = $rowTmp['txtTyp'];
        $psoriasistyp3 = $tmp;
    }
    ?>

    <?php
    // updated Patienteninformationen
    if (isset($_POST['speichern_patienteninformationen'])) {        
        
        if (isset($_POST['geburtJahr'])) {
            echo $_POST['geburtJahr'];
        }
        
        if (isset($_POST['Geschlecht'])) {
            echo $_POST['Geschlecht'];
        }
        
        
        
        
        
    }

    // set idPatient
    if (isset($_POST['speichern_diagnose'])) {
        echo "hallo2";
    }


    // updated Diagnose
    ?>

    <form class="questionblock" action="" method="post">
        <div class="panel panel-primary">

            <!-- Default panel contents -->
            <div style="float: right; margin: 5px">
                <button type="submit" class="btn btn-success btn-md" name="speichern_patienteninformationen" value="speichern_patienteninformationen"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
            </div>        
            <div class="panel-heading">
                Patienteninformationen:
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Geburtsjahr:</span>
                        <input type="number" name="geburtJahr"<?php echo $disabled; ?> value="<?php echo $geburtJahr; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Geschlecht:</span>
                        <div class="form-group">
                            <select name="Geschlecht"<?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                if ($geschlecht == 1) {
                                    echo "<option selected>männlich</option>";
                                    echo "<option>weiblich</option>";
                                } else {
                                    echo "<option>männlich</option>";
                                    echo "<option selected>weiblich</option>";
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
                        <span class="input-group-addon" id="basic-addon1">Gewicht (kg):</span>
                        <input type="number" <?php echo $disabled; ?> value="<?php echo $gewicht; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Größe (cm):</span>
                        <input type="number" <?php echo $disabled; ?> value="<?php echo $groesse; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->

            </br>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">In Partnerschaft lebend:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                if ($familienstandJa == 1) {
                                    echo "<option selected>ja</option>";
                                    echo "<option>nein</option>";
                                } elseif ($familienstandNein == 1) {
                                    echo "<option>ja</option>";
                                    echo "<option selected>nein</option>";
                                } else {
                                    echo "<option selected></option>";
                                    echo "<option>ja</option>";
                                    echo "<option>nein</option>";
                                }
                                ?> 
                            </select>
                        </div>    
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Kinderwunsch</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenKinderwunsch");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDKinderwunsch'];
                                    $nameTmp = $rowTmp['txtKinderwunsch'];
                                    if ($kinderwunsch == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div> 
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->

            </br>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Bildungsstand:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenBildungsstand");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDBildungsstand'];
                                    $nameTmp = $rowTmp['txtBildungsstand'];
                                    if ($bildungsstand == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div> 
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Berufsstand:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenBerufsstand");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDBerufsstand'];
                                    $nameTmp = $rowTmp['txtBerufsstand'];
                                    if ($berufsstand == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->

        </div>
    </form>

    <form class="questionblock" action="" method="post">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div style="float: right; margin: 5px">
                <button type="submit" class="btn btn-success btn-md" name="speichern_diagnose"  value="speichern_diagnose"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
            </div> 
            <div class="panel-heading">Diagnose:</div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Erstdiagnose:</span>
                        <input type="number" <?php echo $disabled; ?> value="<?php echo $erstdiagnoseJahr; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">                                                      <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Familienanamnese</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenFamilienanamnese");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDFamilienanamnese'];
                                    $nameTmp = $rowTmp['txtFamilienanamnese'];
                                    if ($familienanamnese == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div> 
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row --> 

            </br>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Psoriasistyp 1:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPsoriasis'];
                                    $nameTmp = $rowTmp['txtTyp'];
                                    if ($psoriasistyp1 == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
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
                        <span class="input-group-addon" id="basic-addon1">Psoriasistyp 2:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPsoriasis'];
                                    $nameTmp = $rowTmp['txtTyp'];
                                    if ($psoriasistyp2 == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
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
                        <span class="input-group-addon" id="basic-addon1">Psoriasistyp 3:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                $selected = '';
                                $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp");
                                echo "<option disabled selected value></option>";
                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                    $valTmp = $rowTmp['IDPsoriasis'];
                                    $nameTmp = $rowTmp['txtTyp'];
                                    if ($psoriasistyp3 == $valTmp) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                }
                                ?>
                            </select>
                        </div>    
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->     
        </div>
    </form>

    <form class="questionblock" action="" method="post">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Komorbiditäten:</div>

            <table class="table table-striped">

                <thead>
                    <tr>
                        <th>Komorbidität</th>
                        <th>Liegt vor</th>
                        <th>Wird behandelt</th>
                        <th>Erkrankungsfrei seit</th>
                        <th>Löschen</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $results = mysql_query("SELECT * FROM tblKomorbiditaetenVisite INNER JOIN tblKomorbiditaeten ON tblKomorbiditaetenVisite.Komorbidität = tblKomorbiditaeten.IDKomorbiditäten LEFT JOIN tblKomorbiditaetLiegtVor ON tblKomorbiditaetenVisite.LiegtVor = tblKomorbiditaetLiegtVor.IDLiegtVor WHERE Visite = $visite");
                    while ($row = mysql_fetch_array($results)) {
                        ?>
                        <tr>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php echo $row['txtLiegtVor'] ?></td>
                            <td><?php if ($row['WirdBehandelt']) echo "ja"; ?></td>
                            <td><?php echo $row['ErkrankungsfreiSeit'] ?></td>

                    <form class="questionblock" action="" method="post">

                        <td style="text-align: right;">
                            <button type="submit" class="btn btn-danger" name="loeschen[<?php echo $row['IDKomorbiditätenVisite'] ?>]" value="x" <?php echo $disabled; ?>>
                                <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                            </button>
                        </td>

                    </form>

                    </tr>

                    <?php
                }
                ?>
                </tbody>
            </table>

            </br>
            </br>

            <div style="margin: 5px;">
                <button class="btn btn-primary " type="button" data-toggle="collapse" data-target="#collapsePasiCalculator" aria-expanded="false" aria-controls="collapsePasiCalculator" <?php echo $disabled; ?>>
                    Komorbiditäten hinzufügen
                </button>            
            </div>

            <div class="collapse" id="collapsePasiCalculator">
                <div class="card card-block">

                    <?php
                    if ($select == 0) {
                        ?>

                        <form class="questionblock" style="margin: 0px" action="" method="post">
                            <!--<form action="" method="post">-->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Komorbidität:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="komorbiditaet">
                                                <option selected></option>
                                                <?php
                                                $selected = '';
                                                $results = mysql_query("SELECT * FROM tblKomorbiditaeten");
                                                echo "<option disabled selected value></option>";
                                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                                    $valTmp = $rowTmp['IDKomorbiditäten'];
                                                    $nameTmp = $rowTmp['Name'];
                                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Liegt vor:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="liegtvor">
                                                <option selected></option>
                                                <?php
                                                $selected = '';
                                                $results = mysql_query("SELECT * FROM tblKomorbiditaetLiegtVor");
                                                echo "<option disabled selected value></option>";
                                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                                    $valTmp = $rowTmp['IDLiegtVor'];
                                                    $nameTmp = $rowTmp['txtLiegtVor'];
                                                    echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
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
                                        <span class="input-group-addon" id="basic-addon1">Erkrankungsfrei seit:</span>
                                        <input type="number" value="" min="1900" max="2017" class="form-control" placeholder="" aria-describedby="basic-addon1" name="erkrankungsfrei">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Wird behandelt:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="wirdbehandelt">
                                                <option selected></option>
                                                <?php
                                                echo "<option disabled selected value></option>";
                                                echo "<option>ja</option>";
                                                echo "<option>nein</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->

                            </br>

                            <div class="row">
                                <div class="col-lg-6" style="text-align: right;">
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6" style="text-align: right;">
                                   <div style="margin: 5px;">
                                        <button type="submit" class="btn btn-success btn-md" name="speichern_komorbiditaet" value="Komorbidität speichern">
                                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->
                        </form>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>


    <?php
}
?>