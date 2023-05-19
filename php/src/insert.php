<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

require_once 'config.php';
require_once 'vendor/autoload.php';
require_once 'class-db.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;

// Set the encryption mechanism to use:
// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';

$db_r         = new DB();
$refreshToken = $db_r->get_refersh_token();

// Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId'     => $clientId,
        'clientSecret' => $clientSecret,
    ]
);
// Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider'     => $provider,
            'clientId'     => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName'     => $clientemail,
        ]
    )
);

function generateRandomString($length=10)
{
    $characters       = '0123456789abcdefghijklmnopqrstu' .
                        'vwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, ($charactersLength - 1))];
    }
    return $randomString;
}//end generateRandomString()

// Get the form data
$new_user_name     = $_POST['name'];
$new_user_email    = $_POST['email'];
$country           = $_POST['country'];
$new_user_password = $_POST['hashed_pw'];
$color = $_POST['color'];
$user_verify_string = generateRandomString(23);

// Include the config file
// Insert the new user into the database
$stmt = $db->prepare(
    "INSERT INTO user (user_id, user_name, user_email, user_password, 
    user_country, user_status, user_color, pw_reset) 
    VALUES (NULL,?,?,?,?,0,?, ?)"
);
$stmt->bind_param("ssssss", $new_user_name, $new_user_email, $new_user_password, 
                            $country, $color, $user_verify_string);
$stmt->execute();

$mail->setFrom($clientemail, 'Pheonixes Website Emailer');
$mail->addAddress($new_user_email, $new_user_name);
$mail->isHTML(true);
$mail->Subject = 'Phoenixes Website Email Verification';
$mail->Body    = "<b>To verify your email and be able to login click the following " . 
                "<a href='localhost:8000/verify_email.php?email=$new_user_email" .
                "&string=$user_verify_string'>link.</a> localhost:8000/verify_email.php?" .
                "email=$new_user_email&string=$user_verify_string</b>";

// Check if the insert was successful
if ($stmt->errno == 0 && $mail->send()) {
    // If the insert was successful, redirect to the login page with a success message
    header(
        "location: practice.php?registeration_successfull=<span style='color:green'>" .
        "You have successfully registered. You need to verify your email bevor you" .
        "can login, you should have recieved a email.</span>"
    );
} else {
      // If the insert failed, print an error message
      echo "failed";
      echo 'Mailer Error: '.$mail->ErrorInfo;
}
