<?php

function show_therapien_rs($disabled, $connection) {

// Parameter
    $patient = $_SESSION['idPatient'];
    $visite = $_SESSION['idVisite'];
    $visiten = $_SESSION['visiten'];
    $numVisite = array_search($visite, $visiten);
    $therapies = array();
    $numRecom = 3;

    // fetch recommendation
    if (isset($_POST['generiere_therapieempfehlung'])) {
        $sql = mysql_query("SELECT * FROM tbltherapiesvisitesystlist WHERE Visite = $visite ORDER BY Score DESC LIMIT $numRecom");
        while ($row = mysql_fetch_array($sql)) {
            $therapies[$row['Therapie']] = $row['Score'];
        }
    } else {
        // insert visite into input interface if not already in queue
        $sql = mysql_query("SELECT * FROM tblInputInterface WHERE Visite = $visite ORDER BY IDInput DESC LIMIT 1");
        $row = mysql_fetch_array($sql);
        if (empty($row['IDInput'])) {
            // empty table to make sure no old request is in queue
            $sql = mysql_query("TRUNCATE TABLE tblInputInterface");
            $retval = mysql_query($sql, $connection);
            // append new request
            $sql = mysql_query("INSERT INTO tblInputInterface(Visite, Patient, NumVisite) VALUES ($visite,$patient,$numVisite)");
            $retval = mysql_query($sql, $connection);
        }
    }
    ?>


    <form class = "questionblock" method = "post" id = "section_empfehlungarzt" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_empfehlungarzt">

        <div class = "panel panel-primary">
            <!--Default panel contents -->
            <div class = "panel-heading">Vom Therapieempfehlungssystem empfohlene Therapie:</div>

            <table class = "table table-striped">
        <!--                <colgroup>
                        <col width = "500">
                        <col width = "500">
                        <col width = "80">
                        <col width = "80">
                        <col width = "80">
                        <col width = "80">
                    </colgroup>-->
                <thead>
                    <tr>
                        <th>Score</th>
                        <th>Therapie</th>
                        <th>Therapie ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    $therapieCnt = 0;
                    foreach ($therapies as $therapie => $score) {

//                        $therapieCnt ++;
//                        echo "<tr style=\"background-color:#7FFFD4;\">";
                        echo "<tr>";

//                        if ($infoTyp[$id] == 1) {
//                            echo "<tr style=\"background-color:#66f;\">";
//                            $therapieCnt ++;
//                        }
//
//                        if ($infoTyp[$id] == 2) {
//                            echo "<tr style=\"background-color:#ff9;\">";
//                        }
//
//                        if ($infoTyp[$id] == 3) {
//                            echo "<tr style=\"background-color:#ffd9b3;\">";
//                        }
//
//                        if ($infoTyp[$id] == 1 && $therapieCnt > $numRecom) {
//                            echo "<tr style=\"background-color:#b3e6ff;\">";
//                        }
//                        if ($therapieCnt > $numRecom) {
//                            echo "<tr style=\"background-color:#b3e6ff;\">";
//                        }
                        ?>
                    <td><b><?php echo round(100 * $score, 2) ?></b></td>
                    <?php
                    $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $therapie");
                    $row = mysql_fetch_array($results);
                    $therapieName = $row['Name'];
                    ?>
                    <td><b><?php echo $therapieName ?></b></td>
                    <td><b><?php echo $therapie ?></b></td> 

                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

            </br>
            </br>

            <div style="margin: 5px;">
                <button type="submit" name="generiere_therapieempfehlung" class="btn btn-primary " type="button" value=<?php echo $visite; ?><?php echo $disabled; ?>>
                    Therapieempfehlung
                </button>
            </div>               

        </div>
    </form>


    <?php
}
?>
