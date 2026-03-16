<?php
// backendcodes/sendapplicationcelibacy.php
include 'sessionstart.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $birth_district = mysqli_real_escape_string($conn, $_POST['birth_district']);
    $service_name = "Certificate of Being Single (Celibacy)";
    
    $upload_dir = '../adminsection/celibacy/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $file_name = time() . '_' . $national_id . '.' . $file_ext;
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
        // AI Forensic Integration for Celibacy
        $ai_url = 'http://127.0.0.1:8000/verify_celibacy';
        $post_data = [
            'file' => new CURLFile(realpath($target_file)),
            'national_id' => $national_id,
            'birth_district' => $birth_district
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ai_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $ai_result = json_decode($response, true);
        $forgery_score = $ai_result['forgery_score'] ?? 0.05;
        $verdict = ($forgery_score > 0.5) ? 'High Risk' : 'Authentic';

        $sql = "INSERT INTO applicationcelibacy (full_name, national_id, birth_district, document_path, service_name, ai_forgery_score, ai_verdict) 
                VALUES ('$full_name', '$national_id', '$birth_district', '$target_file', '$service_name', '$forgery_score', '$verdict')";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../userdashboard.php?msg=Status verification in progress.");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}
?>
