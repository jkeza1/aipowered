<?php
$result = mysqli_query($conn, "SELECT * FROM bankstatementinfo WHERE status='Active' LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">

    <h3 class="mb-4 text-center">
        <?php echo $row['service_name'] ?? 'Authentication of Bank Statement'; ?>
    </h3>

    <div class="p-4 bg-white shadow-sm rounded">

        <h5>About this Service</h5>
        <p><?php echo nl2br($row['description'] ?? 'Official authentication of bank account transaction history for official use.'); ?></p>

        <h5>Requirements</h5>
        <p><?php echo nl2br($row['requirements'] ?? '1. Original PDF Statement\n2. Bank Account Details'); ?></p>

        <p><strong>Processing Time:</strong>
            <?php echo $row['processing_time'] ?? '1 Day'; ?>
        </p>

        <p><strong>Fee:</strong>
             <?php 
                $price = $row['price'] ?? 2000;
                $currency = $row['currency'] ?? 'RWF';
                echo number_format($price) . " " . $currency; 
            ?>
        </p>

        <p><strong>Provided By:</strong>
            <?php echo $row['provided_by'] ?? 'BNR'; ?>
        </p>

        <button class="btn btn-primary mt-3"
                data-bs-toggle="modal"
                data-bs-target="#applyBankStatementModal">
            Submit Application
        </button>

    </div>
</div>
</section>

<?php
include 'applicationbankstatementmodal.php';
?>