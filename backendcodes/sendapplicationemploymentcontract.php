<?php
// backendcodes/sendapplicationcontract.php
include 'sessionstart.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $employer_id = mysqli_real_escape_string($conn, $_POST['employer_id']);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $service_name = "Employment Contract Certification";
    $email = $_SESSION['email'] ?? '';
    $phone = $_SESSION['phone'] ?? '';
    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+7 days"));
    
    $upload_dir = '../adminsection/contract/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $file_name = time() . '_' . $national_id . '.' . $file_ext;
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
        // AI Forensic API Call for Contract Verification
        $ai_url = 'http://127.0.0.1:8000/verify_contract';
        $post_data = [
            'file' => new CURLFile(realpath($target_file)),
            'national_id' => $national_id,
            'employer_id' => $employer_id
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ai_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $ai_result = json_decode($response, true);
        $forgery_score = $ai_result['forgery_score'] ?? 0.0;
        $verdict = ($forgery_score > 0.5) ? 'High Risk' : 'Authentic';

        $sql = "INSERT INTO applicationemploymentcontract (full_name, national_id, email, phone, employer_id, job_title, attachment, service_name, ai_forgery_score, ai_verdict, application_date, expected_feedback_date) 
                VALUES ('$full_name', '$national_id', '$email', '$phone', '$employer_id', '$job_title', '$target_file', '$service_name', '$forgery_score', '$verdict', '$application_date', '$expected_feedback_date')";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../userdashboard.php?msg=Contract submitted for verification.");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}
?>
