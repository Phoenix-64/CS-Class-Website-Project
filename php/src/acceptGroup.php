<?php
  // Start a new session
  session_start();

  // Include the config file
  require_once 'config.php';

  // Check if the chat form was submitted
if (isset($_POST['activ_user'])) {
    $active_user   = $_POST['activ_user'];
    $accepted_chat = $_POST['accepted_chat'];
    $N_public      = $_POST['N_public'];
    $chat_id       = ($accepted_chat * -1);

    $stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $active_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();

    // Get current requests and remove old one
    $current_request = $result['requests'];
    $new_requests    = str_replace(";group_chat".$accepted_chat.":0", "", $current_request);

    // Get and change availabelchats
    // Update users requests and add to availabel chats
    $sql      = "UPDATE user SET requests=? WHERE user_id=?";
    $stmt_upd = $conn->prepare($sql);
    $stmt_upd->bind_param("si", $new_requests, $active_user);
    $stmt_upd->execute();


    // Insert user into gorupchat_users
    $stmt = $db->prepare("SELECT * FROM groupchats WHERE groupchat_id = ?");
    $stmt->bind_param("i", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row    = $result->fetch_assoc();

    $new_groupchat_users = $row["groupchat_users"].";".$active_user;
    $new_groupchat_N     = $row["groupchat_Npublic"].";".$active_user."-".$N_public;

    $sql      = "UPDATE groupchats SET groupchat_users=?, groupchat_Npublic=? WHERE groupchat_id=?";
    $stmt_upd = $conn->prepare($sql);
    $stmt_upd->bind_param("ssi", $new_groupchat_users, $new_groupchat_N, $chat_id);
    $stmt_upd->execute();
}//end if
