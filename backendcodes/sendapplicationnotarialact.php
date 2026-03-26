<?php
// backendcodes/sendapplicationnotarialact.php

include 'sessionstart.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['attachment'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $act_type = mysqli_real_escape_string($conn, $_POST['act_type']);
    $service_name = "Notarial Act Authentication";

    $email = $_SESSION['email'] ?? mysqli_real_escape_string($conn, $_POST['email']);
    $phone = $_SESSION['phone'] ?? mysqli_real_escape_string($conn, $_POST['phone']);

    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+3 days"));

    // ✅ FIXED PATH (NO SPACE + ABSOLUTE PATH)
    $upload_dir = __DIR__ . '/../adminsection/notarialact/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!is_writable($upload_dir)) {
        die("Upload folder is not writable.");
    }

    // ✅ CHECK FILE ERROR
    if ($_FILES['attachment']['error'] !== 0) {
        die("Upload error: " . $_FILES['attachment']['error']);
    }

    // File extension
    $file_ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

    if (empty($file_ext)) {
        die("Invalid file type.");
    }

    // Unique filename
    $file_name = time() . '_' . $national_id . '.' . $file_ext;

    // FULL PATH (for moving file)
    $target_file = $upload_dir . $file_name;

    // PATH FOR DATABASE
    $db_path = $file_name;

    // ✅ MOVE FILE (FIXED)
    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)) {

        // AI Forensic API Call
        $ai_url = 'http://127.0.0.1:8000/verify_notary';

        $post_data = [
            'file' => new CURLFile(realpath($target_file)),
            'national_id' => $national_id,
            'act_type' => $act_type
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ai_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $ai_result = json_decode($response, true);

        $forgery_score = $ai_result['forgery_score'] ?? 0.01;
        $verdict = ($forgery_score > 0.5) ? 'High Risk' : 'Authentic';

        // ✅ INSERT (USE DB PATH)
        $sql = "INSERT INTO applicationnotarialact 
        (full_name, national_id, email, phone, act_type, attachment, service_name, ai_forgery_score, ai_verdict, application_date, expected_feedback_date) 
        VALUES 
        ('$full_name', '$national_id', '$email', '$phone', '$act_type', '$db_path', '$service_name', '$forgery_score', '$verdict', '$application_date', '$expected_feedback_date')";

        if (mysqli_query($conn, $sql)) {
          echo "<script>
        swal('Registered','Notarial act submitted for AI forensic screening','success');
        </script>";

        } else {
            echo "Database Error: " . mysqli_error($conn);
        }

    } else {
        echo "File upload failed.";
    }
}
?>