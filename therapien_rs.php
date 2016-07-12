<?php

function show_therapien_rs() {

    // Daten Patient
    $patient = $_SESSION['idPatient'];

    // Therapien
    $results = mysql_query("SELECT * FROM tblTherapieName WHERE ingTyp = 2");
    $therapies = array();
    while ($row = mysql_fetch_array($results)) {
        $therapies[$row['IDTherapie']] = $row['txtName'];
    }
    ?>

    <form class="questionblock" action="" method="post">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Therapie</th>
                    <th>Typ</th>
                    <th>Dosierung</th>
                    <th>Maßeinheit</th>
                    <th>Verabreichung</th>
                    <th>Wirksamkeit</th>
                    <th>UAW</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($therapies as $val) {
//                            print_r($row);

//                        echo "<tr style=\"background-color:#b3e6ff;\">";

//                        if ($typ == 1) {
//                            echo "<tr style=\"background-color:#b3e6ff;\">";
//                        }
//
//                        if ($typ == 2) {
//                            echo "<tr style=\"background-color:#99ffcc;\">";
//                        }
//
//                        if ($typ == 3) {
//                            echo "<tr style=\"background-color:#ffd9b3;\">";
//                        }
                    }
                    ?>
                <td><b><?php echo $val ?></b></td>

                <?php
                $val = '';
                if (isset($typ)) {
                    $results = mysql_query("SELECT * FROM tblTherapieTyp WHERE IDTherapieTyp = $typ");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['txtTyp'];
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
                    $val = $rowTmp['txtTherapieVerabreichung'];
                }
                ?>
                <td><?php echo $val ?></td>

                <?php
                $val = '';
                if (isset($row['Wirksamkeit'])) {
                    $tmp = $row['Wirksamkeit'];
                    $results = mysql_query("SELECT * FROM tblTherapieWirksamkeit WHERE IDTherapieWirksamkeit = $tmp");
                    $rowTmp = mysql_fetch_array($results);
                    $val = $rowTmp['txtTherapieWirksamkeit'];
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
                </tr>

                <?php
            
            ?>
            </tbody>
        </table>

    </form>

    <?php
}
?>