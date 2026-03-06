<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['applydrivingreplacement'])){

    include 'connection.php';

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $license_number = mysqli_real_escape_string($conn, $_POST['license_number']);

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
    // 2️⃣ CHECK DUPLICATE PENDING APPLICATION
    // ---------------------------------
    $check = mysqli_query($conn, 
        "SELECT id FROM applicationdrivingreplacement 
         WHERE national_id='$national_id' 
         AND status='Pending'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>
        swal('Application Exists',
             'You already have a pending Driving License replacement application.',
             'warning');
        </script>";
        exit();
    }

    // ---------------------------------
    // 3️⃣ FILE UPLOAD
    // ---------------------------------
    $uploadDir = "adminsection/drivingreplacement/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0777, true);
    }

    $allowed = ['jpg','jpeg','png','pdf'];

    // Old License Image
    $oldExt = strtolower(pathinfo($_FILES['old_license_image']['name'], PATHINFO_EXTENSION));
    if(!in_array($oldExt, $allowed)){
        die("Invalid file type for old license.");
    }

    if($_FILES['old_license_image']['size'] > 5*1024*1024){
        die("Old license file too large. Max 5MB.");
    }

    $oldFileName = time().'_license.'.$oldExt;
    move_uploaded_file($_FILES['old_license_image']['tmp_name'], $uploadDir.$oldFileName);

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
    mysqli_query($conn, "INSERT INTO applicationdrivingreplacement
        (full_name,email,phone,national_id,license_number,
         service_name,processing_time,price,currency,
         old_license_image,police_document,
         application_date,expected_feedback_date,status)
        VALUES
        ('$full_name','$email','$phone','$national_id','$license_number',
         '$service_name','$processing_days','$price','$currency',
         '$oldFileName','$policeFileName',
         '$application_date','$expected_feedback_date','Pending')");

    // ---------------------------------
    // 5️⃣ EMAIL NOTIFICATION
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
        $mail->setFrom('mytourdraft@gmail.com', 'Irembo AI-POWERED');

        $mail->addAddress($email);
        $mail->Subject = "Irembo AI-POWERED: Driving License Replacement Application";

        $mail->Body = "
            <p>Dear {$full_name},</p>
            <p>Your <strong>Driving License Replacement</strong> application has been successfully submitted.</p>

            <p><strong>Application Details:</strong><br>
            National ID: {$national_id}<br>
            License Number: {$license_number}<br>
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
        swal('Success',
             'Driving License replacement application submitted successfully! A confirmation email has been sent.',
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