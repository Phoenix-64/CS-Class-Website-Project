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
        <a href="index.html">Home</a>
        <a href="Klettern.html">Klettern</a>
        <a href="Amateurfunk.html">Amaterufunk</a>
        <a href="Samariter.html">Samariter</a>
        <a href="Feuerwehr.html">Feuerwehr</a>
        <a href="Pfadi.html">Pfadi</a>
        <a href="Operateur.html" class="active">Operateur</a>
        <a href="practice.php">Chat</a>

        <div class="darkmode_button">
            <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
            <label for="darkmode"> Enable Darkmode</label>
        </div>
    </div>

    <div class="container">
        <div class="item">
            <h1>Theater Techniker</h1>
            <hr>
        </div>
        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>

        <div class="item">
            <h2>Operateur</h2>
            <p>
                Im rahmen eines Schulprogramms begann ich im FGB bei den Theater Technikern wodurch ich meinen Fabel für alles Technische ausleben konnte und viele neue Erfahrungen sammeln durfte.
                Wenn ihr mal was braucht, sagt einfach bescheid.
            </p>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/1672311533973.jpg" alt="Tanzveranstaltung" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311534000.jpg" alt="Endlich eine Linie" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311534008.jpg" alt="Noch eine Tanzveranstaltung" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533762.jpg" alt="Komplexere Aulaveranstalltung" >
                </div> 
                <div class="flex-item">
                    <video width="320" height="240" controls>
                        <source src="pictures/VID_20220622_211502.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video> 
                </div>
            </div>
            <hr>
        </div>

    </div>
</body>

</html>
<?php
session_start();
include_once('config.php');
if (isset($_SESSION["email"])) {
  $sql = "UPDATE user SET user_status='0' WHERE user_email=?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("s", $_SESSION["email"]);
  $stmt->execute();
  session_destroy();
}
?>
