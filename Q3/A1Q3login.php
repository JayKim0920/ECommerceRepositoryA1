<?php
session_start();
require 'vendor/autoload.php'; // Used when PHPmailer was installed with composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Login function
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email address
    if ($email === 's3726103@rmit.edu.vn' && $password === '1234') { // Account and password to be used in the demonstration form
        // Generates secret code
        $code = rand(100000, 999999);
        $_SESSION['2fa_code'] = $code;
        $_SESSION['email'] = $email;

        // Send email with PHPmailer
        $mail = new PHPMailer(true);

        try {
            // Configure server
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';           // SMTP server. Change accordingly should the email server be different
            $mail->SMTPAuth   = true;
            //TODO : Enter email and password of the test email under. Default value will be a placeholder due to security reasons.
            $mail->Username   = 'Recipient_Email';     // enter email to recieve MFA here
            $mail->Password   = 'App_Password';        // enter app's password here
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipient
            $mail->setFrom('Recipient_Email', 'E-Commerce App'); // enter email to recieve MFA here
            $mail->addAddress('Recipient_Email'); // enter email to recieve MFA here

            // Contents
            $mail->isHTML(true);
            $mail->Subject = 'Your verification code';
            $mail->Body    = "Your verification code is: <strong>$code</strong>";

            $mail->send();
            echo "<p>We have sent a secret code to your email.</p>";
            echo "<a href='A1Q3verify.php'>Click here to verify your code</a>";
            exit;

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "<p>Invalid email or password!</p>";
    }
}
?>

<h2>Login Form for Email-based Two Factor Authentication</h2>
<form method="post" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>