<?php
include('patientendaten.php');
include('komorbiditaeten.php');
include('schwere_pasi.php');
include('schwere_patient.php');
include('dlqi.php');
include('therapien_erfolgt.php');
include('therapien_empfohlen.php');
include('therapien_rs.php');
include('config.inc.php');

session_start();
?>

<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Title -->
        <title>Therapieempfehlungssystem</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/custom.css" rel="stylesheet">

        <!-- Custom Fonts from Google -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    </head>

    <body>

        <?php
        if (!isset($_GET['action'])) {
            $_GET['action'] = 'patientendaten';
        }
        ?>

        <section class="container">
            <div class="mainblock">

                <?php
                $connection = connect_database();
                ?>

                <?php
                // fill patienten array
                $patienten = array();
                $results = mysql_query("SELECT * FROM tblPatient");
                while ($row = mysql_fetch_array($results)) {
                    $patienten[] = $row['IDPatient'];
                }
                ?>

                <?php
                // input selected patient
                $visiten = array();
                $patient = '';
                $results = '';
                if (isset($_POST['selPatient'])) {
                    if ($_POST['selPatient'] != '') {
                        // set idPatient
                        $patient = $_POST['selPatient'];
                        // fill visiten array
                        $results = mysql_query("SELECT * FROM tblVisite WHERE Patient = $patient ORDER BY NumVisite ASC");
                        while ($row = mysql_fetch_array($results)) {
                            $visiten[$row['NumVisite']] = $row['IDVisite'];
                        }
                        // set global variables
                        $_SESSION['idPatient'] = $patient;
                        $_SESSION['visiten'] = $visiten;

//                        unset($_SESSION['idVisite']);
//                        $_SESSION['idVisite'] = '';
                        // unset selected visite
//                        unset($_POST['selVisite']);
//                        unset($_POST['selPatient']);
                    } else {
                        // unset global variables
                        unset($_SESSION['idPatient']);
                        unset($_SESSION['idVisite']);
                        unset($_SESSION['visiten']);
                    }
                }

                // input selected visite
                $visiten = array();
                $idVisite = '';
                if (isset($_POST['selVisite'])) {
                    echo "1";
//                    if (isset($_SESSION['idPatient']) && isset($_POST['selVisite']) && isset($_SESSION['visiten']) && $_POST['selVisite'] >= 0) {
                    if ($_POST['selVisite'] != '') {
                        echo "2";
                        // set visite
                        $idVisite = $_POST['selVisite'];
                        // set global variables
                        $visiten = $_SESSION['visiten'];
                        $_SESSION['idVisite'] = $visiten[$idVisite];

                        // unset selected patient
//                        unset($_POST['selVisite']);
//                    print($_SESSION['idVisite']);
                    } else {
                        // unset global variables
                        unset($_SESSION['idVisite']);
                    }
                }
                ?>

                <h2>Therapieempfehlungssystem</h2>
                <p>Herzlich Wilkommen</p>

                </br>

                <div class="panel panel-default">                    
                    <div class="panel-body">                        
                        <form class="" action="" method="post">                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Patient:</span>
                                        <div class="form-group">
                                            <select class="form-control" name="selPatient" id="sel2">
                                                <option></option>
                                                <?php
                                                foreach ($patienten as $idPatient) {
                                                    if ($_SESSION['idPatient'] == $idPatient) {
                                                        echo "<option selected>$idPatient</option>";
                                                    } else {
                                                        echo "<option>$idPatient</option>";
                                                    }
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <span class="input-group-addon" id="basic-addon1">Visite:</span>
                                        <div class="form-group">
                                            <select onchange="this.form.submit()" class="form-control" name="selVisite" id="sel1">
                                            <!--<select class="form-control" name = "selVisite" id="sel1">-->
                                                <!--<option disabled selected value></option>-->
                                                <option></option>
                                                <?php
                                                $visiten = $_SESSION['visiten'];
                                                foreach ($visiten as $numVisite => $idVisite) {
                                                    if ($_SESSION['idVisite'] == $idVisite) {
                                                        echo "<option selected>$numVisite</option>";
                                                    } else {
                                                        echo "<option>$numVisite</option>";
                                                    }
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                                
                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                            <div class="btn-group" role="group">
                                                <button type="submit" class="btn btn-default" name="submit_speichern">Patient Neu</button>
                                            </div>
                                        </div>
                                    </div> 
                                </div><!-- /input-group -->

                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                            <div class="btn-group" role="group">
                                                <button type="submit" class="btn btn-default" name="submit_speichern">Visite Neu</button>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>

                </br>

                <ul class="nav nav-tabs">
                    <li role="presentation" <?php if ($_GET['action'] == 'patientendaten') echo " class=\"active\""; ?>><a href="index.php?action=patientendaten">Patientendaten</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'komorbiditaeten') echo " class=\"active\""; ?>><a href="index.php?action=komorbiditaeten">Komorbiditäten</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'schwere_pasi') echo " class=\"active\""; ?>><a href="index.php?action=schwere_pasi">PASI</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'schwere_patient') echo " class=\"active\""; ?>><a href="index.php?action=schwere_patient">Patienteneinschätzung</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'dlqi') echo " class=\"active\""; ?>><a href="index.php?action=dlqi">DLQI</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'therapien_erfolgt') echo " class=\"active\""; ?>><a href="index.php?action=therapien_erfolgt">Erfolgte Therapien</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'therapien_empfohlen') echo " class=\"active\""; ?>><a href="index.php?action=therapien_empfohlen">Aktuelle Therapie</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'therapien_rs') echo " class=\"active\""; ?>><a href="index.php?action=therapien_rs">Empfohlene Therapie</a></li>
                </ul>

            </div>

            <div class="questionblock">

                <?php
                if (isset($_SESSION['idVisite']) && isset($_SESSION['idPatient'])) {
                    if ($_GET['action'] == 'patientendaten') {
                        show_patientendaten();
                    } else if ($_GET['action'] == 'komorbiditaeten') {
                        show_komorbiditaeten();
                    } else if ($_GET['action'] == 'schwere_pasi') {
                        show_schwere_pasi();
                    } else if ($_GET['action'] == 'schwere_patient') {
                        show_schwere_patient();
                    } else if ($_GET['action'] == 'dlqi') {
                        show_dlqi();
                    } else if ($_GET['action'] == 'therapien_erfolgt') {
                        show_therapien_erfolgt();
                    } else if ($_GET['action'] == 'therapien_empfohlen') {
                        show_therapien_empfohlen();
                    } else if ($_GET['action'] == 'therapien_rs') {
                        show_therapien_rs();
                    }
                } else {
                    if (!isset($_SESSION['idPatient'])) {
                        echo "<div class=\"alert alert-warning\" role=\"alert\">";
                        echo "<strong>Kein Patient.</strong> ";
                        echo "Bitte Patient auswählen.";
                        echo "</div>";
                    } else if (!isset($_SESSION['idVisite'])) {
                        echo "<div class=\"alert alert-warning\" role=\"alert\">";
                        echo "<strong>Kein Visite.</strong> ";
                        echo "Bitte Visite auswählen.";
                        echo "</div>";
                    }
                }
                ?>

            </div>

            <?php
            disconnect_database($connection);
            ?>

        </section>
    </body>
</html>