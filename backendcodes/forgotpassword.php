<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['resetpassword'])) {

    include 'connection.php';

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if (mysqli_num_rows($check) > 0) {

        // Generate random password
        $newPasswordPlain = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

        // Hash password
        $newPasswordHashed = password_hash($newPasswordPlain, PASSWORD_DEFAULT);

        // Update database
        mysqli_query($conn, "UPDATE users SET password='$newPasswordHashed' WHERE email='$email'");

        // Load PHPMailer
        require 'backendcodes/PHPMailer/src/PHPMailer.php';
        require 'backendcodes/PHPMailer/src/SMTP.php';
        require 'backendcodes/PHPMailer/src/Exception.php';

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kezjoana7@gmail.com';
            $mail->Password   = 'xddr fkbk swkt nikk'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->isHTML(true);
            $mail->setFrom('mytourdraft@gmail.com', 'Irembo AI-POWERED');

            $mail->addAddress($email);
            $mail->Subject = "Irembo AI-POWERED: Password Reset Successful";
            $mail->Body = "
                <p>Hello,</p>
                <p>Your password has been successfully reset.</p>

                <p><strong>New Password:</strong> {$newPasswordPlain}</p>

                <p>Please login and change this password immediately for security reasons.</p>

                <p>If you did not request this, contact support immediately.</p>

                <p>Irembo AI-POWERED Team</p>
            ";

            $mail->send();

            echo "
            <script>
                swal({
                    title: 'Password Reset!',
                    text: 'A new password has been sent to your email.',
                    icon: 'success',
                    button: 'OK'
                });
            </script>
            ";

        } catch (Exception $e) {
            echo "
            <script>
                swal({
                    title: 'Email Error!',
                    text: 'Failed to send reset email. Try again.',
                    icon: 'error',
                    button: 'OK'
                });
            </script>
            ";
        }

    } else {

        echo "
        <script>
            swal({
                title: 'Email Not Found!',
                text: 'No account found with this email.',
                icon: 'warning',
                button: 'OK'
            });
        </script>
        ";
    }
}
?>