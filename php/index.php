<!DOCTYPE html>
<html >
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags--> 

        <!-- Title -->
        <title>Login Form</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/login.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="css/style.css">-->

        <!-- Custom Fonts from Google -->
        <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>-->

    </head>

    <body>

        <?php
        // eingelogged?
        session_start();
        if (isset($_SESSION['login'])) {
            // gehe zu Hauptseite
            $url = "mainpage.php";
            header("Location: $url");
        } else {
            // starte Session
            session_unset();
            unset($_GET['action']);
            ?>

        <body>
            <h2>Therapieempfehlungssystem</h2>
            <p>Expertenbewertung</p>
            </br>

            <div class="login">           

                <div class="login-screen">

                    <img src="images/TU_Logo_HKS41.png" alt="Logo TUD" style="width:175px;">
                    <img src="images/Logo_ZEGV_small.png" alt="Logo ZEGV" style="width:65px;">

                    <div class="app-title">
                        <h3>Login</h3>
                    </div>

                    <div class="login-form">
                        <!--<form action="https://localhost/Expertenbewertung/login.php" method="post">-->
                        <form action="login.php" method="post">
                            <div class="control-group">
                                <input type="text" class="login-field" value="" placeholder="Benutzer" id="loginname" name="user">
                                <label class="login-field-icon fui-user" for="login-name"></label>
                            </div>

                            <div class="control-group">
                                <input type="password" class="login-field" value="" placeholder="Passwort" id="loginpass" name="pass">
                                <label class="login-field-icon fui-lock" for="login-pass"></label>
                            </div>

                            <?php
                            // Eingaben verarbeiten
                            if (isset($_GET['action'])) {
                                if ($_GET['action'] == 1) {
                                    echo "Zugriff verweigert.";
                                } elseif ($_GET['action'] == 2) {
                                    echo "Bitte geben Sie Benutzernamen und Passwort ein.";
                                }
                            }
                            ?>

                            <button class="btn btn-primary btn-large btn-block">anmelden</button>

                        </form>
                    </div>
                </div>
            </div>
        </body>

        <?php
    }
    ?>

</body>
</html>
