<?php
if(isset($_POST['applydrivinglicense'])){

    include 'connection.php';

    // Sanitize input
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);

    $service_name = $_POST['service_name'];
    $processing_days = (int)$_POST['processing_time'];
    $price = $_POST['price'];
    $currency = $_POST['currency'];

    // 🔎 Check existing pending application
    $check = mysqli_query($conn, 
        "SELECT id FROM applicationdrivinglicense 
         WHERE national_id='$national_id' 
         AND status='Pending'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>
        swal('Application Already Exists!',
             'You already have a pending application. Please wait for feedback.',
             'warning');
        </script>";
        exit; // STOP execution if pending exists
    }

    // =============================
    // Insert Application
    // =============================
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    mysqli_query($conn, "INSERT INTO applicationdrivinglicense
        (full_name, email, phone, national_id, service_name,
         processing_time, price, currency,
         application_date, expected_feedback_date)
        VALUES
        ('$full_name','$email','$phone','$national_id','$service_name',
         '$processing_days','$price','$currency',
         '$application_date','$expected_feedback_date')");

    /* =====================================
       📧 SEND EMAIL NOTIFICATION
    ===================================== */

    require 'backendcodes/PHPMailer/src/PHPMailer.php';
    require 'backendcodes/PHPMailer/src/SMTP.php';
    require 'backendcodes/PHPMailer/src/Exception.php';

    try {

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kezjoana7@gmail.com';
        $mail->Password   = 'xddr fkbk swkt nikk'; 
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->isHTML(true);
        $mail->setFrom('mytourdraft@gmail.com', 'Irembo AI-POWERED');

        $mail->addAddress($email);

        $mail->Subject = "Irembo AI-POWERED: Driving License Application Received";

        // Removed undefined $citizen variable
        $mail->Body = "
            <p>Dear {$full_name},</p>

            <p>Your <strong>Definitive Driving License</strong> application has been successfully received.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            Service: {$service_name}<br>
            Price: {$price} {$currency}<br>
            Processing Time: {$processing_days} day(s)</p>

            <p><strong>Expected Feedback Date:</strong> {$expected_feedback_date}</p>

            <p>You will receive another notification once your license is approved.</p>

            <p>If you did not submit this request, please contact support immediately.</p>

            <p>Thank you,<br>
            Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
        swal({
          title: 'Success!',
          text: 'Application submitted successfully! A confirmation email has been sent.',
          icon: 'success',
          button: 'OK'
        }).then(() => {
          window.location.href = '';
        });
        </script>";

    } catch (Exception $e) {

        echo "<script>
        swal({
          title: 'Application Submitted!',
          text: 'Application saved but email notification failed.',
          icon: 'warning',
          button: 'OK'
        }).then(() => {
          window.location.href = '';
        });
        </script>";
    }
}
?>