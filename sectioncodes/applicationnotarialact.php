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
                data-bs-target="#applyModalnot">
            Apply Now
        </button>

    </div>
</div>
</section>

<?php
include 'applicationnotarialactmodal.php';
?>

<!-- Passport Application Modal -->
<div class="modal fade" id="applyModalnot" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Apply for e-Passport</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="service_name" value="<?php echo $row['service_name']; ?>">
          <input type="hidden" name="request_type" value="<?php echo $row['request_type']; ?>">
          <input type="hidden" name="processing_time" value="<?php echo (int)$row['processing_time']; ?>">
          <input type="hidden" name="fee" value="<?php echo $row['fee']; ?>">

          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" placeholder="Enter your names" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
          </div>

          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter your phone" required>
          </div>

          <div class="form-group">
            <label>National ID Number</label>
            <input type="text" name="national_id" class="form-control" placeholder="Enter your ID no" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" name="applypassport" class="btn btn-primary">
            Submit Application
          </button>
        </div>

      </form>
    </div>
  </div>
</div>


