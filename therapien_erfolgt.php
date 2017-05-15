<?php

function show_therapien_erfolgt($disabled, $connection) {

    // Parameter
    $select = 0;
    $patient = $_SESSION['idPatient'];
    $visite = $_SESSION['idVisite'];

    // updated Komorbidität
    if (isset($_POST['speichern_therapieerfolgt'])) {

        $val1 = '';
        $val2 = '';
        $val3 = '';
        $val4 = '';
        $val5 = '';
        $val6a = 0;
        $val6b = 0;
        if (isset($_POST['therapie'])) {
            $val1 = $_POST['therapie'];
            $val2 = $_POST['dosierung'];
            $val3 = $_POST['masseinheit'];
            $val4 = $_POST['verabreichung'];
            $val5 = $_POST['wirksamkeit'];
            if ($_POST['uaw'] == 1) {
                $val6a = 1;
                $val6b = 0;
            } elseif ($_POST['uaw'] == 0) {
                $val6a = 0;
                $val6b = 1;
            }

            $sql = mysql_query("INSERT INTO tbltherapiejemals (Therapie,Dosierung,Masseinheit,VerabreichungTyp,Wirksamkeit,UAWJa,UAWNein,Patient) VALUES ($val1,$val2,$val3,$val4,$val5,$val6a,$val6a,$patient)");
            $retval = mysql_query($sql, $connection);

            if (isset($_POST['dosierung']) AND is_int($_POST['dosierung'])) {
                $sql = mysql_query("INSERT INTO tbltherapiejemals (Therapie,Dosierung,Masseinheit,VerabreichungTyp,Wirksamkeit,UAWJa,UAWNein,Patient) VALUES ($val1,$val2,$val3,$val4,$val5,$val6a,$val6a,$patient)");
            } else {
                $sql = mysql_query("INSERT INTO tbltherapiejemals (Therapie,Masseinheit,VerabreichungTyp,Wirksamkeit,UAWJa,UAWNein,Patient) VALUES ($val1,$val3,$val4,$val5,$val6a,$val6a,$patient)");
            }
            $retval = mysql_query($sql, $connection);
        }
    }
    
    // delete Therapie Jemals
    if (isset($_POST['loesche_therapieerfolgt'])) {
        $val = $_POST['loesche_therapieerfolgt'];

        $sql = mysql_query("DELETE FROM tbltherapiejemals WHERE IDTherapie=$val");
        $retval = mysql_query($sql, $connection);
    }    
    ?>

    <form class="questionblock" method="post" id="section_patienteninformationen" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_patienteninformationen">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Jemals angewendete Therapien:</div>

            <table class="table table-striped">
                <colgroup>
                    <col width="500">
                    <col width="500">
                    <col width="80">
                    <col width="80">
                    <col width="100">
                    <col width="80">
                    <col width="80">
                    <col width="80">
                </colgroup>
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
                    $therapie = mysql_query("SELECT * FROM tblTherapieJemals WHERE Patient = $patient");
                    while ($row = mysql_fetch_array($therapie)) {
                        echo "<tr>";
                        $val = '';
                        if (isset($row['Therapie'])) {
                            $valDelete = $row['IDTherapie'];
                            $tmp = $row['Therapie'];
                            $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $tmp");
                            $rowTmp = mysql_fetch_array($results);
                            $val = $rowTmp['Name'];
                            $typ = $rowTmp['Typ'];
                        }
                        ?>
                                            <!--<td><?php echo $val ?></td>-->
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
                                <div class="col-lg-6">
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
                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Wirksamkeit:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="wirksamkeit">
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

                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">UAW:</span>
                                        <div class="form-group">
                                            <select class="form-control" id="sel1" name="uaw">
                                                <option selected></option>
                                                <?php
                                                if ($UAWNein == 1) {
                                                    $selected0 = "";
                                                    $selected1 = "selected";
                                                    $selected2 = "";
                                                } elseif ($UAWJa == 1) {
                                                    $selected0 = "";
                                                    $selected1 = "";
                                                    $selected2 = "selected";
                                                } else {
                                                    $selected0 = "selected";
                                                    $selected1 = "";
                                                    $selected2 = "";
                                                }
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

                                                                                                <!--<a href="#liste" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>-->

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