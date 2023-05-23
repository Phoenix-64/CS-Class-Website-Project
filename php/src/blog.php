<!DOCTYPE html>
<html lang="en">
<script>
</script>
<!-- styling and navbar -->
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
  <a href="blog.php" class="active">Blog</a>
  <div class="darkmode_button">
    <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
    <label for="darkmode"> Enable Darkmode</label>
  </div>
        
</div>
<div class="container">
<h1> All Blog Posts</h1>
<hr>

<script type="text/javascript">cookie_notice();</script>

<?php if (isset($_GET['logout_successfully'])) {
    ?><?php echo $_GET['logout_successfully']; ?>
<?php } ?>
<?php if (isset($_GET['registeration_successfull'])) {
    ?><?php echo $_GET['registeration_successfull']; ?>
<?php } ?>

<div class="flex-container" style="flex-direction: row;"> 
<div style="margin-right: 5vw;">
<?php
require_once 'config.php';
$result = mysqli_query($conn, 'select * from country');
if (!$result) {
    echo 'query failed';
}
?>

<table><tr>
<td colspan="2"><center><h2>Registrieren</h2></td></tr><tr>
<form method="post" action="insert.php">
<td>Name : </td><td><input type="text" name="name" onblur="validate(this.value)" id="name"/></td><td><div id="nameDiv"></div></td></tr><tr>
<td>Email : </td><td><input type="email" name="email" onblur="validate(this.value)" id="email" /></td><td><div id="emailDiv"></div></td>
</tr><tr>

<td>Kanton : </td><td><select name="country">
<?php while ($row = mysqli_fetch_assoc($result)) {?>
<option value="<?php echo $row['country_id']; ?>"> <?php echo $row['country_name']; ?>
</option>

<?php } ?>
</select></td><td><div id="city_display"></div>
</td></tr><tr>

<td>Farbe in Hex: </td><td><input type="text" name="color" id="color" onblur="validate(this.value)"/></td><td> <!-- Farbe wird nicht richtig gespeichert -->
<div id="cnfrmcol"></div></td></tr><tr>

<td>Password : </td><td><input type="password" name="pass1" id="pass1" onblur="validate()" /></td></tr><tr>
<td>Password bestätigen : </td><td><input type="password" name="pass2" id="pass2" onblur="validate()" /></td><td>
<div id="cnfrmpass"></div></td></tr><tr>
<input type='hidden' id='hashed_pw' name='hashed_pw' value="">
<td colspan="2"><center><input type="submit" name="sbt" id="submit" disabled/></td></table></form> 
</div>

<div style="margin-left: 5vw;">
<form method="post" action="process.php" onSubmit="return setHashed()">
<table><tr>
<td colspan="2"><center> <h2>Login</h2></td>
</tr>
<tr>
<td>
Email : </td><td><input type="email" name="email"  /></td></tr><tr>
<td> Password : </td><td><input type="password" id="password" name="password" /></td></tr>
<tr><td colspan="2"><center> <input type="submit" name="loginbtn" /></td></tr></table>
<input type='hidden' name='page' value='chat' />
<input type='hidden' id='hashed_pw_2' name='hashed_pw_2' value="">
</form> 
<?php if (isset($_GET['login_error'])) {
    ?><?php echo ($_GET['login_error']); ?>
<?php } ?>
</div>
</div>
<div><hr></div>
</div>
</body>
</html>
