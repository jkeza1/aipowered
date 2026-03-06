<?php
$servername = "localhost";
$username   = "root";        // change if needed
$password   = "";            // change if you have password
$database   = "iremboaipowered";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) 
{
die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>
