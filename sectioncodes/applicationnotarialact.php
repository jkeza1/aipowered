<?php
$query = "SELECT * FROM notarialactinfo LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">

    <h3 class="mb-4 text-center">
        <?php echo htmlspecialchars($row['service_name'] ?? 'Notarial Act Authentication'); ?>
    </h3>

    <div class="p-4 bg-white shadow-sm rounded">

        <h5>About this Service</h5>
        <p><?php echo nl2br(htmlspecialchars($row['description'] ?? 'Legal certification of documents by a public notary.')); ?></p>

        <h5>Requirements</h5>
        <p><?php echo nl2br(htmlspecialchars($row['requirements'] ?? '1. Original Document\n2. ID Copy')); ?></p>

        <p><strong>Processing Time:</strong>
            <?php echo htmlspecialchars($row['processing_time'] ?? '1 Day'); ?>
        </p>

        <p><strong>Fee:</strong>
             <?php 
                $price = $row['price'] ?? 5000;
                $currency = $row['currency'] ?? 'RWF';
                echo number_format($price) . " " . $currency; 
            ?>
        </p>

        <p><strong>Provided By:</strong>
            <?php echo htmlspecialchars($row['provided_by'] ?? 'MINIJUST'); ?>
        </p>

        <button class="btn btn-primary mt-3"
                data-bs-toggle="modal"
                data-bs-target="#applyModal">
            Apply Now
        </button>

    </div>
</div>
</section>

<?php include 'applicationnotarialactmodal.php'; ?>