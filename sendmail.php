<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get and sanitize form data
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $subject = htmlspecialchars(trim($_POST['subject']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>
                    alert("Invalid email format!");
                    window.history.back();
                  </script>';
            exit;
        }

        // SMTP Configuration
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = 'smtp.gmail.com';
        $mail->Username   = 'maddurinaresh3@gmail.com';  // SMTP Email
        $mail->Password   = 'dmcr peuz cmbq dnsy';       // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipient (Send to yourself)
        $mail->setFrom('maddurinaresh3@gmail.com', 'Website Contact Form');
        $mail->addAddress('maddurinaresh3@gmail.com', 'Naresh'); // Send to yourself
        $mail->addReplyTo($email, $name); // Reply to the user's email

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body    = "<h2>Contact Form Submission</h2>
                          <p><strong>Name:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Subject:</strong> $subject</p>
                          <p><strong>Message:</strong><br>$message</p>";

        // Send Email
        $mail->send();

        echo '<script>
                alert("Your message has been sent successfully!");
                window.location.href = "index.html";
              </script>';
    } catch (Exception $e) {
        echo '<script>
                alert("Message could not be sent. Error: ' . addslashes($mail->ErrorInfo) . '");
                window.history.back();
              </script>';
    }
}
?>
