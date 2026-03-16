<?php
$result = mysqli_query($conn, "SELECT * FROM academictranscriptinfo WHERE status='Active' LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">

    <h3 class="mb-4 text-center">
        <?php echo $row['service_name'] ?? 'Equivalence of Foreign Academic Quals'; ?>
    </h3>

    <div class="p-4 bg-white shadow-sm rounded">

        <h5>About this Service</h5>
        <p><?php echo nl2br($row['description'] ?? 'Official verification and recognition of academic transcripts and qualifications.'); ?></p>

        <h5>Requirements</h5>
        <p><?php echo nl2br($row['requirements'] ?? '1. Original Transcript\n2. School Details'); ?></p>

        <p><strong>Processing Time:</strong>
            <?php echo $row['processing_time'] ?? '10 Days'; ?>
        </p>

        <p><strong>Fee:</strong>
             <?php 
                $price = $row['price'] ?? 10000;
                $currency = $row['currency'] ?? 'RWF';
                echo number_format($price) . " " . $currency; 
            ?>
        </p>

        <p><strong>Provided By:</strong>
            <?php echo $row['provided_by'] ?? 'REB/NESA'; ?>
        </p>

        <button class="btn btn-primary mt-3"
                data-bs-toggle="modal"
                data-bs-target="#applyAcademicTranscriptModal">
            Submit Application
        </button>

    </div>
</div>
</section>

<?php
include 'applicationacademictranscriptmodal.php';
?>