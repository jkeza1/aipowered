<?php
include '../backendcodes/connection.php';

$table = 'applicationsalarycertificate';
$res = mysqli_query($conn, "DESCRIBE $table");
if (!$res) {
    die("Table error: " . mysqli_error($conn));
}
echo "Schema for $table:\n";
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
?>