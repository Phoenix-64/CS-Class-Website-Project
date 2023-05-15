<?php
session_start();
require_once 'config.php';
if (isset($_SESSION["email"])) {
    $sql  = "UPDATE user SET user_status='0' WHERE user_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link id="pagestyle" rel="stylesheet" href="styles_dark.css" />
    <script type="text/javascript" src="sticky_navbar.js"></script>
    <script type="text/javascript" src="cookie_notice.js"></script>
    <script type="text/javascript" src="darkmode_cookie.js"></script>
    <title>Homepage | Phönix 64</title>
    <meta name="description" content="Homepage">
    <meta name="author" content="Phönix 64">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div id="navbar">
        <a href="index.php">Home</a>
        <a href="Klettern.php">Klettern</a>
        <a href="Amateurfunk.php">Amaterufunk</a>
        <a href="Samariter.php">Samariter</a>
        <a href="Feuerwehr.php">Feuerwehr</a>
        <a href="Pfadi.php" class="active">Pfadi</a>
        <a href="Operateur.php">Operateur</a>
        <a href="practice.php">Chat</a>

        <div class="darkmode_button">
            <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
            <label for="darkmode"> Enable Darkmode</label>
        </div>
    </div>

    <div class="container">
        <div class="item">
            <h1>Pfadi</h1>
            <hr>
        </div>
        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>
        
        <div class="item">
            <h2>Pfadi Andromeda Murten</h2>
            <p>
                Während einer Veranstaltung im FGB sprach mich der AL der Pfadi Murten an ob ich nicht lust hätte mal dort zu leiten.
                Es stellte sich heraus das ich schon mal da war aber mich garnicht mehr daran erinnere. Also begann mein <a class="ta" href="https://pfadimurten.ch/">Pfadi Murten</a> Erlebnis.
            </p>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/1672311533855.jpg" alt="Übertritt 2022" >
                </div> 
            </div>
            <hr>
        </div>
        <div class="item">
            <h2>Pfadi Andromeda Murten</h2>
            <p>
                Danke dass ich mit euch das MOVA erleben durfte. Bundeslager Pfadi Schweiz 2022.
            </p>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/1672311533952.jpg" alt="Los gehts mit meinem Bruder" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533943.jpg" alt="Uhh Feuerwehr" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533927.jpg" alt="Essensschlage" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533918.jpg" alt="Kids spielen Kids happy" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533900.jpg" alt="Party" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533890.jpg" alt="ISS kontakt" >
                </div> 
            </div>
            <hr>
        </div>
    </div>
</body>

</html>

