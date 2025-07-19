<?php
session_start();

if (!isset($_SESSION['2fa_code'])) {
    echo "<p>No verification code found. Please <a href='A1Q3login.php'>login again</a>.</p>";
    exit;
}

// Verify MFA code
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_code = $_POST['code'];
    $correct_code = $_SESSION['2fa_code'];

    if ($input_code == $correct_code) {
        echo "<h2>You have entered 2FA secret code correctly. Login Successful!</h2>";
        session_destroy(); // End session
    } else {
        echo "<h2>You have entered Wrong 2FA secret code. Login Failed!</h2>";
        session_destroy();
    }
    exit;
}
?>

<h2>We have sent a secret code to your email.<br>
Please check your email and insert the code in the following input field:</h2>

<form method="post" action="">
    <label>Two Factor Authentication Code:</label>
    <input type="text" name="code" required>
    <input type="submit" value="Verify Code">
</form>