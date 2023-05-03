<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
 
include_once('config.php');
require_once 'vendor/autoload.php';
require_once 'class-db.php';
 
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
 
//Set the encryption mechanism to use:
// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
 
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';
 

 
$db = new DB();
$refreshToken = $db->get_refersh_token();
 
//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);
 
//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $clientemail,
        ]
    )
);



function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Get user data and create reset link
$user_email = $_POST['email'];
$user_reset_string = generateRandomString(23);

$query = mysqli_query(
    $conn,
    "UPDATE user SET pw_reset='$user_reset_string' WHERE user_email='$user_email'"
  );


$mail->setFrom($clientemail, 'Pheonixes Website Emailer');
$mail->addAddress($user_email, 'The User');
$mail->isHTML(true);
$mail->Subject = 'Phoenixes Website password reset';
$mail->Body = "<b>If you requested the link proced with the password reset otherwise disregard it: https://localhost/myTestWebapp/pw_reset.php?email=$user_email&string=$user_reset_string</b>";
 
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    header(
        'location: practice.php?login_error=<span style="color:red">Reset Email could not be send contact developer.</span>'
      );
} else {
    echo 'Message sent!';
    header(
        'location: practice.php?login_error=<span style="color:green">Check your emails and spam folder reset Email should have been send.</span>'
      );
}
?>




