<?php
$email = $_GET['email'];
//echo $email;
include_once('config.php');

$stmt = $db->prepare("SELECT * FROM user WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$rows = $stmt->num_rows;
//echo $rows;
if($stmt->num_rows > 0 )
{
	echo "<font color='#FF0000'>Email bereits vergeben </font>";

}
else {
	echo "<font color='#00CC00'>Email frei </font>";

	} ?>




					