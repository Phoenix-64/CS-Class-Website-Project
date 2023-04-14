<?php
include_once('config.php');

$activ_user = $_POST['activ_user'];
$accepted_user = $_POST['accepted_user'];
$accepted_user_result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE user.user_id ='$activ_user'"));
$requests = explode(";", $accepted_user_result['requests']);
$raw = implode("    ", $requests);
foreach ($requests as $key => $value) {
    if (str_contains($value, $accepted_user)) {
        $N_public = explode(":", $value)[1];
    }
}


echo("$N_public")

?>



