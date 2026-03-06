<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['register'])){

    include 'connection.php';

    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if(empty($phone) || empty($email)){
        echo "<script>
        swal('Missing Information','Phone and Email are required.','warning');
        </script>";
    }

    if($password !== $confirm_password){
        echo "<script>
        swal('Password Error','Passwords do not match.','error');
        </script>";
    }

    // Check duplicate
    $check = mysqli_query($conn, 
        "SELECT id FROM users WHERE phone='$phone' OR email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>
        swal('Account Exists',
             'Phone number or Email already registered.',
             'warning');
        </script>";
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    mysqli_query($conn, 
        "INSERT INTO users (phone,email,password,account_type)
         VALUES ('$phone','$email','$hashed_password','Both')");



    /* =====================================
       📧 SEND CONFIRMATION EMAIL
    ===================================== */

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

        $mail->Subject = "Irembo AI-POWERED: Account Created Successfully";

        $mail->Body = "
            <p>Hello,</p>

            <p>Your IremboAccount has been successfully created.</p>

            <p><strong>Registered Phone:</strong> {$phone}<br>
               <strong>Registered Email:</strong> {$email}</p>

            <p>You can now log in and access services.</p>

            <p>If you did not create this account, please contact support immediately.</p>

            <p>Thank you,<br>
            Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "
        <script>
            swal({
                title: 'Account Created!',
                text: 'Your account was created successfully. A confirmation email has been sent.',
                icon: 'success',
                button: 'OK'
            }).then(() => {
                window.location.href='login.php';
            });
        </script>
        ";

    } catch (Exception $e) {

        echo "
        <script>
            swal({
                title: 'Account Created!',
                text: 'Account created but confirmation email failed to send.',
                icon: 'warning',
                button: 'OK'
            }).then(() => {
                window.location.href='login.php';
            });
        </script>
        ";
    }
}
?>