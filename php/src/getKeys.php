<?php
require_once 'config.php';

$activ_user    = $_POST['activ_user'];
$accepted_user = $_POST['accepted_user'];
$stmt          = $db->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $activ_user);
$stmt->execute();
$result = $stmt->get_result();
$accepted_user_result = $result->fetch_assoc();
$requests = explode(";", $accepted_user_result['requests']);
$raw      = implode("    ", $requests);
foreach ($requests as $key => $value) {
    if (str_contains($value, $accepted_user)) {
        $N_public = explode(":", $value)[1];
    }
}


echo("$N_public");
