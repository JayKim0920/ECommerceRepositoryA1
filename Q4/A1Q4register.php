<?php
require_once __DIR__ . '/vendor/autoload.php';

// Imports RobThree module - used for the backbone of the program(generating and validating of QR codes and OTPs)
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Algorithm;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;

// Instanciates default code provider(BaconQrCodeProvider)
$qrProvider = new BaconQrCodeProvider();

$tfa = new TwoFactorAuth(
    $qrProvider,                // IQRCodeProvider - how are the qr codes generated?
    'E-Commerce App',           // Issuer - who is the one requesting for TOTP verification?
    6,                           // Digits - How long is the code?
    30,                          // Period - How long does the code live?
    Algorithm::Sha1             // Algorithm - By what Algorithm is the key hashed?
);

session_start(); // Starts the session

// Generates secret and stores it within the session
if (!isset($_SESSION['secret'])) {
    $_SESSION['secret'] = $tfa->createSecret();
}
$secret = $_SESSION['secret'];

// Generates QR Code as Data URI
$qrCodeUrl = $tfa->getQRCodeImageAsDataUri('E-Commerce User', $secret);
?>
 
<h2>Scan this QR Code with Google Authenticator</h2>
<img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
<p>Or manually enter this secret: <strong><?php echo htmlspecialchars($secret); ?></strong></p>

<p>After registering, enter the code below to verify:</p>

<form action="A1Q4verify.php" method="post">
    <label>2FA Code:</label>
    <input type="text" name="code" required>
    <input type="submit" value="Verify">
</form>