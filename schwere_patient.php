<?php

function show_schwere_patient($disabled) {

    // Daten Visite
    $visite = $_SESSION['idVisite'];
    $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $zufriedenheit = $row['BehandlungZufriedenheit'];

    if (isset($row['BehandlungUmgesetzt'])) {
        $tmp = $row['BehandlungUmgesetzt'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungBehandlung WHERE IDPatienteneinschaetzungBehandlung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $behandlung = $rowTmp['txtPatienteneinschaetzungBehandlung'];
    }

    if (isset($row['SchwereGeschaetzt'])) {
        $tmp = $row['SchwereGeschaetzt'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungSchwere WHERE IDPatienteneinschaetzungSchwere = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $schwere = $rowTmp['txtPatienteneinschaetzungSchwere'];
    }

    if (isset($row['HautveraenderungenGesicht'])) {
        $tmp = $row['HautveraenderungenGesicht'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungGesicht = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }

    if (isset($row['HautveraenderungenFuesse'])) {
        $tmp = $row['HautveraenderungenFuesse'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungFuesse = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }

    if (isset($row['HautveraenderungenNaegel'])) {
        $tmp = $row['HautveraenderungenNaegel'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungNaegel = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }

    if (isset($row['HautveraenderungenHaende'])) {
        $tmp = $row['HautveraenderungenHaende'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungHaende = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }

    if (isset($row['HautveraenderungenGenital'])) {
        $tmp = $row['HautveraenderungenGenital'];
        $results = mysql_query("SELECT * FROM tblPatienteneinschaetzungVeraenderung WHERE IDPatienteneinschaetzungVeraenderung = $tmp");
        $rowTmp = mysql_fetch_array($results);
        $veraenderungGenital = $rowTmp['txtPatienteneinschaetzungVeraenderung'];
    }
    ?>

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Patienteneinschätzung:</div>

        <form class="questionblock" action="" method="post">

            <p>Haben Sie die empfohlene Behandlung umgesetzt?</p>               

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Behandlung umgesetzt?</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$behandlung</option>";
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row -->     

            </br>

            <p>Wie schwer schätzen sie derzeit ihre Schuppenflechte?</p>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">geschätze Schwere: </span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$schwere</option>";
                                ?>
                            </select>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                 
            </div><!-- /.row -->

            </br>

            <p>Psoriatische Hautveränderungen an sensiblen Körperstellen:</p> 

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">Gesicht:</span>
                        <div class="form-group">
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$veraenderungGesicht</option>";
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
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$veraenderungFuesse</option>";
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
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$veraenderungNaegel</option>";
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
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$veraenderungHaende</option>";
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
                            <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                <?php
                                echo "<option selected>$veraenderungGenital</option>";
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
        <div class="panel-heading">Dermatology Life Quality Index (DLQI):</div>

        <form class="questionblock" action="" method="post">

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">DLQI Score:</span>
                        <input type="number" <?php echo $disabled; ?> value="<?php echo $dlqi; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row -->     
            
            </br>
            </br>

            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsePasiCalculator" aria-expanded="false" aria-controls="collapsePasiCalculator" <?php echo $disabled; ?>>
                    DLQI Score Detail
                </button>
            </p>

            <div class="collapse" id="collapsePasiCalculator">
                <div class="card card-block">

                    </br>

                    <p>1. Wie sehr hat Ihre Haut in den vergangenen 7 Tagen gejuckt, war wund, hat geschmerzt oder gebrannt?</p>

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

                    <p>2. Wie sehr hat Ihre Hauterkrankung Sie in den vergangenen 7 Tagen verlegen oder befangen gemacht?</p>

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

                    <p>3. Wie sehr hat Ihre Hauterkrankung Sie in den vergangenen 7 Tagen bei Einkäufen oder bei Haus- oder Gartenarbeit behindert?</p>

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

                    <p>4. Wie sehr hat Ihre Hauterkrankung die Wahl der Kleidung beeinflusst, die Sie in den vergangenen 7 Tagen getragen haben?</p>

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

                    <p>5. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Ihre Aktivitäten mit anderen Menschen oder Ihre Freizeitgestaltung beeinflusst?</p>

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

                    <p>6. Wie sehr hat Ihre Hauterkrankung es Ihnen in den vergangenen 7 Tagen erschwert, sportlich aktiv zu sein?</p>

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

                    <p>7. Hat Ihre Hauterkrankung in den vergangenen 7 Tagen dazu geführt, dass Sie ihrer beruflichen Tätigkeit nicht nachgehen oder nicht studieren konnten?</p>

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

                    <p>8. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Probleme im Umgang mit Ihrem Partner, Freunden oder Verwandten verursacht?</p>

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

                    <p>9. Wie sehr hat Ihre Hauterkrankung in den vergangenen 7 Tagen Ihr Liebesleben beeinträchtigt?</p>

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

                    <p>10. Inwieweit war die Behandlung Ihrer Haut in den vergangenen 7 Tagen für Sie mit Problemen verbunden (z. B. weil die Behandlung Zeit in Anspruch nahm oder dadurch Ihr Haushalt unsauber wurde)?</p>

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

                    </form>
                </div>
            </div>
    </div>


    </form>
    </div>

    <?php
}
?>