<?php
$conn = mysqli_connect('localhost', 'root', '', 'iremboaipowered');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$tables = [
    'applicationacademictranscript', 'applicationbankstatement', 'applicationnotarialact',
    'applicationpowerofattorney', 'applicationcourtjudgment', 'applicationsalarycertificate',
    'applicationemploymentcontract', 'applicationmedicalreport', 'applicationbusinesslicense',
    'applicationpropertyownership', 'applicationadministrative', 'applicationcommercialbuilding'
];

foreach ($tables as $table) {
    echo "Checking $table...\n";
    $res = mysqli_query($conn, "SHOW COLUMNS FROM $table");
    if (!$res) {
        echo "Table $table does not exist.\n";
        continue;
    }
    
    $cols = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $cols[] = $row['Field'];
    }
    
    if (!in_array('email', $cols)) {
        echo "Fixing $table: adding email, phone, expected_feedback_date...\n";
        mysqli_query($conn, "ALTER TABLE $table ADD COLUMN email VARCHAR(255) AFTER id");
        mysqli_query($conn, "ALTER TABLE $table ADD COLUMN phone VARCHAR(255) AFTER email");
    } else {
        echo "$table already has email.\n";
    }

    if (!in_array('expected_feedback_date', $cols)) {
        echo "Fixing $table: adding expected_feedback_date...\n";
        mysqli_query($conn, "ALTER TABLE $table ADD COLUMN expected_feedback_date DATE AFTER status");
    } else {
        echo "$table already has expected_feedback_date.\n";
    }
    
    if (!in_array('admin_reason', $cols)) {
        echo "Fixing $table: adding admin_reason...\n";
        mysqli_query($conn, "ALTER TABLE $table ADD COLUMN admin_reason TEXT AFTER status");
    } else {
        echo "$table already has admin_reason.\n";
    }
}
echo "Database update complete.\n";
?>