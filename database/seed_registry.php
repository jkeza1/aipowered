<?php
include '../backendcodes/connection.php';

$names = ["MUHIZI", "KEZA", "GAKWAYA", "UWASE", "MUGISHA", "ISHIMWE", "KAREKEZI", "MUTONI"];
$villages = ["Kigali", "Huye", "Musanze", "Rubavu", "Rwamagana"];

echo "Starting Registry Population (Updated Structure)...<br>";

for ($i = 0; $i < 100; $i++) {
    $first_name = $names[array_rand($names)];
    $last_name = $names[array_rand($names)] . " " . ($i + 100);
    $gender = (rand(0, 1) == 0) ? 'Male' : 'Female';
    $national_id = "1" . date("Y") . "8" . str_pad($i, 7, "0", STR_PAD_LEFT) . "0";
    $dob = rand(1970, 2005) . "-" . str_pad(rand(1, 12), 2, "0", STR_PAD_LEFT) . "-" . str_pad(rand(1, 28), 2, "0", STR_PAD_LEFT);
    $father = $names[array_rand($names)] . " Senior";
    $mother = $names[array_rand($names)] . " Senior";
    $pob = $villages[array_rand($villages)];
    $email = strtolower($first_name . $i) . "@example.com";

    $sql = "INSERT INTO citizensregistry (first_name, last_name, gender, date_of_birth, national_id, father_name, mother_name, place_of_birth, email) 
            VALUES ('$first_name', '$last_name', '$gender', '$dob', '$national_id', '$father', '$mother', '$pob', '$email')";
    
    if (mysqli_query($conn, $sql)) {
        // Success
    } else {
        echo "Error at record $i: " . mysqli_error($conn) . "<br>";
    }
}

echo "✅ Successfully populated 100 'Ground Truth' records.";
?>
