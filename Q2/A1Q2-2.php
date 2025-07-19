<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $secret = '6LffNH8rAAAAALll1sRrB3ZDg0-4QjPJKL5lc43x';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}&remoteip={$remoteip}");
    $captcha_success = json_decode($verify);

    if ($captcha_success->success && $captcha_success->score >= 0.5) { //change to >= 0.95 when testing failure
        echo "reCAPTCHA v3 Verification successful. Score: " . $captcha_success->score;
        // Enter account creation logic
    } else {
        echo "reCAPTCHA v3 Verification failed. Score: " . $captcha_success->score;
    }
}
?>