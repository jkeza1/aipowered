<?php
$result = mysqli_query($conn, "SELECT * FROM salaryslipinfo ORDER BY ID ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center"><?php echo __('admin_setting_salary_slip'); ?></h3>

    <form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo __('admin_official_service_name'); ?></label>
                <input type="text" name="service_name" class="form-control" value="<?php echo $row['service_name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label><?php echo __('admin_description'); ?></label>
                <textarea name="description" class="form-control" rows="6" required><?php echo $row['description'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label><?php echo __('admin_required_documents_list'); ?></label>
                <textarea name="requirements" class="form-control" rows="5"><?php echo $row['requirements'] ?? ''; ?></textarea>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo __('admin_ai_confidence_threshold'); ?></label>
                <input type="number" step="0.01" value="0.75" class="form-control" readonly>
                <small class="text-danger"><?php echo __('admin_ai_mode_champion'); ?></small>
            </div>

            <div class="form-group">
                <label><?php echo __('admin_processing_days'); ?></label>
                <input type="text" name="processing_time" class="form-control" value="<?php echo $row['processing_time'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_application_fee'); ?></label>
                <input type="number" name="price" class="form-control" value="<?php echo $row['price'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_providing_ministry'); ?></label>
                <input type="text" name="provided_by" class="form-control" value="<?php echo $row['provided_by'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_service_status'); ?></label>
                <select name="status" class="form-control">
                    <option value="Active" <?php if(($row['status'] ?? '')=='Active') echo 'selected'; ?>><?php echo __('admin_active'); ?></option>
                    <option value="Inactive" <?php if(($row['status'] ?? '')=='Inactive') echo 'selected'; ?>><?php echo __('admin_inactive'); ?></option>
                </select>
            </div>
        </div>

    </div>

    <button type="submit" name="saveservice" class="btn btn-primary btn-block mt-3">
        <?php echo __('admin_update_ai_powered_service_settings'); ?>
    </button>

    </form>
</div>
</section>