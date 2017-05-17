<?php

function show_therapien_rs($disabled, $connection) {

// Parameter
    $patient = $_SESSION['idPatient'];
    $visite = $_SESSION['idVisite'];
    $visiten = $_SESSION['visiten'];

    // insert visite into input interface
    $numVisite = array_search($visite, $visiten);
    $sql = mysql_query("INSERT INTO tblInputInterface(Visite, Patient, NumVisite) VALUES ($visite,$patient,$numVisite)");
    $retval = mysql_query($sql, $connection);

// Therapien
//    $results = mysql_query("SELECT * FROM tbltherapierecom WHERE ingTyp = 2 ORDER BY Indicator DESC");
    $therapies = array();
//    while ($row = mysql_fetch_array($results)) {
//        $indicator[$row['IDTherapie']] = $row['Indicator'];
//        $therapies[$row['IDTherapie']] = $row['txtName'];
//        $info[$row['IDTherapie']] = $row['Information'];
//        $infoTyp[$row['IDTherapie']] = $row['InfoTyp'];
//    }
//    print_r($indicator);
//    print_r($therapies);  
//    print_r($info);
    // select between input and show therapie?
    // fetch recommendation
    if (isset($_POST['generiere_therapieempfehlung'])) {
        $results = mysql_query("SELECT * FROM tbltherapierecom WHERE Visite = $visite ORDER BY Indicator DESC");
        $therapies = array();
    while ($row = mysql_fetch_array($results)) {
            $indicator[$row['IDTherapie']] = $row['Indicator'];
            $therapies[$row['IDTherapie']] = $row['txtName'];
            $info[$row['IDTherapie']] = $row['Information'];
            $infoTyp[$row['IDTherapie']] = $row['InfoTyp'];
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
                        <th>Indikator</th>
                        <th>Therapie</th>
                        <th>Information</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $therapieCnt = 0;
                    $numRecom = 3;
                    foreach ($therapies as $id => $val) {

                        $therapieCnt ++;
                        echo "<tr style=\"background-color:#7FFFD4;\">";

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
                        if ($therapieCnt > $numRecom) {
                            echo "<tr style=\"background-color:#b3e6ff;\">";
                        }
                        ?>
                    <td><b><?php echo round(100 * $indicator[$id], 2) ?></b></td>
                    <?php
                    $results = mysql_query("SELECT * FROM tblTherapieName WHERE IDTherapie = $val");
                    $row = mysql_fetch_array($results);
                    $valName = $row['Name'];
                    ?>
                    <td><b><?php echo $valName ?></b></td>
                    <td><b><?php echo $info[$id] ?></b></td>             

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
