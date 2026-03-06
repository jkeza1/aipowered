<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applynationalid'])){

    include 'connection.php';

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
        echo "<script>
        swal('Not Registered',
             'Citizen with this National ID not found. Please register first.',
             'error');
        </script>";
          }

    // ---------------------------------
    // 2️⃣ PREVENT DUPLICATE PENDING APPLICATION
    // ---------------------------------
    $check = mysqli_query($conn, 
        "SELECT id FROM applicationnationalid 
         WHERE national_id='$national_id' 
         AND status='Pending'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>
        swal('Application Exists',
             'You already have a pending National ID replacement application.',
             'warning');
        </script>";
    }

    // ---------------------------------
    // 3️⃣ HANDLE FILE UPLOADS
    // ---------------------------------
    $uploadDir = "adminsection/nationalid/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0777, true);
    }

    $allowed = ['jpg','jpeg','png','pdf'];

    // Old ID Image
    $oldExt = strtolower(pathinfo($_FILES['old_id_image']['name'], PATHINFO_EXTENSION));
    if(!in_array($oldExt, $allowed)){
        die("Invalid file type for old ID image.");
    }

    if($_FILES['old_id_image']['size'] > 5*1024*1024){
        die("Old ID image too large. Max 5MB.");
    }

    $oldFileName = time().'_old.'.$oldExt;
    move_uploaded_file($_FILES['old_id_image']['tmp_name'], $uploadDir.$oldFileName);

    // Police Document (Optional)
    $policeFileName = NULL;
    if(!empty($_FILES['police_document']['name'])){

        $polExt = strtolower(pathinfo($_FILES['police_document']['name'], PATHINFO_EXTENSION));

        if(!in_array($polExt, $allowed)){
            die("Invalid file type for police document.");
        }

        if($_FILES['police_document']['size'] > 5*1024*1024){
            die("Police document too large. Max 5MB.");
        }

        $policeFileName = time().'_police.'.$polExt;
        move_uploaded_file($_FILES['police_document']['tmp_name'], $uploadDir.$policeFileName);
    }

    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    // ---------------------------------
    // 4️⃣ INSERT APPLICATION
    // ---------------------------------
    mysqli_query($conn, "INSERT INTO applicationnationalid
        (full_name,email,phone,national_id,service_name,
         processing_time,price,currency,
         old_id_image,police_document,
         application_date,expected_feedback_date,status)
        VALUES
        ('$full_name','$email','$phone','$national_id','$service_name',
         '$processing_days','$price','$currency',
         '$oldFileName','$policeFileName',
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
        $mail->isHTML(true);
        $mail->setFrom('kezjoana7@gmail.com', 'Irembo AI-POWERED');

        $mail->addAddress($email);
        $mail->Subject = "Irembo AI-POWERED: National ID Replacement Application Submitted";

        $mail->Body = "
            <p>Dear {$full_name},</p>
            <p>Your <strong>National ID Replacement</strong> application has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            Service: {$service_name}<br>
            Price: {$price} {$currency}<br>
            Processing Time: {$processing_days} day(s)<br>
            Expected Feedback Date: {$expected_feedback_date}</p>

            <p>Please keep your email and phone accessible for further notifications.</p>

            <p>If you did not submit this request, contact support immediately.</p>

            <p>Thank you,<br>Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
            swal('Success',
                 'National ID replacement application submitted successfully! A confirmation email has been sent.',
                 'success')
            .then(()=>{window.location.href='';});
        </script>";

    } catch (Exception $e) {
        echo "<script>
            swal('Success',
                 'Application submitted successfully! But email notification failed.',
                 'warning')
            .then(()=>{window.location.href='';});
        </script>";
    }
}
?>