<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applymarriagecertificate'])) {

    include 'connection.php';

    // -----------------------------
    // Sanitize and trim input
    // -----------------------------
    $husband_full_name   = mysqli_real_escape_string($conn, trim($_POST['husband_full_name']));
    $wife_full_name      = mysqli_real_escape_string($conn, trim($_POST['wife_full_name']));
    $husband_national_id = mysqli_real_escape_string($conn, trim($_POST['husband_national_id']));
    $wife_national_id    = mysqli_real_escape_string($conn, trim($_POST['wife_national_id']));
    $applicant_email     = mysqli_real_escape_string($conn, trim($_POST['applicant_email']));
    $applicant_phone     = mysqli_real_escape_string($conn, trim($_POST['applicant_phone']));
    $service_name        = mysqli_real_escape_string($conn, trim($_POST['service_name']));
    $processing_days     = (int)$_POST['processing_time'];
    $price               = mysqli_real_escape_string($conn, trim($_POST['price']));
    $currency            = mysqli_real_escape_string($conn, trim($_POST['currency']));

    // -----------------------------
    // Check for existing pending application
    // -----------------------------
    $check = mysqli_query($conn, "SELECT id FROM applicationmarriagecertificate 
                                  WHERE husband_national_id='$husband_national_id'
                                  AND wife_national_id='$wife_national_id'
                                  AND status='Pending'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>swal('Application Exists','A marriage certificate application is already pending for these citizens.','warning');</script>";
    
    }

    // -----------------------------
    // Insert application
    // -----------------------------
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    $insert_query = "INSERT INTO applicationmarriagecertificate
        (husband_full_name, wife_full_name, applicant_email, applicant_phone,
         husband_national_id, wife_national_id,
         service_name, processing_time, price, currency,
         application_date, expected_feedback_date)
        VALUES
        ('$husband_full_name','$wife_full_name','$applicant_email','$applicant_phone',
         '$husband_national_id','$wife_national_id',
         '$service_name','$processing_days','$price','$currency',
         '$application_date','$expected_feedback_date')";

    if(!mysqli_query($conn, $insert_query)){
        echo "<script>swal('Error','Database insertion failed: ".mysqli_error($conn)."','error');</script>";
  
    }

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
        $mail->Username   = 'kezjoana7@gmail.com'; // your SMTP email
        $mail->Password   = 'xddr fkbk swkt nikk'; // app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->isHTML(true);
        $mail->setFrom('kezjoana7@gmail.com', 'Irembo AI-POWERED');

        $mail->addAddress($applicant_email);
        $mail->Subject = "Irembo AI-POWERED: Marriage Certificate Application Submitted";

        $mail->Body = "
            <p>Dear Applicant,</p>
            <p>Your <strong>Marriage Certificate</strong> application has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            Husband: {$husband_full_name} ({$husband_national_id})<br>
            Wife: {$wife_full_name} ({$wife_national_id})<br>
            Service: {$service_name}<br>
            Price: {$price} {$currency}<br>
            Processing Time: {$processing_days} day(s)</p>

            <p><strong>Expected Feedback Date:</strong> {$expected_feedback_date}</p>

            <p>Please keep your phone/email accessible for further notifications.</p>

            <p>If you did not submit this request, contact support immediately.</p>

            <p>Thank you,<br>Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
            swal('Success','Marriage certificate application submitted successfully! A confirmation email has been sent.','success')
            .then(()=>{window.location.href='';});
        </script>";

    } catch (Exception $e) {
        echo "<script>
            swal('Success','Application submitted successfully! But email notification failed.','warning')
            .then(()=>{window.location.href='';});
        </script>";
    }
}
?>