<?php
include_once('config.php');
//echo("Empty");
//echo("Epty2");

$activ_user = $_POST['activ_user'];
$active_user_result =mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE user.user_id ='$activ_user'"));
$active_chat_id = $active_user_result['active_chat'];

if ($activ_user < $active_chat_id) {
    $chat_name_id = $activ_user . $active_chat_id;
    }
else {
    $chat_name_id = $active_chat_id . $activ_user;
    }

//Check if table exists:
$state = mysqli_query($conn, "SHOW TABLES LIKE '$chat_name_id'");
if (mysqli_fetch_assoc($state) == NULL) {
    echo("Select or request a Chat");
    exit();
}

// Select all chat records from the 'chat' table
$result = mysqli_query($conn, "SELECT * FROM `$chat_name_id`");

// Loop through each chat record
while ($row = mysqli_fetch_assoc($result)) {
    // Extract the name and message from the current record
    $name = $row['chat_person_name'];
    $message = $row['chat_value'];
    $time = $row['chat_time'];

    $user = mysqli_query($conn, "SELECT *FROM user WHERE user.user_name='$name'"
    );
    $color = mysqli_fetch_assoc($user)['user_color'];
    
    $align = "left";
    if ($name == $active_user_result["user_name"]) {
        $align = "right";
    }
    // Print the name and message
    switch($row['message_type']) {
        case 0:
            echo "$color;$align;$time;$name;$message:::";
            break;
        case 1:
            $file_name = $row['image_file'];
            echo "$color;$align;$time;$name;$message;$file_name:::";
            break;
        case 2:
            //key
            echo "key1241242:$message";
            $remove = mysqli_query($conn, "DELETE FROM `$chat_name_id` WHERE `message_type` = 2");
            break;
        case 3:
            //iv
            echo "iv1241242:$message";
            $remove = mysqli_query($conn, "DELETE FROM `$chat_name_id` WHERE `message_type` = 3");
            break;

    }

}
?>



