<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');
  

?>
<script>


function checkPasswordMatch() {
  // Get the values of the pass1 and pass2 elements
  const pass1 = document.getElementById('pass1').value;
  const pass2 = document.getElementById('pass2').value;
  // Check if the values are equal
  if (pass1 === pass2) {
    // Update the cnfrmpass element with a message indicating the passwords match
    document.getElementById('cnfrmpass').innerHTML = '<font color="#00CC00">Passwörter stimmen</font>';

    if (pass1.length < 6) {
      document.getElementById('cnfrmpass').innerHTML = '<font color="red">Passwort zu kurz</font>';
      document.getElementById("submit").disabled = true;
      return false;
    }
    document.getElementById("submit").disabled = false;
    return true;
  } 
  else {
    // Update the cnfrmpass element with a message indicating the passwords do not match
    document.getElementById('cnfrmpass').innerHTML = '<font color="red">Passwörter stimmen nicht überein</font>';
    document.getElementById("submit").disabled = true;
    return false;
  }
}
</script>
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
  <a href="index.html" >Home</a>
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
<div class="container">
<h1>Password Reset</h1>
<form method="post" action="insert_reset_pw.php">
<table>
<tr>
<td>Password : </td><td><input type="password" name="pass1" id="pass1" onblur="checkPasswordMatch()" /></td></tr><tr>
<td>Password bestätigen : </td><td><input type="password" name="pass2" id="pass2" onblur="checkPasswordMatch()" /></td><td>
<div id="cnfrmpass"></div></td></tr><tr>

<?php if(isset($_GET['email']) && isset($_GET['string'])){ 

$email = $_GET['email'];
$string = $_GET['string'];

$stmt = $db->prepare("SELECT * FROM users WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$saved_string = $row['pw_reset'];

if($saved_string !== $string) {
    echo("Your provided string is not valid");
}
else {
echo ("<input type='hidden' name='emailadress' value='$email' /><input type='hidden' name='string' value='$string' />");
}
}
else {
    echo("No string and Email given");
} ?>
<input type='hidden' name='email' value='chat' />
<tr><td colspan="2"><center> <input type="submit" name="submit" id="submit" disabled /></td></tr></table>
<?php if( isset($_GET['login_error'])){ ?><?php echo ($_GET['login_error']); ?>
<?php } ?>
</form> 
</div>
<body>
