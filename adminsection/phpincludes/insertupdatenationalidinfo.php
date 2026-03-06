<?php
if(isset($_POST['saveservice']))
{
    $id = $_POST['id'] ?? '';

    // Escape inputs to prevent SQL injection
    $service_name     = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description      = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements     = mysqli_real_escape_string($conn, $_POST['requirements']);
    $processing_time  = mysqli_real_escape_string($conn, $_POST['processing_time']);
    $price            = mysqli_real_escape_string($conn, $_POST['price']);
    $currency         = mysqli_real_escape_string($conn, $_POST['currency']);
    $provided_by      = mysqli_real_escape_string($conn, $_POST['provided_by']);
    $status           = mysqli_real_escape_string($conn, $_POST['status']);

    if($id) {
        // Update existing service
        $sql = "UPDATE nationalidinfo SET
                    service_name='$service_name',
                    description='$description',
                    requirements='$requirements',
                    processing_time='$processing_time',
                    price='$price',
                    currency='$currency',
                    provided_by='$provided_by',
                    status='$status'
                WHERE id='$id'";
    } else {
        // Insert new service
        $sql = "INSERT INTO nationalidinfo
                (service_name, description, requirements, processing_time, price, currency, provided_by, status)
                VALUES
                ('$service_name','$description','$requirements','$processing_time','$price','$currency','$provided_by','$status')";
    }

    if(mysqli_query($conn, $sql)) {
        echo "
        <script>
        swal({
          title: 'Success!',
          text: 'Service info saved successfully.',
          icon: 'success',
          button: 'OK'
        }).then(() => {
          window.location.href = '';
        });
        </script>
        ";
    } else {
        echo "
        <script>
        swal({
          title: 'Error!',
          text: 'Something went wrong.',
          icon: 'error',
          button: 'OK'
        });
        </script>
        ";
    }
}
?>