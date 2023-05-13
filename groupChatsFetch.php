<?php
session_start();
include_once('config.php');
$result= mysqli_query($conn , "SELECT * FROM groupchats");

$active_user = $_SESSION["user_id"];

$stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $active_user);
$stmt->execute();
$result_current = $stmt->get_result();
$current_user = $result_current->fetch_assoc();
$requests_for_active = $current_user['requests'];








//Fetch availabel chats and requests that other users made to the active ones


//If array is NULL initialize to [];


while ($row = mysqli_fetch_assoc($result)){
	$groupchat_users = $row['groupchat_users'] . ";" . $row["groupchat_creator"];
	$group_id = $row["groupchat_id"];
	//skip if active user
	echo($_POST["already_fetched"].  $row['groupchat_name'] . "      ");
	if(str_contains($_POST["already_fetched"], $row['groupchat_name'])) {
        continue;
    }

	echo("::" . $group_id . ";" . $row['groupchat_name'] . ";" . $row["groupchat_Npublic"]);

	$open_N_requests = $row["groupchat_Npublic"];
	if (!empty($open_N_requests)) {
		echo (";1");
	}
	else {
		echo(";0");
	}


	if(str_contains($requests_for_active, ";" . "group_chat-" . $row["groupchat_id"])) {

		echo(";0");
	}
	elseif(str_contains($groupchat_users, $active_user)) {
		echo(";1");

	}
}

?>