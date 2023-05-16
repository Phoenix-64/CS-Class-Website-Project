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
    <link id="pagestyle" rel="stylesheet" href="transition.css" />
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
        <a href="index.php" class="active">Home</a>
        <a href="Klettern.php">Klettern</a>
        <a href="Amateurfunk.php">Amaterufunk</a>
        <a href="Samariter.php">Samariter</a>
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
            <h1>Benjamins Homepage</h1>
            <hr>
        </div>
        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>

        <div class="item">
            <p>
                Im rahmen eines Projektes meines Computersienece Kurses habe ich diese Webseite gebaut. Viel freude beim Durchsuchen.
                Für weitere Programier Projekte könnt ihr bei meinem <a class="ta" href="https://github.com/Phoenix-64">GitHub</a> vorbeischauen.
            </p>
        </div>
        <div class="carus_container">
            <div class="carousel">
                <div class="carousel-item">
                  <img alt="First slide" src="pictures/1670006601822.jpg" />
                </div>
                <div class="carousel-item">
                 <img alt="Second slide" src="pictures/1670347103834.jpg" />
                </div>
                <div class="carousel-item">
                 <img alt="Third slide" src="pictures/1670347103892.jpg" />
                </div>
                <div class="carousel-item">
                 <img alt="Fourth slide" src="pictures/1670347103900.jpg" />
                </div>
            </div>
        </div>


        <div class="item"><hr></div>

    </div>

</body>
</html>
