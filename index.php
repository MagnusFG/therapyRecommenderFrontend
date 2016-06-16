<?php
include('patientendaten.php');
include('komorbiditaeten.php');
include('schwere_pasi.php');
include('schwere_patient.php');
include('dlqi.php');
include('therapien_erfolgt.php');
include('therapien_empfohlen.php');
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

        <!--Header--> 
        <section>
            <div class="intro-umfrage"> 
            </div>
        </section>

        <!-- umfrage laden -->

        <!--<div class="header-content">-->
        <!--<section class="questionblock">-->
        <section class="container">
            <div class="mainblock">

                <?php
                $connection = connect_database();
                ?>

                <?php
                // fill patienten array
                $patienten = array();
                $results = mysql_query("SELECT * FROM tblVisite100");
                while ($row = mysql_fetch_array($results)) {
                    $patienten[] = $row['Patient'];
                }
                ?>

                <?php
                // input visite
                if (isset($_POST['selVisite']) && isset($_SESSION['visiten'])) {
                    $visiten = $_SESSION['visiten'];
//                    print_r($visiten);
                    $idVisite = $_POST['selVisite'];
                    $_SESSION['idVisite'] = $visiten[$idVisite];
//                    print($_SESSION['idVisite']);
                }
                
                // input patient
                $visiten = array();
                if (isset($_POST['selPatient'])) {
                    // set idPatient
                    $patient = $_POST['selPatient'];
                    $_SESSION['idPatient'] = $patient;

                    // fill visiten array
                    $results = mysql_query("SELECT * FROM tblVisite100 WHERE Patient = $patient ORDER BY NumVisite DESC LIMIT 1");
                    while ($row = mysql_fetch_array($results)) {
                        $numVisite100 = $row['NumVisite'];
                    }
//                    print($numVisite100);
                    $results = mysql_query("SELECT * FROM tblVisite WHERE Patient = $patient AND NumVisite <= $numVisite100 ORDER BY NumVisite ASC");
                    while ($row = mysql_fetch_array($results)) {
                        $visiten[$row['NumVisite']] = $row['IDVisite'];
                    }
//                    print_r($visiten);
                    $_SESSION['visiten'] = $visiten;
                    unset($_SESSION['idVisite']);                    
                }

                // set experte TODO
                $_SESSION['idExperte'] = 1;
                ?>

                <h2>Therapieempfehlungssystem</h2>
                <p>Herzlich Wilkommen, Sie sind angemeldet mit der Experten ID <?php echo $_SESSION['idExperte'] ?></p>

                </br>

                <form class="" action="" method="post">
                    <div class = "container" style="width:300px">

                        <div class="row">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Visite:</span>
                                <div class="form-group">
                                    <select onchange="this.form.submit()" class="form-control" name="selVisite" id="sel1">
                                    <!--<select class="form-control" name = "selVisite" id="sel1">-->
                                        <!--<option disabled selected value></option>-->
                                        <option></option>
                                        <?php
                                        $visiten =   $_SESSION['visiten'];
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
                            </div><!-- /input-group -->
                        </div><!-- /.row -->  
                </form> 

                </br>

                <form class="" action="" method="post">
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Patient:</span>
                            <div class="form-group">
                                <select onchange="this.form.submit()" class="form-control" name="selPatient" id="sel2">
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
                        </div><!-- /input-group -->
                    </div><!-- /.row -->

                    </br>
                </form>      

                </br>

            </div>

            </br>

            <ul class="nav nav-tabs">
                <li role="presentation" <?php if ($_GET['action'] == 'patientendaten') echo " class=\"active\""; ?>><a href="index.php?action=patientendaten">Patientendaten</a></li>
                <li role="presentation" <?php if ($_GET['action'] == 'komorbiditaeten') echo " class=\"active\""; ?>><a href="index.php?action=komorbiditaeten">Komorbiditäten</a></li>
                <li role="presentation" <?php if ($_GET['action'] == 'schwere_pasi') echo " class=\"active\""; ?>><a href="index.php?action=schwere_pasi">PASI</a></li>
                <li role="presentation" <?php if ($_GET['action'] == 'schwere_patient') echo " class=\"active\""; ?>><a href="index.php?action=schwere_patient">Patienteneinschätzung</a></li>
                <li role="presentation" <?php if ($_GET['action'] == 'dlqi') echo " class=\"active\""; ?>><a href="index.php?action=dlqi">DLQI</a></li>
                <li role="presentation" <?php if ($_GET['action'] == 'therapien_erfolgt') echo " class=\"active\""; ?>><a href="index.php?action=therapien_erfolgt">Erfolgte Therapien</a></li>
                <li role="presentation" <?php if ($_GET['action'] == 'therapien_empfohlen') echo " class=\"active\""; ?>><a href="index.php?action=therapien_empfohlen">Empfohlene Therapie</a></li>
            </ul>

        </div>

        <div class="questionblock">

            <?php
            if (isset($_SESSION['idVisite']) && $_SESSION['idVisite'] != '') {
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
    <!--</div>-->

</body>
</html>