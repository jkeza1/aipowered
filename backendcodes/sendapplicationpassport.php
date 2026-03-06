<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applypassport'])){

    include 'connection.php';

    // Sanitize inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);

    $service_name = $_POST['service_name'];
    $request_type = $_POST['request_type'];
    $processing_days = (int)$_POST['processing_time'];
    $fee = $_POST['fee'];

    // -----------------------------
    // Check if citizen exists
    // -----------------------------
    $citizen_res = mysqli_query($conn, "SELECT id FROM citizensregistry WHERE national_id='$national_id' LIMIT 1");
    if(mysqli_num_rows($citizen_res) == 0){
        echo "<script>
        swal('Not Registered','Citizen with this National ID not found. Please register first.','error');
        </script>";
    }

    // -----------------------------
    // Check for existing pending passport application
    // -----------------------------
    $check = mysqli_query($conn, "SELECT id FROM applicationpassport 
                                  WHERE national_id='$national_id' 
                                  AND status='Pending'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>
        swal({
          title: 'Application Already Exists!',
          text: 'You already have a passport application being processed.',
          icon: 'warning',
          button: 'OK'
        });
        </script>";
    }

    // -----------------------------
    // Insert passport application
    // -----------------------------
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    mysqli_query($conn, "INSERT INTO applicationpassport
        (full_name, email, phone, national_id, service_name, request_type, processing_time, fee, application_date, expected_feedback_date)
        VALUES
        ('$full_name','$email','$phone','$national_id','$service_name','$request_type','$processing_days','$fee','$application_date','$expected_feedback_date')");

    // -----------------------------
    // Send confirmation email
    // -----------------------------
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
        $mail->Subject = "Irembo AI-POWERED: Passport Application Submitted";

        $mail->Body = "
            <p>Dear {$full_name},</p>
            <p>Your <strong>passport application</strong> has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            Service: {$service_name}<br>
            Request Type: {$request_type}<br>
            Fee: {$fee}<br>
            Processing Time: {$processing_days} day(s)<br>
            Expected Feedback Date: {$expected_feedback_date}</p>

            <p>Please keep your email and phone accessible for further notifications.</p>

            <p>If you did not submit this request, contact support immediately.</p>

            <p>Thank you,<br>Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
            swal('Success','Passport application submitted successfully! A confirmation email has been sent.','success')
            .then(()=>{window.location.href='';});
        </script>";

    } catch (Exception $e) {
        echo "<script>
            swal('Success','Passport application submitted successfully! But email notification failed.','warning')
            .then(()=>{window.location.href='';});
        </script>";
    }
}
?>