<?php
  // Connect to the database
  $conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'ajaxdb'
  ) or die ('problem to connect database');
  $clientemail = 'phoenix.email.bot@gmail.com'; // the email used to register google app
$clientId = '475866746761-ctaoja4v0ela6aavjui9qgc4vlaq02vn.apps.googleusercontent.com';
$clientSecret = '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';
?>
