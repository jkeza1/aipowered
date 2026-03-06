<?php
$result = mysqli_query($conn, "SELECT * FROM goodconductinfo WHERE id=1 LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center">Setting - Certificate of Good Conduct</h3>

    <form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-6">

            <div class="form-group">
                <label>Service Name</label>
                <input type="text" name="service_name" class="form-control"
                       value="<?php echo $row['service_name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label>About this Service</label>
                <textarea name="description" class="form-control" rows="6" required>
<?php echo $row['description'] ?? ''; ?>
                </textarea>
            </div>

            <div class="form-group">
                <label>Required Attachments</label>
                <textarea name="required_attachments" class="form-control" rows="6"
                placeholder="Enter each attachment on a new line">
<?php echo $row['required_attachments'] ?? ''; ?>
                </textarea>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">

            <div class="form-group">
                <label>Processing Time</label>
                <input type="text" name="processing_time" class="form-control"
                       value="<?php echo $row['processing_time'] ?? ''; ?>"
                       placeholder="Example: 7 Days">
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="text" name="price" class="form-control"
                       value="<?php echo $row['price'] ?? ''; ?>"
                       placeholder="Free">
            </div>

            <div class="form-group">
                <label>Provided By</label>
                <input type="text" name="provided_by" class="form-control"
                       value="<?php echo $row['provided_by'] ?? ''; ?>"
                       placeholder="RIB">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Active" <?php if(($row['status'] ?? '')=='Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if(($row['status'] ?? '')=='Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>

        </div>

    </div>

    <button type="submit" name="savegoodconduct" class="btn btn-primary btn-block mt-3">
        Save Service
    </button>

    </form>

</div>
</section>