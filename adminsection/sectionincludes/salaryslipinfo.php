<?php
$result = mysqli_query($conn, "SELECT * FROM salaryslipinfo ORDER BY ID ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center">Settings - Salary Slip Certification</h3>

    <form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Official Service Name</label>
                <input type="text" name="service_name" class="form-control" value="<?php echo $row['service_name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Description (Rwandan English)</label>
                <textarea name="description" class="form-control" rows="6" required><?php echo $row['description'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Required Documents (List)</label>
                <textarea name="requirements" class="form-control" rows="5"><?php echo $row['requirements'] ?? ''; ?></textarea>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">
            <div class="form-group">
                <label>AI Confidence Threshold (0.0 - 1.0)</label>
                <input type="number" step="0.01" value="0.75" class="form-control" readonly>
                <small class="text-danger">AI Mode: Champion EfficientNetB0 (Active)</small>
            </div>

            <div class="form-group">
                <label>Processing Days</label>
                <input type="text" name="processing_time" class="form-control" value="<?php echo $row['processing_time'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Application Fee</label>
                <input type="number" name="price" class="form-control" value="<?php echo $row['price'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Providing Ministry</label>
                <input type="text" name="provided_by" class="form-control" value="<?php echo $row['provided_by'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Service Status</label>
                <select name="status" class="form-control">
                    <option value="Active" <?php if(($row['status'] ?? '')=='Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if(($row['status'] ?? '')=='Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
        </div>

    </div>

    <button type="submit" name="saveservice" class="btn btn-primary btn-block mt-3">
        Update AI-Powered Service Settings
    </button>

    </form>
</div>
</section>