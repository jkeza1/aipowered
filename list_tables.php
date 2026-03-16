<?php
$conn = mysqli_connect('localhost', 'root', '', 'iremboaipowered');
$res = mysqli_query($conn, "SHOW TABLES LIKE 'application%'");
while($row = mysqli_fetch_array($res)) {
    echo $row[0] . "\n";
}
?>