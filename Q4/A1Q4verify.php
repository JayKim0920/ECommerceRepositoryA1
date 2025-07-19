<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;

// if the form is submitted without the secret in the session, prompts the user to try again
if (!isset($_SESSION['secret'])) {
    echo "<p>No secret found. Please <a href='A1Q4register.php'>start again</a>.</p>";
    exit;
}

// Generates QR Provider
$qrProvider = new BaconQrCodeProvider();

// Generates TwoFactorAuth with $qrProvider as its first value
$tfa = new TwoFactorAuth(
    $qrProvider,
    'E-Commerce App'
);

$secret = $_SESSION['secret'];

// Checks and verifies the session's secret value to generated value. Verification succeeds if the two match.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];

    if ($tfa->verifyCode($secret, $code)) {
        echo "<h2> You have entered the correct 2FA code. Login Successful!</h2>";
    } else {
        echo "<h2> Wrong 2FA code. Login Failed!</h2>";
    }
    // Resets Session data to destroy the secret once it is used.
    session_destroy();
}
?>