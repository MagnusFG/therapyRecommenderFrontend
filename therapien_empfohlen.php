<?php

function show_therapien_empfohlen() {

// Daten Patient
    $patient = $_SESSION['idPatient'];
    $results = mysql_query("SELECT * FROM tblPatient WHERE IDPatient = $patient");
    $row = mysql_fetch_array($results);
    $geburtJahr = $row['GeburtJahr'];
    $erstdiagnoseJahr = $row['ErstdiagnoseJahr'];
    $geschlecht = $row['Geschlecht'];

    // Therapien
    $results = mysql_query("SELECT * FROM tblTherapieName");
    $therapies = array();
    while ($row = mysql_fetch_array($results)) {
        $therapies[$row['IDTherapie']] = $row['txtName'];
    }

    // Wirksamkeit
    $results = mysql_query("SELECT * FROM tblTherapieWirksamkeit");
    $wirksamkeit = array();
    while ($row = mysql_fetch_array($results)) {
        $wirksamkeiten[$row['IDTherapieWirksamkeit']] = $row['txtTherapieWirksamkeit'];
    }

    // Verabreichung
    $results = mysql_query("SELECT * FROM tblTherapieVerabreichung");
    $wirksamkeit = array();
    while ($row = mysql_fetch_array($results)) {
        $verabreichungen[$row['IDTherapieVerabreichung']] = $row['txtTherapieVerabreichung'];
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
        mysql_query("INSERT INTO tblTherapieRecom (Therapie, Dosierung, Masseinheit, DosierungKombi, MasseinheitKombi, VerabreichungTyp, Visite, Experte) VALUES ('$therapie','$dosierung','$masseinheit','$dosierungkombi','$masseinheitkombi','$verabreichung','$visite','$experte')");
//        mysql_query("INSERT INTO tblTherapieRecom (Therapie, Dosierung, Masseinheit, DosierungKombi, MasseinheitKombi, VerabreichungTyp, Visite, Experte) VALUES ($therapie,'$dosierung','$masseinheit','$dosierungkombi','$masseinheitkombi','$verabreichung',$visite,$experte)");
    }

    // Therapie löschen
    if (isset($_POST['loeschen'])) {
        foreach ($_POST['loeschen'] as $key => $val) {
            mysql_query("DELETE FROM tblTherapieRecom WHERE IDTherapie = $key");
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


    <?php
// Therapie eingeben
    if ($select == 1) {
        ?>

        <form class="questionblock" action="" method="post">
            <!--<form action="" method="post">-->

            <p>Therapie:</p>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
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
            </br>

            <p>Verabreichung:</p>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
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
            </br>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dosierung:</span>
                        <input type="number" value="" min="0" max="100000" class="form-control" placeholder="" aria-describedby="basic-addon1" name="dosierung">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group">
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

            </br>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dosierung Kombi:</span>
                        <input type="number" value="" min="0" max="100000" class="form-control" placeholder="" aria-describedby="basic-addon1" name="dosierungkombi">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group">
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

        <a name="liste"></a> 

        <form class="questionblock" action="" method="post">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Therapie</th>
                        <th>Typ</th>                    
                        <th>Dosierung</th>
                        <th>Maßeinheit</th>                  
                        <th>Verabreichung</th>
                        <th>Löschen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $therapienArray = array();
                    $therapie = mysql_query("SELECT * FROM tblTherapieRecom WHERE Visite = $visite AND Experte = $experte");
                    while ($row = mysql_fetch_array($therapie)) {
//                            print_r($row);

                        $val = '';
                        if (isset($row['Therapie'])) {
                            $therapienArray = $row['IDTherapie'];
//                        print_r($therapienArray);
                            $tmp = $row['Therapie'];
                            $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $tmp");
                            $rowTmp = mysql_fetch_array($results);
                            $val = $rowTmp['txtName'];
                            $typ = $rowTmp['ingTyp'];

//                        echo "<tr style=\"background-color:#b3e6ff;\">";

                            if ($typ == 1) {
                                echo "<tr style=\"background-color:#b3e6ff;\">";
                            }

                            if ($typ == 2) {
                                echo "<tr style=\"background-color:#99ffcc;\">";
                            }

                            if ($typ == 3) {
                                echo "<tr style=\"background-color:#ffd9b3;\">";
                            }
                        }
                        ?>
                    <td><b><?php echo $val ?></b></td>

                    <?php
                    $val = '';
                    if (isset($typ)) {
                        $results = mysql_query("SELECT * FROM tblTherapieTyp WHERE IDTherapieTyp = $typ");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtTyp'];
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
                    if (isset($row['MasseinheitKombi'])) {
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
                        $val = $rowTmp['txtTherapieVerabreichung'];
                    }
                    ?>
                    <td><?php echo $val ?></td>                

                    <td style="text-align: right;">
                        <button type="submit" class="btn btn-danger btn-lg" name="loeschen[<?php echo $row['IDTherapie'] ?>]" value="x">
                            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                        </button>
                    </td>

                    </tr>

                    <?php
                }
                ?>
                </tbody>
            </table>

        </form>

        <?php
// Therapie zeigen
    } else {
        ?>

        <form class="questionblock" action="" method="post">

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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $therapie = mysql_query("SELECT * FROM tblTherapieVisite WHERE Visite = $idVisite");
                    while ($row = mysql_fetch_array($therapie)) {
//                            print_r($row);
                        $val = '';
                        if (isset($row['Therapie'])) {
                            $tmp = $row['Therapie'];
                            $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $tmp");
                            $rowTmp = mysql_fetch_array($results);
                            $val = $rowTmp['txtName'];
                            $typ = $rowTmp['ingTyp'];

//                        echo "<tr style=\"background-color:#b3e6ff;\">";

                            if ($typ == 1) {
                                echo "<tr style=\"background-color:#b3e6ff;\">";
                            }

                            if ($typ == 2) {
                                echo "<tr style=\"background-color:#99ffcc;\">";
                            }

                            if ($typ == 3) {
                                echo "<tr style=\"background-color:#ffd9b3;\">";
                            }
                        }
                        ?>
                    <td><b><?php echo $val ?></b></td>

                    <?php
                    $val = '';
                    if (isset($typ)) {
                        $results = mysql_query("SELECT * FROM tblTherapieTyp WHERE IDTherapieTyp = $typ");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtTyp'];
                    }
                    ?>                
                    <td><?php echo $val ?></td>

                    <?php
                    echo "<td>";
                    echo $row['Dosierung'];
                    $val = '';
                    if (isset($row['DosierungKombi'])) {
                        $tmp = $row['DosierungKombi'];
                        echo " / ";
                        echo $tmp;
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
                    if (isset($row['DosierungKombi'])) {
                        $tmp = $row['DosierungKombi'];
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
                        $val = $rowTmp['txtTherapieVerabreichung'];
                    }
                    ?>
                    <td><?php echo $val ?></td>

                    <?php
                    $val = '';
                    if (isset($row['Wirksamkeit'])) {
                        $tmp = $row['Wirksamkeit'];
                        $results = mysql_query("SELECT * FROM tblTherapieWirksamkeit WHERE IDTherapieWirksamkeit = $tmp");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['txtTherapieWirksamkeit'];
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
                    </tr>

                    <?php
                }
                ?>
                </tbody>
            </table>

        </form>
        <?php
    }
    ?>

    <?php
}
?>