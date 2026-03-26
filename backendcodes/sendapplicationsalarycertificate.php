<?php
include 'sessionstart.php';

if(isset($_POST['full_name'])){

    include 'connection.php';

    // 1. Sanitize Inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $employer_name = mysqli_real_escape_string($conn, $_POST['employer']); // Matches modal 'employer'
    $monthly_net = (int)$_POST['salary']; // Matches modal 'salary'

    $service_name = $_POST['service_name'] ?? 'Salary Certificate Verification';
    $email = $_SESSION['email'] ?? '';
    $phone = $_SESSION['phone'] ?? '';
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+7 days"));

    // 2. Prevent Multiple Pendings
    $check = mysqli_query($conn, "SELECT id FROM applicationsalarycertificate WHERE national_id='$national_id' AND status='Pending'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Pending Application: You have an existing request.'); window.history.back();</script>";
        exit();
    }

    // 3. Handle File Upload
    $uploadDir = "../adminsection/salaryslip/"; // Path from backendcodes/
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION)); // Matches modal 'document'
    $allowed = ['jpg','jpeg','png','pdf'];
    
    if(!in_array($ext, $allowed)){
        echo "<script>alert('Invalid File: Only JPG/PNG/PDF are allowed.'); window.history.back();</script>";
        exit();
    }

    $fileName = time().'_salary.'.$ext;
    $filePath = $fileName; // Store relative path for DB
    $destination = $uploadDir.$fileName;

    if(!move_uploaded_file($_FILES['document']['tmp_name'], $destination)){
        echo "<script>alert('Upload failed.'); window.history.back();</script>";
        exit();
    }

    // 4. AI Logic (Simplified for this file)
    $ai_verdict = 'Pending AI Scan';
    $ai_score = 0.0;

    // 5. Finalize Database Save
    $q = "INSERT INTO applicationsalarycertificate (full_name, national_id, email, phone, employer_name, monthly_net, attachment, service_name, ai_verdict, ai_forgery_score, application_date, expected_feedback_date)
          VALUES ('$full_name', '$national_id', '$email', '$phone', '$employer_name', '$monthly_net', '$filePath', '$service_name', '$ai_verdict', '$ai_score', '$application_date', '$expected_feedback_date')";

    if(mysqli_query($conn, $q)){
        echo "<script>
            alert('Application submitted successfully!');
            window.location.href='../userdashboard.php';
        </script>";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>