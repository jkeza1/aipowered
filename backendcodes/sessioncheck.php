<?php
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
$user_email = $_SESSION['email'];
$user_phone = $_SESSION['phone'];
$user_id = $_SESSION['user_id'];
?>