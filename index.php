<?php
include('patientendaten.php');
include('schwere_arzt.php');
include('schwere_patient.php');
include('therapien_erfolgt.php');
include('therapien_empfohlen.php');
include('therapien_rs.php');
include('config.inc.php');

session_start();

//$disabled = "disabled";
//$disabled = '';

$_SESSION['idExperte'] = 12;
$patienten = array(); // liste mit allen patienten im system
$visiten = array(); // liste mit allen visiten für einen ausgewählten patienten
$idPatient = ''; // ausgewählter patient id
$idPatientPrev = ''; // neuer patient ausgewählt?
$idVisite = ''; // ausgewählte visite id
$numVisite = ''; // ausgewählte visite number
$disabled = ''; //disabled'; // disbable intput / output element
$disabledSelect = ''; // disable select patient / visite
$disabledButtonVisite = ''; // disable buttons
$disabledButtonPatient = ''; // disable buttons
//$cmd = '"W:\daten\Promotion TUD\Arbeit\Projekt ZEGV\Matlab\system\main\for_testing\main.exe"';
//$outputfile = '"W:\daten\Promotion TUD\Arbeit\Projekt ZEGV\Matlab\system\main\for_testing\out.log"';
//$pidfile = '"W:\daten\Promotion TUD\Arbeit\Projekt ZEGV\Matlab\system\main\for_testing\pid.log"';
//pclose(popen("start /B ". $cmd, "r"));
//pclose(popen("start /B ". $cmd, "r"));
//$out = '';
//$return_var = '';
//exec($cmd);
//$handle = popen($cmd,"r");
//$handle = popen($cmd, "r");$outputfile
//$outputfile = ''; 
//exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
//echo sprintf("%s > %s 2>&1", $cmd, $outputfile);
//exec(sprintf("%s > %s 2>&1", $cmd, $outputfile));
//$output = shell_exec($cmd);
//echo "<pre>$output</pre>";
//$descriptorspec = array(
//   0 => array("pipe", "r"),  // STDIN ist eine Pipe, von der das Child liest
////   1 => array("pipe", "w"),  // STDOUT ist eine Pipe, in die das Child schreibt
////   2 => array("file", $outputfile, "a") // STDERR ist eine Datei,
////   0 => array("file", "error-output.txt", "r"), // STDOUT ist eine Datei,
//   1 => array("file", "output.txt", "w"), // STDOUT ist eine Datei,
//   2 => array("file", "error-output.txt", "w") // STDERR ist eine Datei,
//                                                    // in die geschrieben wird
//);
//
////$cwd = '/tmp';
//$env = array('some_option' => 'aeiou');
//$process = proc_open('php', $descriptorspec, $pipes, $cwd, $env);
//$process = proc_open("start /b \"\" " .$cmd, $descriptorspec, $pipes);
//pclose(popen("start /B \"\" " . $cmd, "a"));  // mode = "a" since I had some logs to edit
//pclose(popen($cmd, "r"));
//start /b "" "c:\Program Files\Wireshark\tshark.exe" -i 1 -w file1.pcap
//if (!isset($_SESSION['process']) || is_resource($_SESSION['process'])) {
//    $_SESSION['process'] = proc_open("start /b \"\" " .$cmd, $descriptorspec, $pipes);
// $pipes sieht nun so aus:
// 0 => Schreibhandle, das auf das Child STDIN verbunden ist
// 1 => Lesehandle, das auf das Child STDOUT verbunden ist
// Jedwede Fehlerausgaben werden an /tmp/error-output.txt angefügt
//    fwrite($pipes[0], 0);
//    fclose($pipes[0]);
//    echo stream_get_contents($pipes[1]);
//    fclose($pipes[1]);
// Es ist wichtig, dass Sie alle Pipes schließen bevor Sie
// proc_close aufrufen, um Deadlocks zu vermeiden
//    $return_value = proc_close($process);
//    echo "Rückgabewert des Kommandos: $return_value\n";
//}
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

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <?php
//        if (!isset($_GET['action'])) {
//            $_GET['action'] = 'patientendaten';
//        } else {
//            // save input
//            
//        }

        if (!isset($_SESSION['action'])) {
            $_SESSION['action'] = 'patientendaten';
        }

        if (!isset($_GET['action'])) {
            $_GET['action'] = $_SESSION['action'];
        } else {
            // save input
        }
        $_SESSION['action'] = $_GET['action'];
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
                if (isset($_SESSION['idPatient'])) {
                    $idPatientPrev = $_SESSION['idPatient'];
                }

                if (isset($_POST['selPatient'])) {
                    if ($_POST['selPatient'] != '') {

                        // set idPatient
                        $idPatient = $_POST['selPatient'];

                        // fill visiten array
                        $results = mysql_query("SELECT * FROM tblVisite WHERE Patient = $idPatient ORDER BY NumVisite ASC");
                        while ($row = mysql_fetch_array($results)) {
                            $visiten[$row['NumVisite']] = $row['IDVisite'];
                        }
                        // set global variables
                        $_SESSION['idPatient'] = $idPatient;
                        $_SESSION['visiten'] = $visiten;
                    } else {
                        // unset global variables
                        unset($_SESSION['idPatient']);
//                        unset($_SESSION['idVisite']);
                        unset($_SESSION['visiten']);
                    }

                    // reset selected visite if new patient selected
                    if ($idPatientPrev != $idPatient) {
                        unset($_POST['selVisite']);
                        unset($_SESSION['idVisite']);
                    }
                }

//        // input selected visite
                if (isset($_POST['selVisite'])) {
                    if ($_POST['selVisite'] != '') {

                        // set numVisite
                        $numVisite = $_POST['selVisite'];

                        // set global variables
                        $visiten = $_SESSION['visiten'];
                        $_SESSION['idVisite'] = $visiten[$numVisite];
                    } else {

                        // unset global variables
                        unset($_SESSION['idVisite']);
                    }
                }

                // Button Visite Neu verarbeiten
                if (isset($_POST['visite_neu'])) { // wenn visite neu gedrueckt, ...
// ... aktiviere Eingaben
                    $disabled = '';
// ... disable Auswahl Patient und Visite
//                    $disabledSelect = 'disabled';
//                    $disabledButtonPatient = 'disabled';
// ... finde letzte Visite
                    $idPatient = $_SESSION['idPatient'];
                    $sql = mysql_query("SELECT * FROM tblVisite WHERE Patient = $idPatient ORDER BY NumVisite DESC");
                    $row = mysql_fetch_array($sql);
                    if (!$row['NumVisite']) {
                        $numVisite = 0;
                    } else {
                        $numVisite = $row['NumVisite'] + 1;
                    }

// ... apppend Visite
                    $sql = mysql_query("INSERT INTO tblVisite (Patient,NumVisite) VALUE ($idPatient,$numVisite)");
                    $retval = mysql_query($sql, $connection);
//               
                    // ... update visiten array
                    $results = mysql_query("SELECT * FROM tblVisite WHERE Patient = $idPatient ORDER BY NumVisite ASC");
                    while ($row = mysql_fetch_array($results)) {
                        $visiten[$row['NumVisite']] = $row['IDVisite'];
                    }

//                    $numVisite = $_POST['selVisite'];
                    // set global variables
                    $_SESSION['idVisite'] = $visiten[$numVisite];
                    $_SESSION['visiten'] = $visiten;

                    // find last element $visiten
                    // $numVisite = last element + 1;
                    // insert and load
                    // $_SESSION['idVisite'] = $visiten[$numVisite];
                }

                // Button Patient Neu verarbeiten
                if (isset($_POST['patient_neu'])) { // wenn visite neu gedrueckt, ...
// ... aktiviere Eingaben
                    $disabled = '';
// ... disable Auswahl Patient und Visite
//                    $disabledSelect = 'disabled';
//                    $disabledButtonVisite = 'disabled';
                    // ... insert new patient
//                    $sql = mysql_query("INSERT INTO tblpatient");
//                    $retval = mysql_query($sql, $connection);
// ... apppend patient
                    $dat = NULL;
                    $sql = mysql_query("INSERT INTO tblpatient (Geschlecht) VALUE (1)");
                    $retval = mysql_query($sql, $connection);

//                        $results = mysql_query("SELECT * FROM tblPatientendatenVisite WHERE Visite = $visite");
//    $row = mysql_fetch_array($results);
                    // ... find last patient
                    $sql = mysql_query("SELECT * FROM tblpatient ORDER BY IDPatient DESC");
                    $row = mysql_fetch_array($sql);
                    $idPatient = $row['IDPatient'];

                    // update patient list
                    $results = mysql_query("SELECT * FROM tblPatient");
                    while ($row = mysql_fetch_array($results)) {
                        $patienten[] = $row['IDPatient'];
                    }

//                  // set global variables
                    $_SESSION['idPatient'] = $idPatient;
                    $_SESSION['visiten'] = $visiten;

                    // reset selected visite if new patient selected
                    unset($_POST['selVisite']);
                    unset($_SESSION['idVisite']);
                }


//        // write IDPatient and selVisite to input table
//        if (isset($_POST['selVisite'])) {
//            if ($_POST['selVisite'] != '') {
//                // write IDPatient and selVisite to input file
//                $patient = $_SESSION['idPatient'];
//                $idVisite = $_SESSION['idVisite'];
//                $results = mysql_query("INSERT INTO tblinput (Patient, NumVisite) VALUES ($patient, $idVisite)");
//            }
//        }
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
                                            <select <?php echo "$disabledSelect" ?> onchange="this.form.submit()" class="form-control" name="selPatient" id="sel2">
                                                <option></option>
                                                <?php
                                                foreach ($patienten as $idPatient) {
                                                    if ($_SESSION['idPatient'] == $idPatient) {
                                                        echo "<option selected>$idPatient</option>";
                                                    } else {
                                                        echo "<option >$idPatient</option>";
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
                                            <select <?php echo "$disabledSelect" ?> onchange="this.form.submit()" class="form-control" name="selVisite" id="sel1">
                                            <!--<select class="form-control" name = "selVisite" id="sel1">-->
                                                <!--<option disabled selected value></option>-->

                                                <option></option>
                                                <?php
                                                $visiten = $_SESSION['visiten'];
                                                foreach ($visiten as $numVisite => $visite) {
                                                    if ($_SESSION['idVisite'] == $visite) {
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
                                                <?php
                                                if ($disabledButtonVisite == '') {
                                                    echo "<button $disabledButtonPatient type=\"submit\" class=\"btn btn-default\" name=\"patient_neu\">Patient Neu</button>";
                                                } else {
                                                    echo "<button $disabledButtonPatient type=\"submit\" class=\"btn btn-default\" name=\"fertig\">Fertig</button>";
                                                }
                                                ?>                                                
                                            </div>
                                        </div>
                                    </div> 
                                </div><!-- /input-group -->

                                <div class="col-lg-6">
                                    <div class="input-group" style="margin: 5px">
                                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                            <div class="btn-group" role="group">
                                                <?php
                                                if ($disabledButtonPatient == '') {
                                                    echo "<button $disabledButtonVisite type=\"submit\" class=\"btn btn-default\" name=\"visite_neu\">Visite Neu</button>";
                                                } else {
                                                    echo "<button $disabledButtonVisite type=\"submit\" class=\"btn btn-default\" name=\"fertig\">Fertig</button>";
                                                }
                                                ?>
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
                    <li role="presentation" <?php if ($_GET['action'] == 'schwere_arzt') echo " class=\"active\""; ?>><a href="index.php?action=schwere_arzt">Einschätzung Arzt</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'schwere_patient') echo " class=\"active\""; ?>><a href="index.php?action=schwere_patient">Einschätzung Patient</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'therapien_erfolgt') echo " class=\"active\""; ?>><a href="index.php?action=therapien_erfolgt">Therapien Erfolgt</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'therapien_empfohlen') echo " class=\"active\""; ?>><a href="index.php?action=therapien_empfohlen">Therapieempfehlung Arzt</a></li>
                    <li role="presentation" <?php if ($_GET['action'] == 'therapien_rs') echo " class=\"active\""; ?>><a href="index.php?action=therapien_rs">Therapieempfehlung System</a></li>
                </ul>

            </div>

            <div class="questionblock">

                <?php
                if (isset($_SESSION['idVisite']) && $_SESSION['idVisite'] != '') {
                    if ($_GET['action'] == 'patientendaten') {
                        show_patientendaten($disabled, $connection);
                    } else if ($_GET['action'] == 'schwere_arzt') {
                        show_schwere_arzt($disabled, $connection);
                    } else if ($_GET['action'] == 'schwere_patient') {
                        show_schwere_patient($disabled, $connection);
                    } else if ($_GET['action'] == 'therapien_erfolgt') {
                        show_therapien_erfolgt($disabled, $connection);
                    } else if ($_GET['action'] == 'therapien_empfohlen') {
                        show_therapien_empfohlen($disabled, $connection);
                    } else if ($_GET['action'] == 'therapien_rs') {
                        show_therapien_rs();
                    }
                } else {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">";
                    echo "<strong>Kein Visite.</strong> ";
                    echo "Bitte Visite auswählen.";
                    echo "</div>";
                }
                ?>

            </div>

            <?php
            disconnect_database($connection);
            ?>

        </section>
    </body>
</html>