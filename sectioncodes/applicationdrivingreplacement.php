<?php
$result = mysqli_query($conn, "SELECT * FROM drivinglicenseinfo WHERE status='Active' LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">

    <h3 class="mb-4 text-center">
        <?php echo htmlspecialchars($row['service_name']); ?>
    </h3>

    <div class="p-4">

        <h5>About this Service</h5>
        <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

        <h5>Requirements</h5>
        <p><?php echo nl2br(htmlspecialchars($row['requirements'])); ?></p>

        <p><strong>Processing Time:</strong>
            <?php echo htmlspecialchars($row['processing_time']); ?>
        </p>

        <p><strong>Fee:</strong>
            <?php echo htmlspecialchars($row['price']).' '.htmlspecialchars($row['currency']); ?>
        </p>

        <p><strong>Provided By:</strong>
            <?php echo htmlspecialchars($row['provided_by']); ?>
        </p>

        <!-- Apply Button -->
        <button class="btn btn-primary mt-3"
                data-toggle="modal"
                data-target="#applyDrivingReplacementModal">
            Apply Now
        </button>

    </div>

</div>
</section>

<?php
include 'applicationdrivingreplacementmodal.php';
?>