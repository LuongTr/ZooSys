<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Update the path to match where PHPMailer is actually located
// Use absolute paths instead of relative paths to avoid issues
if (file_exists('D:/xampp/htdocs/zms/vendor/autoload.php')) {
    require 'D:/xampp/htdocs/zms/vendor/autoload.php';
} else {
    // Use absolute paths
    require 'D:/xampp/htdocs/zms/phpmailer/src/Exception.php';
    require 'D:/xampp/htdocs/zms/phpmailer/src/PHPMailer.php';
    require 'D:/xampp/htdocs/zms/phpmailer/src/SMTP.php';
}

function sendTicketEmail($to, $subject, $ticketInfo) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'YOUR GMAIL ADDRESS@gmail.com'; // YOUR GMAIL ADDRESS
        $mail->Password   = 'YOUR APP PASSWORD';    // YOUR APP PASSWORD
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom('tl26022003@gmail.com', 'Zoo Management System');
        $mail->addAddress($to);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $ticketInfo;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>