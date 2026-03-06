<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applypassportreplacement'])){

    include 'connection.php';

    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);

    // ---------------------------------
    // 1️⃣ CHECK IF CITIZEN EXISTS
    // ---------------------------------
    $citizen_check = mysqli_query($conn, 
        "SELECT id FROM citizensregistry 
         WHERE national_id='$national_id' 
         LIMIT 1");

    if(mysqli_num_rows($citizen_check) == 0){
        echo "<script>
        swal({
            title: 'Not Registered!',
            text: 'Citizen with this National ID not found. Please register first.',
            icon: 'error',
            button: 'OK'
        });
        </script>";
    }

    // ---------------------------------
    // 2️⃣ CHECK FOR DUPLICATE PENDING APPLICATION
    // ---------------------------------
    $check = mysqli_query($conn, 
        "SELECT id FROM applicationpassportreplacement 
         WHERE national_id='$national_id' 
         AND status='Pending'");

    if(mysqli_num_rows($check) > 0){

        echo "<script>
        swal({
            title: 'Application Exists!',
            text: 'You already have a pending passport replacement application.',
            icon: 'warning',
            button: 'OK'
        });
        </script>";
    }

    // ---------------------------------
    // 3️⃣ SANITIZE INPUTS
    // ---------------------------------
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $passport_number = mysqli_real_escape_string($conn, $_POST['passport_number']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    $service_name = $_POST['service_name'];
    $processing_days = (int)$_POST['processing_time'];
    $fee = $_POST['fee'];
    $provided_by = $_POST['provided_by'];

    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    // ---------------------------------
    // 4️⃣ INSERT APPLICATION
    // ---------------------------------
    mysqli_query($conn, "INSERT INTO applicationpassportreplacement
        (full_name, email, phone, national_id, passport_number, reason,
         service_name, processing_days, fee, provided_by,
         application_date, expected_feedback_date, status)
        VALUES
        ('$full_name','$email','$phone','$national_id','$passport_number','$reason',
         '$service_name','$processing_days','$fee','$provided_by',
         '$application_date','$expected_feedback_date','Pending')");

    // ---------------------------------
    // 5️⃣ SEND CONFIRMATION EMAIL
    // ---------------------------------
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

        $mail->setFrom('mytourdraft@gmail.com', 'Irembo AI-POWERED');
        $mail->addAddress($email, $full_name);

        $mail->isHTML(true);
        $mail->Subject = "Irembo AI-POWERED: Passport Replacement Application Submitted";

        $mail->Body = "
            <p>Dear <strong>{$full_name}</strong>,</p>

            <p>Your <strong>passport replacement application</strong> has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            Passport Number: {$passport_number}<br>
            Reason: {$reason}<br>
            Service: {$service_name}<br>
            Fee: {$fee}<br>
            Processing Time: {$processing_days} day(s)<br>
            Expected Feedback Date: {$expected_feedback_date}
            </p>

            <p>Please keep your phone and email accessible for further updates.</p>

            <p>If you did not submit this request, contact support immediately.</p>

            <p>Thank you,<br>
            Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
        swal({
            title: 'Success!',
            text: 'Application submitted successfully! Confirmation email sent.',
            icon: 'success',
            button: 'OK'
        }).then(() => {
            window.location.href = '';
        });
        </script>";

    } catch (Exception $e) {

        echo "<script>
        swal({
            title: 'Success!',
            text: 'Application submitted but email notification failed.',
            icon: 'warning',
            button: 'OK'
        }).then(() => {
            window.location.href = '';
        });
        </script>";
    }
}
?>