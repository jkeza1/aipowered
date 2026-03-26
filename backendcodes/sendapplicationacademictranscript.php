<?php
include 'sessionstart.php';

if (isset($_POST['applyacademictranscript'])) {

    include 'connection.php';

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);
    $grad_year = (int)$_POST['grad_year'];
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $email = $_SESSION['email'] ?? '';
    $phone = $_SESSION['phone'] ?? '';
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+10 days"));

    // 1. Check Citizen
    $citizen_check = mysqli_query($conn, "SELECT id FROM citizensregistry WHERE national_id='$national_id' LIMIT 1");

    if (mysqli_num_rows($citizen_check) == 0) {
        echo "<script>swal('Not Registered', 'Citizen not found in NIDA registry.', 'error');</script>";
        exit();
    }

    // 2. FILE UPLOAD FIX
    if (!isset($_FILES['transcript_doc']) || $_FILES['transcript_doc']['error'] !== 0) {
        die("File upload error: " . $_FILES['transcript_doc']['error']);
    }

    // Absolute path (server)
    $uploadDir = __DIR__ . "/../adminsection/academictranscript/";

    // Create folder if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Check if writable
    if (!is_writable($uploadDir)) {
        die("Upload folder is not writable.");
    }

    // File extension
    $ext = strtolower(pathinfo($_FILES['transcript_doc']['name'], PATHINFO_EXTENSION));

    if (empty($ext)) {
        die("Invalid file type.");
    }

    // Unique filename
    $fileName = time() . '_transcript.' . $ext;

    // Full path (used to move file)
    $filePath = $uploadDir . $fileName;

    // Path saved in DB (relative)
    $dbPath =  $fileName;

    // Move file
    if (!move_uploaded_file($_FILES['transcript_doc']['tmp_name'], $filePath)) {
        die("Failed to upload file.");
    }

    // 3. AI Scan (placeholder)
    $ai_verdict = 'Pending AI Scan';
    $ai_prob = 0.0;

    // 4. Insert into DB
    $q = "INSERT INTO applicationacademictranscript 
        (full_name, national_id, email, phone, service_name, attachment, status, ai_verdict, ai_forgery_score, school_name, grad_year, application_date, expected_feedback_date)
        VALUES 
        ('$full_name', '$national_id', '$email', '$phone', '$service_name', '$dbPath', 'Pending', '$ai_verdict', '$ai_prob', '$school_name', '$grad_year', '$application_date', '$expected_feedback_date')";

    if (mysqli_query($conn, $q)) {
        echo "<script>
            swal('Applied', 'Transcript submitted for AI equivalence verification.', 'success')
            .then(() => { window.location.href='userdashboard.php'; });
        </script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>swal('Error', 'Submission failed: $error', 'error');</script>";
    }
}
?>