<?php

include('database/config.inc.php');
/**
 * LOGIN - Part of Expertenbewertung project. This source file contains all functions
 * for login and user management.
 * @package Expertenbewertung
 * @author Felix Gräßer (IBMT, TU Dresden) <felix.graesser@tu-dresden.de>
 */
// Login prüfen
$login = check_login($_POST['user'], $_POST['pass']);
if ($login == 0) {
// starte Session und setzte global Experten ID
    session_start();
    $_SESSION['login'] = true;
    $_SESSION['idExperte'] = $_POST['user'];
// gehe zu Hauptseite
    $url = "mainpage.php";
    header("Location: $url");
} else {
// ungültiger Login
    $url = "index.php?action=$login";
    header("Location: $url");
}

// ----------------------------------------------------------------------------
// Funktion: Login ID für Benutzername zurückgegeben
// ----------------------------------------------------------------------------
function get_loginID($loginName) {

// Variablen definieren
    $loginUserID = 0;

// mit Login Datenbank verbinden
    $connection = connect_login();

// Login ID aus Datenbank lesen
    $qryLoginUser = mysqli_query("SELECT IDLogin FROM tbllogin WHERE txtUsername = '$loginName'");
    while ($rowLoginUser = mysqli_fetch_object($qryLoginUser)) {
        $loginUserID = $rowLoginUser->IDLogin;
    }

// Verbindung zu Login Datenbank trennen
    disconnect_login($connection);

// Login ID zurückgeben
    return $loginUserID;
}

// ----------------------------------------------------------------------------
// Funktion: Loginname und Passwort prüfen
// ----------------------------------------------------------------------------
function check_login($login_name, $login_pass) {

// Variablen definieren
    $message = null;

// mit Login Datenbank verbinden
    $connection = connect_login();

// Pruefen ob alle Angaben vorhanden
    if (empty($login_name) OR empty($login_pass)) {
        disconnect_login($connection);
        return $message = 2;
    }

// Logindaten laden
    $qryLogin = mysqli_query($connection,"SELECT txtPassword, txtUsername FROM tbllogin WHERE txtUsername = '$login_name'");
    $rowLogin = mysqli_fetch_object($qryLogin);

// Logindaten verschlüsseln
    $encrypted_password = password_hash($rowLogin->txtPassword, PASSWORD_DEFAULT);

// Logindaten prüfen
    if (password_verify($login_pass, $encrypted_password)) {
// Passwort war richtig.
        return $message = 0;
    } else {
// Passwort war falsch.
        disconnect_login($connection);
        return $message = 1;
    }

// Verbindung zu Login Datenbank trennen
    disconnect_login($connection);

// Fehler Flage zurückgeben
    return $message;
}

// ----------------------------------------------------------------------------
// Funktion: Prüfen ob Loginname Administratorrechte besitzt
// ----------------------------------------------------------------------------
function check_admin($login_id) {

// Variablen definieren
    $status = 0;

// mit Login Datenbank verbinden
    $connection = connect_login();

// Adminstrator Status lesen
    $qryLogin = mysqli_query("SELECT LoginAdmin_bln FROM tbllogin WHERE Login_ID = '$login_id'");
    $rowLogin = mysqli_fetch_object($qryLogin);
    $status = $rowLogin->LoginAdmin_bln;

// Verbindung zu Login Datenbank trennen
    disconnect_login($connection);

// Adminstrator Status zurückgeben
    return $status;
}
?>