<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $secret = '6LfjLH8rAAAAALriZIosaabXrdhJQYl-WylIuswO';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}&remoteip={$remoteip}");
    $captcha_success = json_decode($verify);

    if ($captcha_success->success) {
        echo "reCAPTCHA Verification successful";
        // Enter account creation logic
    } else {
        echo "reCAPTCHA Verification failed. Possible bot intrusion attempt.";
    }
}
?>