<?php

// config.inc.php

function connect_database() {
        $host = "localhost";   // Adresse des Datenbankservers, fast immer localhost
        $user = "root";            // Dein MySQL Benutzername
        $pass = "";            // Dein MySQL Passwort
//        $dbase = "psoriasis_database_system";           // Name der Datenbank
        $dbase = "psoriasis_database_praxis";           // Name der Datenbank

    $connection = mysql_connect($host, $user, $pass) OR DIE("Keine Verbindung zu der Datenbank moeglich.");
    mysql_query("SET NAMES 'utf8'");
    $db = mysql_select_db($dbase, $connection) OR DIE("Auswahl der Datenbank nicht moeglich.");
    
    return $connection;
}

function disconnect_database($connection) {

    mysql_close($connection);
}

?>