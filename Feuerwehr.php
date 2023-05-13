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
        <a href="Feuerwehr.html" class="active">Feuerwehr</a>
        <a href="Pfadi.html">Pfadi</a>
        <a href="Operateur.html">Operateur</a>
        <a href="practice.php">Chat</a>

        <div class="darkmode_button">
            <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
            <label for="darkmode"> Enable Darkmode</label>
        </div>
    </div>
    
    <div class="container">
        <div class="item">
            <h1>Freiwillige Feuerwehr</h1>
            <hr>
        </div>
        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>

        <div class="item">
            <h2>Jugend Feuerwehr</h2>
            <p>
                2016 begann ich meine Feuerwehrkariere bei der Jugend, und erlebte viele tolle Übungen. 
                Wenn du bereits 12 Jahre alt und noch unter 18 bist dann empfehle ich dir sofort zur <a class="ta" href="https://www.feuerwehr-murten.ch/de/%C3%BCber-uns/jugendfeuerwehr/">Jugendfeuerwehr Murten</a> zu kommen und in das Feuerwehrleben einzutauchen. 
            </p>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/54209261_2227580157570258_7017416656842391552_n.jpg" alt="Die Rettungssanitäter sind uns besuchen gekommen" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/56355256_2240792556249018_6746015543104372736_n.jpg" alt="Hindernissparkour mit Hydraulischem Gerät" >
                </div> 
            </div>
            <hr>
        </div>
        <div class="item">
            <h2>Freiwillige Feuerwehr</h2>
            <p>
                Inzwischen bin ich bei den Grossen und erlebe den Ernst der Feuerwehr.
            </p>
        </div>
        <div class="item"><hr></div>
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
