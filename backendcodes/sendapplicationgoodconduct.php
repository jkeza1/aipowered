<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applygoodconduct'])){

    include 'connection.php';

    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);

    // 🔎 Check if citizen exists
    $citizen_check = mysqli_query($conn, "SELECT * FROM citizensregistry WHERE national_id='$national_id' LIMIT 1");
    if(mysqli_num_rows($citizen_check) == 0){
        echo "<script>
        swal({
            title: 'Citizen Not Found!',
            text: 'The provided National ID is not registered in the system.',
            icon: 'error',
            button: 'OK'
        });
        </script>";
    }

    // 🔎 Check existing pending Good Conduct application
    $check = mysqli_query($conn, "SELECT id FROM applicationgoodconduct 
                                  WHERE national_id='$national_id' 
                                  AND status='Pending'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>
        swal({
            title: 'Application Exists!',
            text: 'You already have a pending Good Conduct application.',
            icon: 'warning',
            button: 'OK'
        });
        </script>";
    } 

    // -----------------------------
    // Proceed to submit application
    // -----------------------------
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $service_name = $_POST['service_name'];
    $processing_days = (int)$_POST['processing_time'];
    $price = $_POST['price'];

    // Handle file upload
    $uploadDir = "adminsection/goodconduct/";
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = time().'_'.$_FILES['attachment']['name'];
    $filePath = $uploadDir.$fileName;
    move_uploaded_file($_FILES['attachment']['tmp_name'], $filePath);

    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    mysqli_query($conn, "INSERT INTO applicationgoodconduct
        (full_name, email, phone, national_id, service_name, processing_time,
         price, application_date, expected_feedback_date, attachment)
        VALUES
        ('$full_name','$email','$phone','$national_id','$service_name',
         '$processing_days','$price','$application_date',
         '$expected_feedback_date','$fileName')");

    // -----------------------------
    // Email Notification to Citizen
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
        $mail->Subject = "Irembo AI-POWERED: Good Conduct Application Submitted";

        $mail->Body = "
            <p>Dear {$full_name},</p>
            <p>Your <strong>Good Conduct</strong> application has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            Service: {$service_name}<br>
            Price: {$price}<br>
            Processing Time: {$processing_days} day(s)</p>

            <p><strong>Expected Feedback Date:</strong> {$expected_feedback_date}</p>

            <p>Please keep your phone/email accessible for further notifications.</p>

            <p>If you did not submit this request, contact support immediately.</p>

            <p>Thank you,<br>Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
        swal({
            title: 'Success!',
            text: 'Good Conduct application submitted successfully! A confirmation email has been sent.',
            icon: 'success',
            button: 'OK'
        }).then(()=>{window.location.href='';});
        </script>";

    } catch (Exception $e) {
        echo "<script>
        swal({
            title: 'Success!',
            text: 'Application submitted successfully! But email notification failed.',
            icon: 'warning',
            button: 'OK'
        }).then(()=>{window.location.href='';});
        </script>";
    }
}
?>