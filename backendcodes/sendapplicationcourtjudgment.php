<?php
include 'sessionstart.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {

    // ✅ DEBUG: check if file is received
    if ($_FILES['document']['error'] !== UPLOAD_ERR_OK) {
        echo "Upload error code: " . $_FILES['document']['error'];
        exit();
    }

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $case_number = mysqli_real_escape_string($conn, $_POST['case_number']);
    $ruling_year = mysqli_real_escape_string($conn, $_POST['ruling_year']);

    $service_name = "Copy of Court Judgment";

    $email = $_SESSION['email'] ?? '';
    $phone = $_SESSION['phone'] ?? '';

    $application_date = date("Y-m-d H:i:s");
    $expected_feedback_date = date("Y-m-d H:i:s", strtotime("+15 days"));

    // ✅ FIXED ABSOLUTE PATH (IMPORTANT)
    $upload_dir = __DIR__ . '/../adminsection/courtjudgment/';

    // Create folder if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // File name
    $file_ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $file_name = time() . '_' . $national_id . '.' . $file_ext;

    // Full path to save file
    $target_path = $upload_dir . $file_name;

    // Move file
    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_path)) {

        // Store ONLY filename in DB
        $db_file_name = $file_name;

        // AI integration
        $ai_url = 'http://127.0.0.1:8000/verify_court_judgment';

        $post_data = [
            'file' => new CURLFile($target_path),
            'national_id' => $national_id,
            'case_number' => $case_number
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

        // Insert into DB
        $sql = "INSERT INTO applicationcourtjudgment 
        (full_name, national_id, email, phone, case_number, ruling_year, attachment, service_name, ai_forgery_score, ai_verdict, application_date, expected_feedback_date)
        VALUES 
        ('$full_name', '$national_id', '$email', '$phone', '$case_number', '$ruling_year', '$db_file_name', '$service_name', '$forgery_score', '$verdict', '$application_date', '$expected_feedback_date')";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../userdashboard.php?msg=Application submitted successfully");
            exit();
        } else {
            echo "Database error: " . mysqli_error($conn);
        }

    } else {
        echo "❌ File upload failed. Check folder permissions or path.";
    }
}
?>