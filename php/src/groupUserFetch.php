<?php
session_start();
require_once 'config.php';
$result = mysqli_query($conn, "SELECT * FROM user");


$already_fetched = $_POST["already_fetched"];
$active_user     = $_SESSION["user_id"];

$stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $active_user);
$stmt->execute();
$result_current = $stmt->get_result();
$current_user   = $result_current->fetch_assoc();

while ($row = mysqli_fetch_assoc($result)) {
    $user_id   = $row['user_id'];
    $user_name = $row['user_name'];
    if ($active_user == $user_id) {
        continue;
    }

    if (str_contains($already_fetched, $user_name)) {
        continue;
    }

    echo "$user_id:$user_name;";
}
