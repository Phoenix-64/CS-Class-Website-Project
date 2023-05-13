<?php
include_once('config.php');
include_once("groupchatsContentFetch.php");
//echo("Empty");
//echo("Epty2");

$activ_user = $_POST['activ_user'];
$stmt = $db->prepare("SELECT * FROM user WHERE user_id=?");
$stmt->bind_param("i", $activ_user);
$stmt->execute();
$result = $stmt->get_result();
$active_user_result = $result->fetch_assoc();

$active_chat_id = $active_user_result['active_chat'];

if ($active_chat_id < 0) {
    groupchatContent($active_user_result);
    exit();
}


if ($activ_user < $active_chat_id) {
    $chat_name_id = mysqli_real_escape_string($conn, $activ_user . $active_chat_id);
    }
else {
    $chat_name_id = mysqli_real_escape_string($conn, $active_chat_id . $activ_user);
    }

//Check if table exists:
$state = mysqli_query($conn, "SHOW TABLES LIKE '$chat_name_id'");
if (mysqli_fetch_assoc($state) == NULL) {
    echo("Select or request a Chat");
    exit();
}
$update = mysqli_query($conn, "UPDATE `$chat_name_id` SET `read`=TRUE WHERE 1");
// Select all chat records from the 'chat' table
$result = mysqli_query($conn, "SELECT * FROM `$chat_name_id`");
$stmt = $db->prepare("SELECT * FROM user WHERE user_name = ?");


// Loop through each chat record
while ($row = mysqli_fetch_assoc($result)) {
    // Extract the name and message from the current record
    $name = $row['chat_person_name'];
    $message = $row['chat_value'];
    $time = $row['chat_time'];
    $read = $row['read'];

    $stmt->bind_param("s", $name);
    $stmt->execute();
    $user = $stmt->get_result();
    $user_row = $user->fetch_assoc();
    $color = $user_row['user_color'];
    
    $align = "left";
    if ($name == $active_user_result["user_name"]) {
        $align = "right";
    }
    // Print the name and message
    switch($row['message_type']) {
        case 0:
            echo "$color;$align;$time;$name;$message;$read:::";
            break;
        case 1:
            $file_name = $row['image_file'];
            echo "$color;$align;$time;$name;$message;$read;$file_name:::";
            break;
        case 2:
            //key
            echo "key1241242:$chat_name_id:$message";
            $remove = mysqli_query($conn, "DELETE FROM `$chat_name_id` WHERE `message_type` = 2");
            break;
        case 3:
            //iv
            echo "iv1241242:$chat_name_id:$message";
            $remove = mysqli_query($conn, "DELETE FROM `$chat_name_id` WHERE `message_type` = 3");
            break;

    }

}
?>



