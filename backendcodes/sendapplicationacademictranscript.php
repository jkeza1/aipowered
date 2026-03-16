<?php
include 'sessionstart.php';
if(isset($_POST['applyacademictranscript'])){
    include 'connection.php';
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);
    $grad_year = (int)$_POST['grad_year'];
    $service_name = $_POST['service_name'];
    $email = $_SESSION['email'] ?? '';
    $phone = $_SESSION['phone'] ?? '';
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+10 days"));

    // 1. Check Citizen
    $citizen_check = mysqli_query($conn, "SELECT id FROM citizensregistry WHERE national_id='$national_id' LIMIT 1");
    if(mysqli_num_rows($citizen_check) == 0){
        echo "<script>swal('Not Registered', 'Citizen not found in NIDA registry.', 'error');</script>";
        return;
    }

    // 2. Handle Upload
    $uploadDir = "adminsection/academictranscript/";
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $ext = strtolower(pathinfo($_FILES['transcript_doc']['name'], PATHINFO_EXTENSION));
    $fileName = time().'_transcript.'.$ext;
    $filePath = $uploadDir.$fileName;
    move_uploaded_file($_FILES['transcript_doc']['tmp_name'], $filePath);

    // 3. AI Scan (Placeholder call to FastAPI)
    $ai_verdict = 'Pending AI Scan';
    $ai_prob = 0.0;

    $q = "INSERT INTO applicationacademictranscript (full_name, national_id, email, phone, service_name, attachment, status, ai_verdict, ai_forgery_score, school_name, grad_year, application_date, expected_feedback_date)
          VALUES ('$full_name', '$national_id', '$email', '$phone', '$service_name', '$filePath', 'Pending', '$ai_verdict', '$ai_prob', '$school_name', '$grad_year', '$application_date', '$expected_feedback_date')";

    if(mysqli_query($conn, $q)){
        echo "<script>swal('Applied', 'Transcript submitted for AI equivalence verification.', 'success').then(() => { window.location.href='userdashboard.php'; });</script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>swal('Error', 'Submission failed: $error', 'error');</script>";
    }
}
?>