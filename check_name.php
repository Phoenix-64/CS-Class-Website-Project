<?php
$name = $_GET['name'];
//echo $email;
include_once('config.php');
$result = mysqli_query ($conn , "SELECT * FROM ajaxdb.user WHERE user_name = '".$name."'");
$rows = mysqli_num_rows($result);
//echo $rows;
if($rows > 0 )
{
	echo "<font color='#FF0000'>Name bereits vergeben</font>";

}
else {
	echo "<font color='#00CC00'>Name frei</font>";

	} ?>




					