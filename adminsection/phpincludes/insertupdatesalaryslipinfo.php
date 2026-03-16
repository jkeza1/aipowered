<?php
if(isset($_POST['saveservice'])){

    include 'connection.php';

    $id = $_POST['id'];
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $processing_time = mysqli_real_escape_string($conn, $_POST['processing_time']);
    $price = (int)$_POST['price'];
    $provided_by = mysqli_real_escape_string($conn, $_POST['provided_by']);
    $status = $_POST['status'];

    if(empty($id)){
        $q = "INSERT INTO salaryslipinfo (service_name, description, requirements, processing_time, price, provided_by, status) VALUES ('$service_name', '$description', '$requirements', '$processing_time', '$price', '$provided_by', '$status')";
    } else {
        $q = "UPDATE salaryslipinfo SET service_name='$service_name', description='$description', requirements='$requirements', processing_time='$processing_time', price='$price', provided_by='$provided_by', status='$status' WHERE id=$id";
    }

    if(mysqli_query($conn, $q)){
        echo "<script>swal('Updated!', 'Salary Slip service settings updated successfully.', 'success');</script>";
    } else {
        echo "<script>swal('Error', 'Failed to update database.', 'error');</script>";
    }
}
?>