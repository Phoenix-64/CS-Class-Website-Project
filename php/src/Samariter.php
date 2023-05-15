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
    <script type="text/javascript" src="darkmode_cookie.js"></script>
    <script type="text/javascript" src="cookie_notice.js"></script>

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
        <a href="Samariter.php" class="active">Samariter</a>
        <a href="Feuerwehr.php">Feuerwehr</a>
        <a href="Pfadi.php">Pfadi</a>
        <a href="Operateur.php">Operateur</a>
        <a href="practice.php">Chat</a>

        <div class="darkmode_button">
            <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
            <label for="darkmode"> Enable Darkmode</label>
        </div>
    </div>

    <div class="container">
        <div class="item">
            <h1>Samariter</h1>
            <hr>
        </div>
        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>

        <div class="item">
            <h2>Jugend Samariter HELP</h2>
            <p>
                Auf der suche nach einem neuen Hobby habe ich vor 5 Jahren die <a class="ta" href="https://help-bern.ch/">HELP Bern</a> entdeckt  
                
            </p>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/272118628_968122127386092_2528155418960993079_n.jpg" alt="Wundversorgungsmaterial Kennenlernen" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/315056916_438306388477442_7372747336858736853_n.jpg" alt="Fallbeispel" >
                </div> 
            </div>
            <hr>
        </div>
        <div class="item">
            <h2>Samariter</h2>
            <p>
                Daneben mache ich inzischen bei den erwachsenen mit.
                Mit dem Verein Loraine-Breitenrain ache ich verschiedene Sanidienste wie zumbeispiel am GP, Frauenlauf oder der BEA. 
                Vielleicht sieht mann sich ja mal, die Sanizimmer sind immer eine gute Anlaufstelle.
            </p>
        </div>
        <div class="item"><hr></div>
    </div>
</body>

</html>
