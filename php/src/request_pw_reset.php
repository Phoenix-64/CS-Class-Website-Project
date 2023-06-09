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
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHI' .
                        'JKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, ($charactersLength - 1))];
    }
    return $randomString;
}//end generateRandomString()

// Get user data and create reset link
$user_email        = $_POST['email'];
$user_reset_string = generateRandomString(23);


$stmt = $db->prepare("UPDATE user SET pw_reset=? WHERE user_email=?");
$stmt->bind_param("ss", $user_reset_string, $user_email);
$stmt->execute();



$mail->setFrom($clientemail, 'Pheonixes Website Emailer');
$mail->addAddress($user_email, 'The User');
$mail->isHTML(true);
$mail->Subject = 'Phoenixes Website password reset';
$mail->Body    = "<p>If you requested the <a href='https://bepi-cs-webapp.herokuapp.com/pw_reset.php?email=$user_email&string=$user_reset_string'>link</a> proced with the password reset otherwise disregard it.</p><p> https://bepi-cs-webapp.herokuapp.com/pw_reset.php?email=$user_email&string=$user_reset_string</b>";

// send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: '.$mail->ErrorInfo;
    header(
        'location: practice.php?login_error=<span style="color:red">Reset Email could not be send contact developer.</span>'
    );
} else {
    echo 'Message sent!';
    header(
        'location: practice.php?login_error=<span style="color:green">Check your emails and spam folder reset Email should have been send.</span>'
    );
}
