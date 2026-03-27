<?php
include 'sessionstart.php';
include 'connection.php';

if (isset($_POST['applybankstatement'])) {

  

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
    $account_number = mysqli_real_escape_string($conn, $_POST['account_number']);
    $service_name = $_POST['service_name'];

    $email = $_SESSION['email'] ?? '';
    $phone = $_SESSION['phone'] ?? '';

    $processing_days = 7;
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+$processing_days days"));

    // 1. Check Citizen
    $citizen_check = mysqli_query($conn, "SELECT id FROM citizensregistry WHERE national_id='$national_id' LIMIT 1");

    if (mysqli_num_rows($citizen_check) == 0) {
        echo "<script>swal('Not Registered', 'Citizen not found in NIDA registry.', 'error');</script>";
        exit;
    }

    // 2. Validate file upload
    if (!isset($_FILES['bank_doc']) || $_FILES['bank_doc']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>swal('Upload Error', 'No file uploaded or upload failed.', 'error');</script>";
        exit;
    }

    if (empty($_FILES['bank_doc']['name'])) {
        echo "<script>swal('Upload Error', 'Please select a file.', 'error');</script>";
        exit;
    }

    // 3. Upload directory (absolute path)
    $uploadDir = __DIR__ . "/adminsection/bankstatement/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // 4. File handling
    $ext = strtolower(pathinfo($_FILES['bank_doc']['name'], PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'pdf'];

    if (!in_array($ext, $allowedExt)) {
        echo "<script>swal('Invalid File', 'Only JPG, PNG, and PDF files are allowed.', 'error');</script>";
        exit;
    }

    $fileName = time() . '_bank.' . $ext;
    $filePath = $uploadDir . $fileName;

    // 5. Move uploaded file
    if (!move_uploaded_file($_FILES['bank_doc']['tmp_name'], $filePath)) {
        echo "<script>swal('Upload Failed', 'Could not move uploaded file.', 'error');</script>";
        exit;
    }

    // 6. AI placeholders
    $ai_verdict = 'Pending AI Scan';
    $ai_prob = 0.0;

    // 7. Insert into database
    $q = "INSERT INTO applicationbankstatement 
    (full_name, national_id, email, phone, bank_name, account_number, attachment, service_name, status, ai_verdict, ai_forgery_score, application_date, expected_feedback_date)
    VALUES 
    ('$full_name', '$national_id', '$email', '$phone', '$bank_name', '$account_number', '$fileName', '$service_name', 'Pending', '$ai_verdict', '$ai_prob', '$application_date', '$expected_feedback_date')";

    if (mysqli_query($conn, $q)) {
        echo "<script>
            swal('Applied', 'Bank statement submitted successfully.', 'success')
            .then(() => { window.location.href='userdashboard.php'; });
        </script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>swal('Error', 'Submission failed: $error', 'error');</script>";
    }
}
?>