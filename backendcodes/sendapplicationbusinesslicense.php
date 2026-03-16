<?php
include 'sessionstart.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $tin_number = mysqli_real_escape_string($conn, $_POST['tin_number']);
    $business_type = mysqli_real_escape_string($conn, $_POST['business_type']);
    $service_name = "Business License Verification";
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+5 days"));
    
    $upload_dir = '../adminsection/business/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $file_name = time() . '_' . $national_id . '.' . $file_ext;
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
        
        $ai_verdict = 'Pending AI Scan';
        $forgery_score = 0.0;

        $sql = "INSERT INTO applicationbusinesslicense (full_name, national_id, email, phone, tin_number, business_type, attachment, service_name, ai_forgery_score, ai_verdict, application_date, expected_feedback_date) 
                VALUES ('$full_name', '$national_id', '$email', '$phone', '$tin_number', '$business_type', '$target_file', '$service_name', '$forgery_score', '$ai_verdict', '$application_date', '$expected_feedback_date')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Application submitted successfully.'); window.location.href='../userdashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}
?>