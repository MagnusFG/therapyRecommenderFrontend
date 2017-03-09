<?php

function show_patientendaten() {

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
        $results = mysql_query("SELECT * FROM tblPatientendatenBerufsstand WHERE IDBerufsstand = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $berufsstand = $rowTmp['txtBerufsstand'];
    }

    if (isset($row['Bildungsstand'])) {
        $tmp = $row['Bildungsstand'];
        $results = mysql_query("SELECT * FROM tblPatientendatenBildungsstand WHERE IDBildungsstand = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $bildungsstand = $rowTmp['txtBildungsstand'];
    }

    if (isset($row['Familienanamnese'])) {
        $tmp = $row['Familienanamnese'];
        $results = mysql_query("SELECT * FROM tblPatientendatenFamilienanamnese WHERE IDFamilienanamnese = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $familienanamnese = $rowTmp['txtFamilienanamnese'];
    }

    if (isset($row['Kinderwunsch'])) {
        $tmp = $row['Kinderwunsch'];
        $results = mysql_query("SELECT * FROM tblPatientendatenKinderwunsch WHERE IDKinderwunsch = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $kinderwunsch = $rowTmp['txtKinderwunsch'];
    }

    if (isset($row['Psoriasistyp1'])) {
        $tmp = $row['Psoriasistyp1'];
        $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp WHERE IDPsoriasis = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $psoriasistyp1 = $rowTmp['txtTyp'];
    }

    if (isset($row['Psoriasistyp2'])) {
        $tmp = $row['Psoriasistyp2'];
        $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp WHERE IDPsoriasis = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $psoriasistyp2 = $rowTmp['txtTyp'];
    }

    if (isset($row['Psoriasistyp3'])) {
        $tmp = $row['Psoriasistyp3'];
        $results = mysql_query("SELECT * FROM tblPatientendatenPsoriasistyp WHERE IDPsoriasis = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $psoriasistyp3 = $rowTmp['txtTyp'];
    }
    ?>



    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Patienteninformationen:</div>

        <form class="questionblock" action="" method="post">

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Geburtsjahr:</span>
                        <input type="number" disabled value="<?php echo $geburtJahr; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Geschlecht:</span>
                        <div class="form-group">
                            <select disabled class="form-control" id="sel1">
                                <?php
                                if ($geschlecht == 1) {
                                    echo "<option selected>männlich</option>";
                                } else {
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
                        <input type="number" disabled value="<?php echo $gewicht; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Größe (cm):</span>
                        <input type="number" disabled value="<?php echo $groesse; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->

            </br>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">In Partnerschaft lebend:</span>
                        <div class="form-group">
                            <select disabled class="form-control" id="sel1">
                                <?php
                                if ($familienstandJa == 1) {
                                    echo "<option selected>ja</option>";
                                } elseif ($familienstandNein == 1) {
                                    echo "<option selected>nein</option>";
                                } else {
                                    "<option selected></option>";
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
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$kinderwunsch</option>";
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
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$bildungsstand</option>";
                                ?>
                            </select>
                        </div> 
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Berufsstand:</span>
                        <div class="form-group">
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$berufsstand</option>";
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </form>
    </div>

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Diagnose:</div>

        <form class="questionblock" action="" method="post">

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Erstdiagnose:</span>
                        <input type="number" disabled value="<?php echo $erstdiagnoseJahr; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">                                                      <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Familienanamnese</span>
                        <div class="form-group">
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$familienanamnese</option>";
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
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$psoriasistyp1</option>";
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
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$psoriasistyp2</option>";
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
                            <select disabled class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$psoriasistyp3</option>";
                                ?>
                            </select>
                        </div>    
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->     

        </form>
    </div>

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
                            <button type="submit" class="btn btn-danger" name="loeschen[<?php echo $row['IDTherapieExperte'] ?>]" value="x">
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

        <form class="questionblock" action="" method="post">

            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsePasiCalculator" aria-expanded="false" aria-controls="collapsePasiCalculator">
                    Komorbiditäten hinzufügen
                </button>
            </p>

            <div class="collapse" id="collapsePasiCalculator">
                <div class="card card-block">

                    <?php
                    if ($select == 0) {
                        ?>

                        <form class="questionblock" action="" method="post">
                            <!--<form action="" method="post">-->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Komorbidität:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="therapie">
                                                <option selected></option>
                                                <?php
                                                foreach ($therapies as $i => $val) {
                                                    echo "<option value=\"$i\">$val</option>";
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
                                            <select class="form-control" id="sel1" name="verabreichung">
                                                <option selected></option>
                                                <?php
                                                foreach ($verabreichungen as $i => $val) {
                                                    echo "<option value=\"$i\">$val</option>";
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
                                        <input type="number" value="" min="0" max="100000" class="form-control" placeholder="" aria-describedby="basic-addon1" name="dosierung">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Wird behandelt:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="masseinheit">
                                                <option selected></option>
                                                <?php
                                                foreach ($masseinheiten as $i => $val) {
                                                    echo "<option value=\"$i\">$val</option>";
                                                }
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

                                    <a href="#liste" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>

                                    <button type="submit" class="btn btn-success btn-lg" name="speichern" value="Therapieempfehlung speichern">
                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                                    </button>

                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->

                        </form>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>

    <?php
}
?>
