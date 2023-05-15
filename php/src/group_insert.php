<script src="RSA_PRogramm/ras_example.js"></script>
<script src="chacha-js/chacha.js"></script>

<script>
function generateCHACHA(name){
    let key = new Array(CHACHA_KEYSIZE).fill().map(() => Math.floor(65535 * Math.random()))
    let iv = new Array(CHACHA_IVSIZE).fill().map(() => Math.floor(65535 * Math.random()))
    localStorage.removeItem(name);
    localStorage.setItem(name + "key", key)
    localStorage.setItem(name + "iv", iv)
    window.location.href = 'chatroom.php?error=Group Created'
}
</script>


<?php
session_start();
require_once 'config.php';
$url = $_SERVER['QUERY_STRING'];
// $url = "group_name=Maximilians&17=17&19=19&20=20&21=21";
$parameters = explode("&", $url);
echo "$url";
$name = $_GET["group_name"];
array_shift($parameters);
$user_ids = "";

// $_SESSION["user_id"] = "12";
$stmt = $db->prepare(
    "INSERT INTO groupchats (groupchat_id, groupchat_name, groupchat_users, groupchat_creator) 
VALUES (NULL,?,?,?)"
);
$stmt->bind_param("sss", $name, $user_ids, $_SESSION["user_id"]);
$stmt->execute();
$chacha_path = "group_chat-".$stmt->insert_id;

$stmt1 = $db->prepare("SELECT requests FROM user WHERE user_id = ?");
$stmt2 = $conn->prepare("UPDATE user SET requests=? WHERE user_id=?");
foreach ($parameters as $value) {
    $invited_user = explode("=", $value)[1];
    $user_ids     = $user_ids.$invited_user.";" ;


    $stmt1->bind_param("i", $invited_user);
    $stmt1->execute();
    $result  = $stmt1->get_result();
    $row     = $result->fetch_assoc();
    $current = $row['requests'];


    $new_requests = $current.";".$chacha_path.":".(0000);
    // Update users requests
    $stmt2->bind_param("si", $new_requests, $invited_user);
    $stmt2->execute();
}





// $stmt = $db->prepare("SELECT groupchat_id FROM groupchats WHERE groupchat_name=")
echo "<script>generateCHACHA('$chacha_path')</script>";



?>





<head>
    <meta charset="UTF-8">
    <link id="pagestyle" rel="stylesheet" href="styles_dark.css" />
    <link id="pagestyle" rel="stylesheet" href="chat_style.css" />
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
  <a href="Operateur.html">Operateur</a>
  <a href="practice.php">Chat</a>

  <div class="darkmode_button">
    <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
    <label for="darkmode"> Enable Darkmode</label>
  </div>
        
</div>

