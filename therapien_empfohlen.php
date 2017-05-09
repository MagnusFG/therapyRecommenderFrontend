<?php

function show_therapien_empfohlen($disabled) {

// Daten Patient
    $patient = $_SESSION['idPatient'];
    $results = mysql_query("SELECT * FROM tblPatient WHERE IDPatient = $patient");
    $row = mysql_fetch_array($results);
    $geburtJahr = $row['GeburtJahr'];
    $erstdiagnoseJahr = $row['ErstdiagnoseJahr'];
    $geschlecht = $row['Geschlecht'];

    // Therapien
    $results = mysql_query("SELECT * FROM tblTherapieName WHERE ingTyp = 2");
    $therapies = array();
    while ($row = mysql_fetch_array($results)) {
        $therapies[$row['IDTherapie']] = $row['Name'];
    }

    // Wirksamkeit
    $results = mysql_query("SELECT * FROM tblTherapieWirksamkeit");
    $wirksamkeit = array();
    while ($row = mysql_fetch_array($results)) {
        $wirksamkeiten[$row['IDTherapieWirksamkeit']] = $row['TherapieWirksamkeit'];
    }

    // Verabreichung
    $results = mysql_query("SELECT * FROM tblTherapieVerabreichung");
    $wirksamkeit = array();
    while ($row = mysql_fetch_array($results)) {
        $verabreichungen[$row['IDTherapieVerabreichung']] = $row['TherapieVerabreichung'];
    }

    // Maßeinheit
    $results = mysql_query("SELECT * FROM tblTherapieMasseinheit");
    $wirksamkeit = array();
    while ($row = mysql_fetch_array($results)) {
        $masseinheiten[$row['IDMaßeinheit']] = $row['Maßeinheit'];
    }

    // Eingabe verarbeiten
    $visite = $_SESSION['idVisite'];
    $experte = $_SESSION['idExperte'];

    // Therapie hinzufügen
    if (isset($_POST['speichern'])) {
        $therapie = $_POST['therapie'];
        $dosierung = $_POST['dosierung'];
        $masseinheit = $_POST['masseinheit'];
        $dosierungkombi = $_POST['dosierungkombi'];
        $masseinheitkombi = $_POST['masseinheitkombi'];
        $verabreichung = $_POST['verabreichung'];
        mysql_query("INSERT INTO tblTherapieExperte (Therapie, Dosierung, Masseinheit, DosierungKombi, MasseinheitKombi, VerabreichungTyp, Visite, Experte) VALUES ('$therapie','$dosierung','$masseinheit','$dosierungkombi','$masseinheitkombi','$verabreichung','$visite','$experte')");
//        mysql_query("INSERT INTO tblTherapieExperte (Therapie, Dosierung, Masseinheit, DosierungKombi, MasseinheitKombi, VerabreichungTyp, Visite, Experte) VALUES ($therapie,'$dosierung','$masseinheit','$dosierungkombi','$masseinheitkombi','$verabreichung',$visite,$experte)");
    }

    // Therapie löschen
    if (isset($_POST['loeschen'])) {
        foreach ($_POST['loeschen'] as $key => $val) {
            mysql_query("DELETE FROM tblTherapieExperte WHERE IDTherapieExperte = $key");
        }
    }

    // select between input and show therapie?
    $select = 0;
    if (isset($_SESSION['visiten']) && isset($_SESSION['idVisite'])) {
        $idVisite = $_SESSION['idVisite'];
        $visiten = $_SESSION['visiten'];
        $numVisite = array_search($idVisite, $visiten);
        $maxNumVisite = max(array_keys($visiten));
        if ($numVisite == $maxNumVisite) {
            $select = 1;
        }
    }
    ?>

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Aktuelle Therapien:</div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Therapie</th>
                    <th>Typ</th>
                    <th>Dosierung</th>
                    <th>Maßeinheit</th>
                    <th>Verabreichung</th>
                    <th>Wirksamkeit</th>
                    <th>UAW</th>
                    <th>Löschen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $therapienArray = array();
                $therapie = mysql_query("SELECT * FROM tblTherapieVisite WHERE Visite = $visite");
                while ($row = mysql_fetch_array($therapie)) {
//                            print_r($row);

                    $val = '';
                    if (isset($row['Therapie'])) {
//                        print_r($therapienArray);
                        $tmp = $row['Therapie'];
                        $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['Name'];
                        $typ = $rowTmp['Typ'];

//                        echo "<tr style=\"background-color:#b3e6ff;\">";
//                        if ($typ == 1) {
//                            echo "<tr style=\"background-color:#b3e6ff;\">";
//                        }
//
//                        if ($typ == 2) {
//                            echo "<tr style=\"background-color:#99ffcc;\">";
//                        }
//
//                        if ($typ == 3) {
//                            echo "<tr style=\"background-color:#ffd9b3;\">";
//                        }
                    }
                    ?>
                <td><b><?php echo $val ?></b></td>

                <?php
                $val = '';
                if (isset($typ)) {
                    $results = mysql_query("SELECT * FROM tblTherapieTyp WHERE IDTherapieTyp = $typ");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['Typ'];
                }
                ?>                
                <td><?php echo $val ?></td>

                <?php
                echo "<td>";
                if (isset($row['Dosierung']) && $row['Dosierung'] != 0) {
                    echo $row['Dosierung'];
                }
                if (isset($row['DosierungKombi']) && $row['DosierungKombi'] != 0) {
                    echo " / ";
                    echo $row['DosierungKombi'];
                }
                echo "</td>";
                ?>

                <?php
                echo "<td>";
                $val = '';
                if (isset($row['Masseinheit'])) {
                    $tmp = $row['Masseinheit'];
                    $results = mysql_query("SELECT * FROM tblTherapieMasseinheit WHERE IDMaßeinheit = $tmp");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['Maßeinheit'];
                    echo $val;
                }
                $val = '';
                if (isset($row['MasseinheitKombi']) && $row['MasseinheitKombi'] != 0) {
                    $tmp = $row['MasseinheitKombi'];
                    $results = mysql_query("SELECT * FROM tblTherapieMasseinheit WHERE IDMaßeinheit = $tmp");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['Maßeinheit'];
                    echo " / ";
                    echo $val;
                }
                echo "</td>";
                ?>

                <?php
                $val = '';
                if (isset($row['VerabreichungTyp'])) {
                    $tmp = $row['VerabreichungTyp'];
                    $results = mysql_query("SELECT * FROM tblTherapieVerabreichung WHERE IDTherapieVerabreichung = $tmp");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['TherapieVerabreichung'];
                }
                ?>
                <td><?php echo $val ?></td>                
                <?php
                $val = '';
                if (isset($row['Wirksamkeit'])) {
                    $tmp = $row['Wirksamkeit'];
                    $results = mysql_query("SELECT * FROM tblTherapieWirksamkeit WHERE IDTherapieWirksamkeit = $tmp");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['TherapieWirksamkeit'];
                }
                ?>
                <td><?php echo $val ?></td>                             

                <?php
                if ($row['UAWja'] == 1) {
                    echo "<td>ja</td>";
                } else {
                    echo "<td></td>";
                }
                ?>

                <td style="text-align: right;">
                    <button type="submit" class="btn btn-danger" name="loeschen[<?php echo $row['IDTherapieExperte'] ?>]" value="x"<?php echo $disabled; ?>>
                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                    </button>
                </td>

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
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseTherapieArztNeu" aria-expanded="false" aria-controls="collapseTherapieArztNeu" <?php echo $disabled; ?>>
                    Therapien hinzufügen
                </button>
            </p>

            <div class="collapse" id="collapseTherapieArztNeu">
                <div class="card card-block">

                    <?php
// Therapie eingeben
                    if ($select == 0) {
                        ?>
                        <form class="questionblock" action="" method="post">
                            <!--<form action="" method="post">-->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Therapie:</span>
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
                            </div><!-- /.row -->    

                            </br>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Art der Verabreichung:</span>
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

                            </br>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Dosierung:</span>
                                        <input type="number" value="" min="0" max="100000" class="form-control" placeholder="" aria-describedby="basic-addon1" name="dosierung">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Maßeinheit:</span>
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

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Dosierung Kombi:</span>
                                        <input type="number" value="" min="0" max="100000" class="form-control" placeholder="" aria-describedby="basic-addon1" name="dosierungkombi">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Maßeinheit Kombi:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="masseinheitkombi">
                                                <option selected></option>
                                                <?php
                                                foreach ($masseinheiten as $i => $val) {
                                                    echo "<option value=\"$i\">$val</option>";
                                                }
                                                ?> 
                                            </select>
                                            </select>
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->  

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