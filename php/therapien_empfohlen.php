<?php

function show_therapien_empfohlen($disabled, $connection) {

// Parameter
    $select = 0;
    $patient = $_SESSION['idPatient'];
    $visite = $_SESSION['idVisite'];

    // updated therapie erfolgt
    if (isset($_POST['speichern_therapieempfohlen'])) {

        if (isset($_POST['therapie'])) {
            $val1 = intval($_POST['therapie']);
            $val2 = intval($_POST['dosierung']);
            $val3 = intval($_POST['masseinheit']);
            $val4 = intval($_POST['verabreichung']);
            
            if ($val2 != 0) {
                $sql = mysql_query("INSERT INTO tbltherapiesvisitesystrecommended (Therapie,Dosierung,Masseinheit,VerabreichungTyp,Visite) VALUES ($val1,$val2,$val3,$val4,$visite)");
            } else {
                $sql = mysql_query("INSERT INTO tbltherapiesvisitesystrecommended (Therapie,Masseinheit,VerabreichungTyp,Visite) VALUES ($val1,$val3,$val4,$visite)");
            }
            $retval = mysql_query($sql, $connection);
        }
    }

    // delete therapie erfolgt
    if (isset($_POST['loesche_therapieempfohlen'])) {
        $val = $_POST['loesche_therapieempfohlen'];

        $sql = mysql_query("DELETE FROM tbltherapiesvisitesystrecommended WHERE IDTherapie=$val");
        $retval = mysql_query($sql, $connection);
    }
    ?>

    <form class="questionblock" method="post" id="section_empfehlungarzt" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_empfehlungarzt">

        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Vom Arzt empfohlene Therapie:</div>

            <table class="table table-striped">
                <colgroup>
                    <col width="500">
                    <col width="500">
                    <col width="80">
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
                        <th>Löschen</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $therapie = mysql_query("SELECT * FROM tbltherapiesvisitesystrecommended WHERE Visite = $visite");
                    while ($row = mysql_fetch_array($therapie)) {
                        echo "<tr>";
                        $val = '';
                        if (isset($row['Therapie'])) {
                            $valDelete = $row['IDTherapie'];
                            $tmp = $row['Therapie'];
                            $results = mysql_query("SELECT * FROM tbltherapiename WHERE IDTherapie = $tmp");
                            $rowTmp = mysql_fetch_array($results);
                            $val = $rowTmp['Name'];
                            $typ = $rowTmp['Typ'];
                        }
                        ?>                                                                            <!--<td><?php echo $val ?></td>-->
                    <td><b><?php echo $val ?></b></td>

                    <?php
                    $val = '';
                    if (isset($typ)) {
                        $results = mysql_query("SELECT * FROM tbltherapietyp WHERE IDTherapieTyp = $typ");
                        $rowTmp = mysql_fetch_array($results);
                        $val = $rowTmp['Typ'];
                    }
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

                    <td style="text-align: right;">
                        <button type="submit" name="loesche_therapieempfohlen" class="btn btn-danger" value=<?php echo $valDelete; ?><?php echo $disabled; ?>>
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
                                <div class="col-lg-6" style="text-align: right;">
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6" style="text-align: right;">

                                                                                                                                                                                        <!--<a href="#liste" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>-->

                                    <div style="margin: 5px;">
                                        <button type="submit" class="btn btn-success btn-md" name="speichern_therapieempfohlen" value="speichern_therapieempfohlen">
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