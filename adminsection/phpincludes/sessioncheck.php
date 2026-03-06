<?php
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location:phpincludes/logout.php");
}
?>