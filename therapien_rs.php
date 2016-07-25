<?php

function show_therapien_rs() {

// Daten Patient
    $patient = $_SESSION['idPatient'];

// Therapien
//    $results = mysql_query("SELECT * FROM tbltherapierecom WHERE ingTyp = 2 ORDER BY Indicator DESC");
//    $therapies = array();
//    while ($row = mysql_fetch_array($results)) {
//        $indicator[$row['IDTherapie']] = $row['Indicator'];
//        $therapies[$row['IDTherapie']] = $row['txtName'];
//        $info[$row['IDTherapie']] = $row['Information'];
//        $infoTyp[$row['IDTherapie']] = $row['InfoTyp'];
//    }
//    print_r($info);
    // select between input and show therapie?
    $select = 0;
//    if (isset($_SESSION['visiten']) && isset($_SESSION['idVisite'])) {
//        $idVisite = $_SESSION['idVisite'];
//        $visiten = $_SESSION['visiten'];
//        $numVisite = array_search($idVisite, $visiten);
//        $maxNumVisite = max(array_keys($visiten));
//        if ($numVisite == $maxNumVisite) {
//            $select = 1;
//        }
//    }
    ?>

    <?php
// Therapie eingeben
    if ($select == 1) {
        ?>

        <form class="questionblock" action="" method="post">
            
                <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Jemals angewendete Therapien:</div>


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th>Therapie</th>
                        <th>Information</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $therapieCnt = 0;
                    $numRecom = 3;
                    $n = count($therapies);
                    $factor = ($n ^ 2 + $n) / 2 + 1;
                    foreach ($therapies as $id => $val) {

                        echo "<tr style=\"background-color:#b3e6ff;\">";

                        if ($infoTyp[$id] == 1) {
                            echo "<tr style=\"background-color:#66f;\">";
                            $therapieCnt ++;
                        }

                        if ($infoTyp[$id] == 2) {
                            echo "<tr style=\"background-color:#ff9;\">";
                        }

                        if ($infoTyp[$id] == 3) {
                            echo "<tr style=\"background-color:#ffd9b3;\">";
                        }

                        if ($infoTyp[$id] == 1 && $therapieCnt > $numRecom) {
                            echo "<tr style=\"background-color:#b3e6ff;\">";
                        }
                        ?>
                    <td><b><?php echo round($indicator[$id] / $factor, 2) ?></b></td>
                    <td><b><?php echo $val ?></b></td>
                    <td><b><?php echo $info[$id] ?></b></td>             

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
        echo "<div class=\"alert alert-warning\" role=\"alert\">";
        echo "<strong>Kein Therapieempfehlung.</strong> ";
        echo "Für diese Visite keine Therapieempfehlung vorhanden.";
        echo "</div>";
    }
    ?>

    <?php
}
?>