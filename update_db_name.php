<?php
include 'backendcodes/connection.php';

// Add full_name column to users table
$alter_query = "ALTER TABLE users ADD COLUMN full_name VARCHAR(255) AFTER id";
if(mysqli_query($conn, $alter_query)){
    echo "Column 'full_name' added successfully.<br>";
} else {
    echo "Error adding column: " . mysqli_error($conn) . "<br>";
}

// Update existing users with a placeholder name (based on email)
$update_query = "UPDATE users SET full_name = SUBSTRING_INDEX(email, '@', 1) WHERE full_name IS NULL";
if(mysqli_query($conn, $update_query)){
    echo "Existing users updated with temporary names.<br>";
}

echo "Database update complete. You can delete this file.";
?>