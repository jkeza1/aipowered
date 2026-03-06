<?php
if(isset($_POST['savepassport']))
{
    $id = $_POST['id'] ?? '';

    $service_name    = mysqli_real_escape_string($conn, $_POST['service_name']);
    $request_type    = mysqli_real_escape_string($conn, $_POST['request_type']);
    $description     = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements    = mysqli_real_escape_string($conn, $_POST['requirements']);
    $processing_time = mysqli_real_escape_string($conn, $_POST['processing_time']);
    $fee             = mysqli_real_escape_string($conn, $_POST['fee']);
    $provided_by     = mysqli_real_escape_string($conn, $_POST['provided_by']);
    $status          = mysqli_real_escape_string($conn, $_POST['status']);

    if($id) {
        $sql = "UPDATE passportinfo SET
                    service_name='$service_name',
                    request_type='$request_type',
                    description='$description',
                    requirements='$requirements',
                    processing_time='$processing_time',
                    fee='$fee',
                    provided_by='$provided_by',
                    status='$status'
                WHERE id='$id'";
    } else {
        $sql = "INSERT INTO passportinfo
                (service_name, request_type, description, requirements, processing_time, fee, provided_by, status)
                VALUES
                ('$service_name','$request_type','$description','$requirements','$processing_time','$fee','$provided_by','$status')";
    }

    if(mysqli_query($conn, $sql)) {
        echo "
        <script>
        swal({
          title: 'Success!',
          text: 'Passport service saved successfully.',
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