<?php
$result = mysqli_query($conn, "SELECT * FROM passportinfo WHERE status='Active' ORDER BY id ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">

    <h3 class="mb-4 text-center"><?php echo $row['service_name']; ?></h3>

    <div class="p-4">

        <p><strong>Request Type:</strong> <?php echo $row['request_type']; ?></p>

        <h5>About this Service</h5>
        <p><?php echo nl2br($row['description']); ?></p>

        <h5>Requirements</h5>
        <p><?php echo nl2br($row['requirements']); ?></p>

        <p><strong>Processing Time:</strong> <?php echo $row['processing_time']; ?></p>
        <p><strong>Fee:</strong> <?php echo $row['fee']; ?></p>
        <p><strong>Provided By:</strong> <?php echo $row['provided_by']; ?></p>

        <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#applyPassportModal">
            Apply Now
        </button>

    </div>

</div>
</section>

<?php
include 'applicationpassportmodal.php';
?>