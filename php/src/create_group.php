<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once 'config.php';
?>


<script>

setInterval(users, 500)

function insert_users(value, index, array) {
    values = value.split(":");
    label = document.createElement('label'),
    input = document.createElement('input');
    br = document.createElement('br');
    input.type = "checkbox";
    input.name = values[0];
    input.value = values[0];
    label.innerText = values[1];


    document.getElementById('persons').appendChild(input);
    document.getElementById('persons').appendChild(label);
    document.getElementById('persons').appendChild(br);

}

function users() {
  var xhr1 = new XMLHttpRequest();
  xhr1.open('POST', 'groupUserFetch.php', true);
  xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
  xhr1.send('activ_user=' + document.getElementById('user').dataset.user  + '&already_fetched=' + document.getElementById('persons').innerText);
  xhr1.onload = function() {
    // alert(xhr.responseText);
    
    if (xhr1.responseText) {
        let values = xhr1.responseText.split(";");
        values.pop();
        values.forEach(insert_users);
    }
    
  }
}
</script>

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

<div> 
    <h1> Create a group chat</h1>
    <hr>
    <script type="text/javascript">cookie_notice();</script>
    <?php
        $user_id = $_SESSION['user_id'];
        echo "Aktueller Benutzer: <div id='user' data-user='$user_id'></div>";
    ?>
    <div class="group_container">
    <form action="group_insert.php" class="group_form" >
        <label for="lname">Group Name:</label><br>
        <input type="text" id="group_name" name="group_name">
        <div id="persons">
        </div>
        <input type="submit" value="Submit">
    </form>
    </div>
</div>
