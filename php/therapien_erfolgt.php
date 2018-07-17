<?php

function show_therapien_erfolgt($disabled, $connection) {

// Parameter
    $select = 0;
    $patient = $_SESSION['idPatient'];
    $visite = $_SESSION['idVisite'];
    $visiten = $_SESSION['visiten'];

// updated therapie erfolgt
    if (isset($_POST['speichern_therapieerfolgt'])) {

        if (isset($_POST['therapie'])) {
            $val1 = intval($_POST['therapie']);
            $val2 = intval($_POST['dosierung']);
            $val3 = intval($_POST['masseinheit']);
            $val4 = intval($_POST['verabreichung']);
            $val5 = intval($_POST['wirksamkeitNew']);
            if ($_POST['uawNew'] == 1) {
                $val6a = 1;
                $val6b = 0;
            } elseif ($_POST['uawNew'] == 0) {
                $val6a = 0;
                $val6b = 1;
            } else {
                $val6a = 0;
                $val6b = 0;
            }

            if ($val2 != 0) {
                $sql = mysql_query("INSERT INTO tbltherapiejemals (Therapie,Dosierung,Masseinheit,VerabreichungTyp,Wirksamkeit,UAWJa,UAWNein,Patient) VALUES ($val1,$val2,$val3,$val4,$val5,$val6a,$val6b,$patient)");
            } else {
                $sql = mysql_query("INSERT INTO tbltherapiejemals (Therapie,Masseinheit,VerabreichungTyp,Wirksamkeit,UAWJa,UAWNein,Patient) VALUES ($val1,$val3,$val4,$val5,$val6a,$val6b,$patient)");
            }
            $retval = mysql_query($sql, $connection);
        }
    }

    // updated therapie outcome
    if (isset($_POST['speichern_therapieoutcome'])) {

        $prevVisite = $_POST['speichern_therapieoutcome'];

        $val2 = intval($_POST['wirksamkeit']);
        if ($_POST['uaw'] == 1) {
            $val3a = 1;
            $val3b = 0;
        } elseif ($_POST['uaw'] == 0) {
            $val3a = 0;
            $val3b = 1;
        } else {
            $val3a = 0;
            $val3b = 0;
        }

        // new applied therapie
        $therapies = array();
        $sql = mysql_query("SELECT * FROM tbltherapiesvisitesystrecommended WHERE Visite = $prevVisite");
        while ($row = mysql_fetch_array($sql)) { // while Antworten ausgeben
            $therapies[$row['IDTherapie']] = $row['Therapie'];
        }
        foreach ($therapies as $idTherapyRecommended => $therapy) {
            $sql = mysql_query("SELECT * FROM tbltherapiesvisitesystapplied WHERE Therapie = $therapy AND Visite = $visite");
            $row = mysql_fetch_array($sql);
            if (!isset($row['IDTherapie'])) {
                $sql = mysql_query("INSERT INTO tbltherapiesvisitesystapplied(Therapie, Dosierung, Masseinheit, VerabreichungTyp, Visite) SELECT Therapie, Dosierung, Masseinheit, VerabreichungTyp, $visite FROM tbltherapiesvisitesystrecommended WHERE IDTherapie = $idTherapyRecommended");
                $retval = mysql_query($sql, $connection);
                $sql = mysql_query("SELECT * FROM tbltherapiesvisitesystapplied WHERE Visite = $visite AND Therapie = $therapy LIMIT 1");
                $row = mysql_fetch_array($sql);
            }
            $idTherapieApplied = $row['IDTherapie'];
            $sql = mysql_query("UPDATE tbltherapiesvisitesystapplied SET AngewendetJa=1, AngewendetNein=0, Wirksamkeit=$val2, UAWja=$val3a, UAWnein=$val3b WHERE IDTherapie=$idTherapieApplied");
            $retval = mysql_query($sql, $connection);
        }
    }

// delete therapie erfolgt
    if (isset($_POST['loesche_therapieerfolgt'])) {
        $val = $_POST['loesche_therapieerfolgt'];

        $sql = mysql_query("DELETE FROM tbltherapiejemals WHERE IDTherapie=$val");
        $retval = mysql_query($sql, $connection);
    }

// delete therapie outcome
    if (isset($_POST['loesche_therapieoutcome'])) {
        $prevVisite = $_POST['loesche_therapieoutcome'];

        $therapies = array();
        $sql = mysql_query("SELECT * FROM tbltherapiesvisitesystrecommended WHERE Visite = $prevVisite");
        while ($row = mysql_fetch_array($sql)) { // while Antworten ausgeben
            $therapies[$row['IDTherapie']] = $row['Therapie'];
        }
        foreach ($therapies as $idTherapyRecommended => $therapy) {
            $sql = mysql_query("UPDATE tbltherapiesvisitesystrecommended SET AngewendetJa=0, AngewendetNein=0, NichtUmgesetzt=1 WHERE IDTherapie=$idTherapyRecommended");
            $retval = mysql_query($sql, $connection);
        }
    }
    ?>

    <form class="questionblock" method="post" id="section_patienteninformationen" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_patienteninformationen">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Jemals angewendete Therapien:</div>

            <table class="table table-striped">
                <colgroup>
                    <col width="200">
                    <col width="80">
                    <col width="80">
                    <col width="100">
                    <col width="100">
                    <col width="120">
                    <col width="80">
                    <col width="120">
                </colgroup>
                <thead>
                    <tr>
                        <th>Therapie</th>
                        <th>Visite</th>
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
                    // zeige angewendete therapien jemals
                    append_therapie_jemals($patient);

                    // go through previous consultations
                    foreach ($visiten as $prevVisite => $idPrevVisite) {
                        // current consultation reached?
                        if ($idPrevVisite == $visite) {
                            break;
                        }
                        // zeige angewendete therapien frühere visite
                        append_therapie_visite($visiten, $prevVisite, 0);
                    }

                    // zeige empfohlene therapien vorherige visite
                    append_therapie_visite($visiten, $prevVisite, 1);
                    ?>

                </tbody>
            </table>

            </br>
            </br>

            <div style="margin: 5px;">
                <button class="btn btn-primary " type="button" data-toggle="collapse" data-target="#collapseTherapieNeu" aria-expanded="false" aria-controls="collapseTherapieNeu" <?php echo $disabled; ?>>
                    Therapien hinzufügen
                </button>            
            </div>               

            <div class="collapse" id="collapseTherapieNeu">
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
                                                $selected = '';
                                                $results = mysql_query("SELECT * FROM tbltherapiename WHERE Typ = 2");
                                                echo "<option selected value=NULL></option>";
                                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                                    $valTmp = $rowTmp['IDTherapie'];
                                                    $nameTmp = $rowTmp['Name'];
                                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->    

                            </br>

                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Dosierung:</span>
                                        <input type="number" min=0 max=10000 class="form-control" aria-describedby="basic-addon1" name="dosierung">
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                                <div class="col-lg-4">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Maßeinheit:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="masseinheit">
                                                <option selected></option>
                                                <?php
                                                $selected = '';
                                                $results = mysql_query("SELECT * FROM tbltherapiemasseinheit");
                                                echo "<option selected value=NULL></option>";
                                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                                    $valTmp = $rowTmp['IDMaßeinheit'];
                                                    $nameTmp = $rowTmp['Maßeinheit'];
                                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                                <div class="col-lg-4">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Art der Verabreichung:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="verabreichung">
                                                <option selected></option>
                                                <?php
                                                $selected = '';
                                                $results = mysql_query("SELECT * FROM tbltherapieverabreichung");
                                                echo "<option selected value=NULL></option>";
                                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                                    $valTmp = $rowTmp['IDTherapieVerabreichung'];
                                                    $nameTmp = $rowTmp['TherapieVerabreichung'];
                                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>    
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                            </div><!-- /.row -->

                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Wirksamkeit:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="wirksamkeitNew">
                                                <option selected></option>
                                                <?php
                                                $selected = '';
                                                $results = mysql_query("SELECT * FROM tbltherapiewirksamkeit");
                                                echo "<option selected value=NULL></option>";
                                                while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                                    $valTmp = $rowTmp['IDTherapieWirksamkeit'];
                                                    $nameTmp = $rowTmp['TherapieWirksamkeit'];
                                                    echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                                <div class="col-lg-4">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">UAW:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="uawNew">
                                                <option selected></option>
                                                <?php
                                                $selected0 = "";
                                                $selected1 = "";
                                                $selected2 = "";
                                                echo "<option $selected0 value=-1></option>";
                                                echo "<option $selected1 value=0>nein</option>";
                                                echo "<option $selected2 value=1>ja</option>";
                                                ?>
                                            </select>
                                        </div>    
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->

                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-lg-6" style="text-align: right;">
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6" style="text-align: right;">

                                    <div style="margin: 5px;">
                                        <button type="submit" class="btn btn-success btn-md" name="speichern_therapieerfolgt" value="speichern_therapieerfolgt">
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

<?php

function append_therapie_jemals($patient) {

    $disabled = '';

    $therapie = mysql_query("SELECT * FROM tbltherapiejemals WHERE Patient = $patient");
    while ($row = mysql_fetch_array($therapie)) {
        ?>

        <tr>

            <?php
            $val = '';
            if (isset($row['Therapie'])) {
                $valDelete = $row['IDTherapie'];
                $tmp = $row['Therapie'];
                $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $tmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['Name'];
                $typ = $rowTmp['Typ'];
                if ($typ != 2) {
                    continue;
                }
            }
            ?>
            <td><b><?php echo $val ?></b></td>

            <?php
            $val = "vorher";
            ?>                
            <td><?php echo $val ?></td>

            <?php
            $val = $row['Dosierung'];
            ?>
            <td><?php echo $val ?></td>                    

            <?php
            $val = '';
            if (isset($row['Masseinheit'])) {
                $tmp = $row['Masseinheit'];
                $results = mysql_query("SELECT * FROM tbltherapiemasseinheit WHERE IDMaßeinheit = $tmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['Maßeinheit'];
            }
            ?>
            <td><?php echo $val ?></td>                    

            <?php
            $val = '';
            if (isset($row['VerabreichungTyp'])) {
                $tmp = $row['VerabreichungTyp'];
                $results = mysql_query("SELECT * FROM tbltherapieverabreichung WHERE IDTherapieVerabreichung = $tmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['TherapieVerabreichung'];
            }
            ?>
            <td><?php echo $val ?></td>

            <?php
            $val = '';
            if (isset($row['Wirksamkeit'])) {
                $tmp = $row['Wirksamkeit'];
                $results = mysql_query("SELECT * FROM tbltherapiewirksamkeit WHERE IDTherapieWirksamkeit = $tmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['TherapieWirksamkeit'];
            }
            ?>
            <td><?php echo $val ?></td>                             

            <?php
            if ($row['UAWJa'] == 1) {
                echo "<td>ja</td>";
            } else {
                echo "<td></td>";
            }
            ?>

            <td style="text-align: right;">
                <button type="submit" name="loesche_therapieerfolgt" class="btn btn-danger" value=<?php echo $valDelete; ?><?php echo $disabled; ?>>
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                </button>                          
            </td>

        </tr>

        <?php
    }
    return 1;
}
?>


<?php

function append_therapie_visite($visiten, $numVisite, $verify) {

    $disabled = '';

    if ($verify == 1 AND $numVisite > 0) {
        $visite = $visiten[$numVisite - 1];
        $visiteNext = $visiten[$numVisite];
        $therapie = mysql_query("SELECT * FROM tbltherapiesvisitesystrecommended WHERE Visite = $visite");
    } else {
        $visite = $visiten[$numVisite];
        $therapie = mysql_query("SELECT * FROM tbltherapiesvisitesystapplied WHERE Visite = $visite");
        $verify = 0;
    }
    $kombi = 0;
    while ($row = mysql_fetch_array($therapie)) {

        if ($row['NichtUmgesetzt'] == 1) {
            continue;
        }
        ?>

        <tr>

            <?php
            $val = '';
            if (isset($row['Therapie'])) {
                $valDelete = $row['IDTherapie'];
                $therapieTmp = $row['Therapie'];
                $results = mysql_query("SELECT * FROM tbltherapiename WHERE IDTherapie = $therapieTmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['Name'];
                $typ = $rowTmp['Typ'];
            }
            ?>
            <td><b><?php echo $val ?></b></td>

            <?php
            $val = $numVisite;
            ?>                
            <td><?php echo $val ?></td>

            <?php
            $val = $row['Dosierung'];
            ?>
            <td><?php echo $val ?></td>                    

            <?php
            $val = '';
            if (isset($row['Masseinheit'])) {
                $tmp = $row['Masseinheit'];
                $results = mysql_query("SELECT * FROM tbltherapiemasseinheit WHERE IDMaßeinheit = $tmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['Maßeinheit'];
            }
            ?>
            <td><?php echo $val ?></td>                    

            <?php
            $val = '';
            if (isset($row['VerabreichungTyp'])) {
                $tmp = $row['VerabreichungTyp'];
                $results = mysql_query("SELECT * FROM tbltherapieverabreichung WHERE IDTherapieVerabreichung = $tmp");
                $rowTmp = mysql_fetch_array($results);
                $val = $rowTmp['TherapieVerabreichung'];
            }
            ?>
            <td><?php echo $val ?></td>

            <?php
            if ($verify == 1) { // verify outcome
                $therapieoutcome = mysql_query("SELECT * FROM tbltherapiesvisitesystapplied WHERE Therapie = $therapieTmp AND Visite = $visiteNext");
                $rowTherapieoutcome = mysql_fetch_array($therapieoutcome);
                $wirksamkeit = '';
                if (isset($rowTherapieoutcome['Wirksamkeit'])) {
                    $wirksamkeit = $rowTherapieoutcome['Wirksamkeit'];
                }
                $uawJa = $uawNein = '';
                if (isset($rowTherapieoutcome['UAWja']) AND isset($rowTherapieoutcome['UAWnein'])) {
                    $uawJa = $rowTherapieoutcome['UAWja'];
                    $uawNein = $rowTherapieoutcome['UAWnein'];
                }
                ?>

                <?php
                if ($kombi == 0) {
                    ?>

                    <td>

                        <select class="form-control" id="sel1" name="wirksamkeit">
                            <option selected></option>
                            <?php
                            $selected = "";
                            $results = mysql_query("SELECT * FROM tbltherapiewirksamkeit");
//                        echo "<option selected value=NULL></option>";
                            while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                $valTmp = $rowTmp['IDTherapieWirksamkeit'];
                                $nameTmp = $rowTmp['TherapieWirksamkeit'];
                                if ($wirksamkeit == $valTmp) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option $selected value=$valTmp>" . $nameTmp . "</option>";
                            }
                            ?>
                        </select>
                    </td>  

                    <td>                
                        <select class="form-control" id="sel1" name="uaw">
                            <!--<option selected></option>-->
                            <?php
                            if ($uawNein == 1) {
                                $selected0 = "";
                                $selected1 = "selected";
                                $selected2 = "";
                            } elseif ($uawJa == 1) {
                                $selected0 = "";
                                $selected1 = "";
                                $selected2 = "selected";
                            } else {
                                $selected0 = "";
                                $selected1 = "";
                                $selected2 = "";
                            }
                            echo "<option $selected0 value=-1></option>";
                            echo "<option $selected1 value=0>nein</option>";
                            echo "<option $selected2 value=1>ja</option>";
                            ?>
                        </select>
                    </td>   

                    <?php
                } else { // $kombi == 0
                    ?>

                    <?php
                    $val = '';
                    if ($wirksamkeit > 0) {
                        $results = mysql_query("SELECT * FROM tbltherapiewirksamkeit WHERE IDTherapieWirksamkeit = $wirksamkeit");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['TherapieWirksamkeit'];
                    }
                    ?>
                    <td><?php echo $val ?></td>                             

                    <?php
                    if ($uawJa == 1) {
                        echo "<td>ja</td>";
                    } else {
                        echo "<td></td>";
                    }
                    ?>                    

                    <?php
                } // $kombi == 0
                ?>                    

                <?php
            } else { // show outcome                
                ?>

                <?php
                $val = '';
                if (isset($row['Wirksamkeit'])) {
                    $tmp = $row['Wirksamkeit'];
                    $results = mysql_query("SELECT * FROM tbltherapiewirksamkeit WHERE IDTherapieWirksamkeit = $tmp");
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

                <?php
            }
            ?>

            <td style="text-align: right;">
                <?php
                if ($verify == 1 AND $kombi == 0) { // verify outcome
                    ?>
                    <div class="button-box col-sm-4-12">
                        <button type="submit" name="speichern_therapieoutcome" class="btn btn-success" value=<?php echo $visite; ?><?php echo $disabled; ?>>
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                        </button>
                        <button type="submit" name="loesche_therapieoutcome" class="btn btn-danger" value=<?php echo $visite; ?><?php echo $disabled; ?>>
                            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                        </button>
                    </div>

                    <?php
                } else {
                    ?>
                    <button type="submit" name="loesche_therapieerfolgt" class="btn btn-danger" value=<?php echo $valDelete; ?><?php echo $disabled; ?>>
                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                    </button>
                    <?php
                }
                ?>
            </td>

        </tr>

        <?php
        $kombi = 1;
    }
    return 1;
}
?>