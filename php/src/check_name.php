<?php
$name = $_GET['name'];
// echo $email;
require_once 'config.php';

$stmt = $db->prepare("SELECT * FROM user WHERE user_name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

// echo $rows;
if ($result->num_rows > 0) {
    echo "<font color='#FF0000'>Name bereits vergeben</font>";
} else {
    echo "<font color='#00CC00'>Name frei</font>";
}
