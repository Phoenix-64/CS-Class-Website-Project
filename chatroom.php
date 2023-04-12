<!DOCTYPE html>
<html lang="en">



<?php
session_start();
?>

<script>

  function changeActive(element) {
    element.style.backgroundColor = "red";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'changeActiveChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&active_chat=' + element.dataset.user);
    xhr.onreadystatechange = function() {}

  }


  function changeRequest(element) {
    console.log("Requested: " + element.dataset.user);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'requestChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&requested_user=' + element.dataset.user);
    xhr.onreadystatechange = function() {console.log(xhr.responseText)}
  }
  
  
  function acceptRequest(element) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'acceptChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&accepted_user=' + element.dataset.user);
    xhr.onreadystatechange = function() {}
  }


  function declineRequest(element) {
    var xhr = new XMLHttpRequest();
    console.log("activ_user: " + document.getElementById('user').dataset.user + "  declined_user: " + element.dataset.user)
    xhr.open('POST', 'declineChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&declined_user=' + element.dataset.user);
    xhr.onreadystatechange = function() {console.log(xhr.responseText)}
  }



  function getText() {
    var text = document.getElementById('text').value;
	  document.getElementById('text').value = "";

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chatdb.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('chat=' + text + '&activ_user=' + document.getElementById('user').dataset.user);
    xhr.onreadystatechange = function() {console.log(xhr.responseText)}
  }

  function setText() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chatFetch.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user);
    xhr.onreadystatechange = function() {
      // alert(xhr.responseText);
      document.getElementById('chatarea').innerHTML = xhr.responseText;
    }
  }

  setInterval(setText, 500);

  setInterval(users, 500);



  function users() {
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'userFetch.php', true);
    xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr1.send('activ_user=' + document.getElementById('user').dataset.user);
    xhr1.onreadystatechange = function() {
      // alert(xhr.responseText);
      document.getElementById('loginperson').innerHTML = xhr1.responseText;
    }
  }





</script>
<?php
include_once('config.php');

if (isset($_GET['logout'])) {
  $result = mysqli_query($conn, "UPDATE user SET user_status = '0' WHERE user_email = '$_SESSION[email]';");
  session_destroy();
  header('location: practice.php?logout_successfully=<span style="color:green">You have successfully Logged Out.</span>');
}
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
  <a href="practice.php" class="active">Chat</a>

  <div class="darkmode_button">
    <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
    <label for="darkmode"> Enable Darkmode</label>
  </div>
        
</div>



<div> 
  <h1> Chat</h1>
  <hr>
  <script type="text/javascript">cookie_notice();</script>
  <?php
  $name = $_SESSION['name'];
  $result = mysqli_query($conn, "SELECT * FROM user WHERE user_email = '$_SESSION[email]';");
  $user_id = mysqli_fetch_assoc($result)['user_id'];
  echo "Aktueller Benutzer: <span id='user' data-user='$user_id'>$name</span>";
  ?>
  <form action="">
    <input type="submit" name="logout" value="logout">
  </form>
</div>
<div class="chat_container">
  <div id="chatbox">
    <div id="chatarea"></div>

    <div id="textbox">
      <form>
        <textarea rows="4" cols="100" id="text" onkeyup="if(event.keyCode==13) {getText()}"></textarea>
        <input type="button" value="send" onclick="getText()" />
      </form>
    </div>
  </div>
  <div id="loginperson"> </div>
</div>
<div><hr></div>

<?php
if (!isset($_SESSION['email']) && !isset($_SESSION['password'])) {
  session_destroy();
  header('location: practice.php');
}
?>
</body>
</html>