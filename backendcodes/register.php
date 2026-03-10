<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['register'])){

    include 'connection.php';

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Basic validation
    if(empty($phone) || empty($email)){
        echo "<script>
        swal('Missing Information','Phone and Email are required.','warning');
        </script>";
        return;
    }

    if($password !== $confirm_password){
        echo "<script>
        swal('Password Error','Passwords do not match.','error');
        </script>";
        return;
    }

    // Check duplicate
    // We check for existing Phone, Email, or National ID.
    // If a value is empty or NULL in the DB, it won't match our new registration.
    $check_query = "SELECT id, full_name, email, phone, national_id FROM users 
                    WHERE (phone='$phone' AND phone != '') 
                    OR (email='$email' AND email != '') 
                    OR (national_id='$national_id' AND national_id != '')";
    $check = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($check) > 0){
        $existing = mysqli_fetch_assoc($check);
        $found_msg = "Match found for: ";
        if ($phone != '' && $existing['phone'] == $phone) $found_msg .= "Phone ($phone) ";
        if ($email != '' && $existing['email'] == $email) $found_msg .= "Email ($email) ";
        if ($national_id != '' && $existing['national_id'] == $national_id) $found_msg .= "National ID ($national_id) ";

        echo "<script>
        swal('Account Exists',
             '$found_msg',
             'warning');
        </script>";
        return;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $sql = "INSERT INTO users (full_name,dob,national_id,phone,email,password,account_type,status)
            VALUES ('$full_name','$dob','$national_id','$phone','$email','$hashed_password','Both','Active')";
    
    if(mysqli_query($conn, $sql)){

        // ---------------------------------------------------------
        // 🔄 SYNC TO CITIZENS REGISTRY (Registry for Admin/AI)
        // ---------------------------------------------------------
        // Splitting full_name for citizensregistry if needed
        $names = explode(' ', $full_name, 2);
        $first_name = $names[0];
        $last_name = $names[1] ?? '';

        $registry_sql = "INSERT INTO citizensregistry (first_name, last_name, gender, national_id, phone, email, date_of_birth)
                         VALUES ('$first_name', '$last_name', '$gender', '$national_id', '$phone', '$email', '$dob')
                         ON DUPLICATE KEY UPDATE first_name='$first_name', last_name='$last_name', gender='$gender', date_of_birth='$dob'";
        mysqli_query($conn, $registry_sql);

    /* =====================================
       📧 SEND CONFIRMATION EMAIL
    ===================================== */

    // Since this file is included by signup.php in the parent directory,
    // the paths should be relative to signup.php OR use absolute paths.
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

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->isHTML(true);
            $mail->setFrom('kezjoana7@gmail.com', 'Irembo AI-POWERED');
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
    } else {
        $error = mysqli_error($conn);
        echo "
        <script>
            swal('Database Error', 'Could not register: $error', 'error');
        </script>
        ";
    }
}
?>