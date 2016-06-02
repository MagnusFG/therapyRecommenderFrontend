<?php

function show_therapien_empfohlen() {
    ?>

<form class="questionblock" action="" method="post">

                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Id</th>
                            <th>Komorbidität</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $host = "localhost";   // Adresse des Datenbankservers, fast immer localhost
                        $user = "root";            // Dein MySQL Benutzername
                        $pass = "";            // Dein MySQL Passwort
                        $dbase = "psoriasis_database";           // Name der Datenbank

                        $connect = mysql_connect($host, $user, $pass) OR DIE("Keine Verbindung zu der Datenbank moeglich.");
                        $db = mysql_select_db($dbase, $connect) OR DIE("Auswahl der Datenbank nicht moeglich.");
                        $results = mysql_query("SELECT * FROM tblKomorbiditaeten LIMIT 10");
                        while ($row = mysql_fetch_array($results)) {
//                            print_r($row);
                            ?>
                            <tr>
                                <td><?php echo $row['IDKomorbiditaeten'] ?></td>
                                <td><?php echo $row['txtName'] ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </form>

<?php

}
    ?>