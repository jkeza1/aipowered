<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applyprovisionallicense'])){

    include 'connection.php';

    // -----------------------------
    // Sanitize Inputs
    // -----------------------------
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);

    $service_name = $_POST['service_name'];
    $processing_days = (int)$_POST['processing_time'];
    $price = $_POST['price'];
    $currency = $_POST['currency'];

    // ---------------------------------
    // 1️⃣ CHECK IF CITIZEN EXISTS
    // ---------------------------------
    $citizen_check = mysqli_query($conn,
        "SELECT id FROM citizensregistry 
         WHERE national_id='$national_id' 
         LIMIT 1");

    if(mysqli_num_rows($citizen_check) == 0){

        echo "
        <script>
        swal({
          title: 'Not Registered!',
          text: 'Citizen with this National ID not found. Please register first.',
          icon: 'error',
          button: 'OK'
        });
        </script>
        ";
    }

    // ---------------------------------
    // 2️⃣ CHECK DUPLICATE PENDING APPLICATION
    // ---------------------------------
    $check = mysqli_query($conn,
        "SELECT id FROM applicationprovisionallicense 
         WHERE national_id='$national_id' 
         AND status='Pending'");

    if(mysqli_num_rows($check) > 0){

        echo "
        <script>
        swal({
          title: 'Application Already Exists!',
          text: 'You already have a provisional application being processed.',
          icon: 'warning',
          button: 'OK'
        });
        </script>
        ";
    }

    // ---------------------------------
    // 3️⃣ INSERT APPLICATION
    // ---------------------------------
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    mysqli_query($conn, "INSERT INTO applicationprovisionallicense
        (full_name, email, phone, national_id, service_name, 
         processing_time, price, currency, 
         application_date, expected_feedback_date, status)
        VALUES
        ('$full_name','$email','$phone','$national_id','$service_name',
         '$processing_days','$price','$currency',
         '$application_date','$expected_feedback_date','Pending')");

    // ---------------------------------
    // 4️⃣ SEND CONFIRMATION EMAIL
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
        $mail->Subject = "Irembo AI-POWERED: Provisional License Application Submitted";

        $mail->Body = "
            <p>Dear <strong>{$full_name}</strong>,</p>

            <p>Your <strong>Provisional Driving License Application</strong> has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            Service: {$service_name}<br>
            Amount Paid: {$price} {$currency}<br>
            Processing Time: {$processing_days} day(s)<br>
            Expected Feedback Date: {$expected_feedback_date}
            </p>

            <p>Please keep your phone and email accessible for updates.</p>

            <p>If you did not submit this request, contact support immediately.</p>

            <p>Thank you,<br>
            Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "
        <script>
        swal({
          title: 'Success!',
          text: 'Application submitted successfully! Confirmation email sent.',
          icon: 'success',
          button: 'OK'
        }).then(() => {
          window.location.href = '';
        });
        </script>
        ";

    } catch (Exception $e) {

        echo "
        <script>
        swal({
          title: 'Success!',
          text: 'Application submitted but email notification failed.',
          icon: 'warning',
          button: 'OK'
        }).then(() => {
          window.location.href = '';
        });
        </script>
        ";
    }
}
?>