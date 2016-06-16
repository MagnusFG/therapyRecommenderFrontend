<?php

function show_patientendaten() {

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



    <form class="questionblock" action="" method="post">

        <p>Patienteninformationen:</p>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Geburtsjahr:</span>
                    <input type="number" disabled value="<?php echo $geburtJahr; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
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

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Gewicht (kg):</span>
                    <input type="number" disabled value="<?php echo $gewicht; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Größe (cm):</span>
                    <input type="number" disabled value="<?php echo $groesse; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->

        </br>
        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
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
                <div class="input-group">
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
        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
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
                <div class="input-group">
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

        </br>
        </br>

        <p>Diagnose:</p>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Erstdiagnose:</span>
                    <input type="number" disabled value="<?php echo $erstdiagnoseJahr; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">                                                      <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
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
        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
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

        </br>


        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
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

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
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
    <?php
}
?>
