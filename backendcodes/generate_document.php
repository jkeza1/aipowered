<?php
include 'sessionstart.php';
include 'sessioncheck.php';
include 'connection.php';

// Check if ID and Type are provided
if(!isset($_GET['id']) || !isset($_GET['type'])){
    die("Invalid request.");
}

$app_id = intval($_GET['id']);
$app_type = $_GET['type'];
$user_email = $_SESSION['email'] ?? '';
$user_phone = $_SESSION['phone'] ?? '';

// 1. Fetch the application to ensure it belongs to the user and is APPROVED
$table_map = [
    'Criminal Record' => 'applicationcriminalrecord',
    'Driving License' => 'applicationdrivinglicense',
    'Driving Replacement' => 'applicationdrivingreplacement',
    'Good Conduct' => 'applicationgoodconduct',
    'Marriage Certificate' => 'applicationmarriagecertificate',
    'National ID' => 'applicationnationalid',
    'Passport' => 'applicationpassport',
    'Passport Replacement' => 'applicationpassportreplacement',
    'Provisional License' => 'applicationprovisionallicense'
];

if(!isset($table_map[$app_type])){
    die("Invalid application type.");
}

$table = $table_map[$app_type];

// Verify ownership and approval
if($table === 'applicationmarriagecertificate'){
    $check_q = mysqli_query($conn, "SELECT * FROM $table WHERE id=$app_id AND (applicant_email='$user_email' OR applicant_phone='$user_phone') AND status='Approved'");
} else {
    $check_q = mysqli_query($conn, "SELECT * FROM $table WHERE id=$app_id AND (email='$user_email' OR phone='$user_phone') AND status='Approved'");
}

if(mysqli_num_rows($check_q) == 0){
    die("Application not found or not approved.");
}

$app_data = mysqli_fetch_assoc($check_q);

// 2. Fetch Extra Citizen Info (Date of Birth, Father, Mother) from Registry
$national_id = $app_data['national_id'] ?? '';
$citizen = [];
if($national_id){
    $cit_q = mysqli_query($conn, "SELECT * FROM citizensregistry WHERE national_id='$national_id' LIMIT 1");
    $citizen = mysqli_fetch_assoc($cit_q) ?? [];
}

// 3. Fetch the samples/background images from systeminfo
$sys_q = mysqli_query($conn, "SELECT * FROM systeminfo ORDER BY id ASC LIMIT 1");
$sys_info = mysqli_fetch_assoc($sys_q);

// Map the application type to the field in systeminfo
$sample_field_map = [
    'National ID' => 'nationalid',
    'Driving License' => 'drivinglicense',
    'Driving Replacement' => 'drivinglicense',
    'Passport' => 'passport',
    'Passport Replacement' => 'passport',
    'Marriage Certificate' => 'marriagecertificate',
    'Good Conduct' => 'goodconduct',
    'Provisional License' => 'provisionaldriving',
    'Criminal Record' => 'goodconduct'
];

$sample_file = $sys_info[$sample_field_map[$app_type]] ?? '';
$sample_path = "../adminsection/systemimages/" . $sample_file;

if(empty($sample_file) || !file_exists($sample_path)){
    die("No official template found for this service ($app_type). Please ensure a sample is uploaded in Admin System Info.");
}

// 4. Generate the document (Using GD Library)
$info = @getimagesize($sample_path);
$mime = $info['mime'] ?? '';

if (strpos($mime, 'jpeg') !== false || strpos($mime, 'jpg') !== false) {
    $img = imagecreatefromjpeg($sample_path);
} elseif (strpos($mime, 'png') !== false) {
    $img = imagecreatefrompng($sample_path);
} else {
    // Fallback: Try to open it regardless of what the server thinks the mime type is
    $img = @imagecreatefromjpeg($sample_path);
    if (!$img) {
        $img = @imagecreatefrompng($sample_path);
    }
}

if (!$img) {
    die("Error: Managed to find the template but could not open it. Please ensure the file " . $sample_file . " is a valid JPG or PNG image.");
}

$img_w = imagesx($img);
$img_h = imagesy($img);

// SETUP COLORS
$black = imagecolorallocate($img, 0, 0, 0); 
$blue  = imagecolorallocate($img, 10, 50, 110); 

// FONT
$font = 5; 

/* -----------------------------
   PRECISE FIELD REPLACEMENT
------------------------------*/
if($app_type == 'National ID' || $app_type == 'National ID Profile'){
    // Data replacement for National ID Card
    imagestring($img, $font, 195, 142, strtoupper($app_data['full_name']), $black);
    imagestring($img, $font, 195, 172, $app_data['national_id'], $black);
    imagestring($img, $font, 195, 202, ($citizen['date_of_birth'] ?? date('d/m/Y')), $black);
    
} else if($app_type == 'Good Conduct' || $app_type == 'Criminal Record'){
    // Data placement for Good Conduct / Criminal Record
    // (Coordinates estimated for the layout in the screenshot)
    
    // Main Name (Top portion)
    imagestring($img, $font, 430, 230, strtoupper($app_data['full_name']), $blue);
    
    // Father/Mother
    imagestring($img, $font, 200, 275, ($citizen['father_name'] ?? 'N/A'), $black);
    imagestring($img, $font, 200, 315, ($citizen['mother_name'] ?? 'N/A'), $black);
    
    // Date of Birth / Place
    imagestring($img, $font, 200, 355, ($citizen['date_of_birth'] ?? '01/01/2000'), $black);
    imagestring($img, $font, 200, 395, ($citizen['place_of_birth'] ?? 'Kigali'), $black);
    
    // ID (Right Side)
    imagestring($img, 4, 430, 310, $app_data['national_id'], $black);
    
    // Bottom Date
    imagestring($img, $font, 100, 680, date('d/m/Y'), $black);

} else if($app_type == 'Marriage Certificate'){
    // Husband/Wife Replacement
    imagestring($img, $font, 320, 250, ($app_data['husband_name'] ?? 'N/A'), $black);
    imagestring($img, $font, 320, 300, ($app_data['wife_name'] ?? 'N/A'), $black);
    imagestring($img, $font, 320, 350, date('d/m/Y'), $black);

} else if(strpos($app_type, 'Driving') !== false || $app_type == 'Provisional License'){
    // License Replacement
    imagestring($img, $font, 160, 140, strtoupper($app_data['full_name']), $black);
    imagestring($img, $font, 160, 180, $app_data['national_id'], $black);
    imagestring($img, $font, 350, 220, ($app_data['categories'] ?? 'B'), $blue);
}

// 4. Output image directly (Removing all custom watermarks)
header('Content-Type: image/jpeg');
header('Content-Disposition: attachment; filename="'.$app_type.'_Generated.jpg"');
imagejpeg($img);
imagedestroy($img);
?>
