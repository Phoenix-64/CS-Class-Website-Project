
<?php
session_start();

// Include the config file
include_once('config.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 0;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if($_FILES["fileToUpload"]["name"] == "") {
    header("location: chatroom.php?error=<span style='color:red'>Select a file</span>");
    exit();
  }

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 0;
  } else {
    echo "File is not an image.";
    $uploadOk = 1;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 2;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 200000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 3;
}

// Allow certain file formats
$supportedTypes = ["jpg", "png", "jpeg", "gif", "bmp"];
if(!in_array($imageFileType, $supportedTypes)) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 4;
}


if ($uploadOk == 0) {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";




    //Insert  file name into database
    $activ_user = $_POST['activ_user'];
    $stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $activ_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $active_user_result = $result->fetch_assoc();
    $active_chat_id = $active_user_result['active_chat'];



    if ($activ_user < $active_chat_id) {
        $chat_name_id = mysqli_real_escape_string($conn, $activ_user . $active_chat_id);
        }
      else {
        $chat_name_id = mysqli_real_escape_string($conn, $active_chat_id . $activ_user);
        }

    $filename_enc = $_POST['fileNameEnc'];
    
    $stmt = $db->prepare("INSERT INTO `$chat_name_id` (chat_id, chat_person_name, chat_value, chat_time, message_type, image_file
                          VALUES (NULL,?,'',NOW(),1,?)");
    $stmt->bind_param("ss", $_SESSION["name"], $filename_enc);
    $stmt->execute();



  } 
  else {
    echo "Sorry, there was an error uploading your file.";
    $uploadOk = 5;
    
  }
}


$color = "red";
switch($uploadOk) {
  case 0: 
    $respons = "Image uplaoded sucesfully";
    $color = "green";
    break;
  case 1:
    $respons = "File is not an image";
    break;
  case 2:
    $respons = "File already exists";
    break;
  case 3:
    $respons = "File is to large";
    break;
  case 4:
    $respons = "File is not of supported type: " . $supportedTypes;
    break;
  case 5:
    $respons = "sorry there was an unknown error contact the admin";
}
header("location: chatroom.php?error=<span style='color:$color'>$respons</span>");

?>
