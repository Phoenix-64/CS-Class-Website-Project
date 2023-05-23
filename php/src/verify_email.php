<?php
session_start();
// Include the config file
require_once 'config.php';
?>
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
  <a href="index.php" >Home</a>
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

<?php 
if (isset($_GET['email']) && isset($_GET['string'])) {
  $email  = $_GET['email'];
  $string = $_GET['string'];

  $stmt = $db->prepare("SELECT * FROM user WHERE user_email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result       = $stmt->get_result();
  $row          = $result->fetch_assoc();
  $saved_string = $row['pw_reset'];

  if ($saved_string !== $string) {
      echo("Your provided string is not valid");
  } else {
      $stmt = $conn->prepare("UPDATE user SET pw_reset='', 
                        verified=TRUE WHERE user_email=?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      header(
        'location: practice.php?login_error=<span style="color:green">Your email is now verified you can now log in thank you and have fun. </span>'
      );
    }
} else {
    echo("No string and Email given");
}//end if
?>
<?php if (isset($_GET['login_error'])) {
    ?><?php echo ($_GET['login_error']); ?>
<?php } ?>
</div>
<body>
