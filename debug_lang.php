<?php
include 'backendcodes/sessionstart.php';
include 'backendcodes/connection.php';
include 'backendcodes/language.php';

echo "<h3>Translation Debugger</h3>";
echo "Current Language: <b>" . ($_SESSION['lang'] ?? 'en') . "</b><br>";

$test_services = [
    'Replacement of National ID Card',
    'Application for Provisional Driving License',
    'Marriage Certificate',
    'Criminal Record Certificate'
];

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Original</th><th>Key Generated</th><th>Translation (Found?)</th></tr>";

foreach($test_services as $s){
    $key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', trim($s)));
    
    // Check exact map logic used in dashboard
    $exact_map = [
        'replacement of national id card' => 'replacement_of_national_id_card',
        'replacement of driving license' => 'replacement_of_driving_license',
        'replacement of passport' => 'replacement_of_passport',
        'marriage certificate' => 'marriage_certificate_cert',
        'criminal record certificate' => 'criminal_record_certificate',
        'certificate of good conduct' => 'certificate_of_good_conduct',
        'application for provisional driving license' => 'application_for_provisional_driving_license',
        'application for definitive driving license' => 'application_for_definitive_driving_license',
        'application for new passport' => 'application_for_new_passport'
    ];

    $final_key = isset($exact_map[$key]) ? $exact_map[$key] : $key;
    $translated = __($final_key);
    $status = ($translated === $final_key) ? "<span style='color:red'>Not Found (Using Key)</span>" : "<span style='color:green'>Success</span>";

    echo "<tr><td>$s</td><td>$final_key</td><td>$translated ($status)</td></tr>";
}
echo "</table>";
?>