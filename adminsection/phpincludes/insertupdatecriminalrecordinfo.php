<?php
if(isset($_POST['savecriminalrecord'])) {

    $id = $_POST['id'];
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $processing_time = mysqli_real_escape_string($conn, $_POST['processing_time']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $currency = mysqli_real_escape_string($conn, $_POST['currency']);
    $provided_by = mysqli_real_escape_string($conn, $_POST['provided_by']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if($id == "") {
        // INSERT
        mysqli_query($conn, "INSERT INTO criminalrecordinfo 
            (service_name, description, requirements, processing_time, price, currency, provided_by, status)
            VALUES
            ('$service_name','$description','$requirements','$processing_time','$price','$currency','$provided_by','$status')");
    } else {
        // UPDATE
        mysqli_query($conn, "UPDATE criminalrecordinfo SET
            service_name='$service_name',
            description='$description',
            requirements='$requirements',
            processing_time='$processing_time',
            price='$price',
            currency='$currency',
            provided_by='$provided_by',
            status='$status'
            WHERE id='$id'");
    }

    echo "<script>
        swal({
            title: 'Success!',
            text: 'Criminal Record Service updated successfully!',
            icon: 'success'
        })
    </script>";
}
?>