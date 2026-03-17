<?php
$result = mysqli_query($conn, "SELECT * FROM passportinfo ORDER BY id ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center"><?php echo __('admin_setting_passport'); ?></h3>

    <form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-6">

            <div class="form-group">
                <label><?php echo __('admin_service_name'); ?></label>
                <input type="text" name="service_name" class="form-control"
                       value="<?php echo $row['service_name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label><?php echo __('admin_request_type'); ?></label>
                <input type="text" name="request_type" class="form-control"
                       value="<?php echo $row['request_type'] ?? ''; ?>"
                       placeholder="<?php echo __('admin_example_epassport_first'); ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_about_this_service'); ?></label>
                <textarea name="description" class="form-control" rows="7" required>
<?php echo $row['description'] ?? ''; ?>
                </textarea>
            </div>

            <div class="form-group">
                <label><?php echo __('admin_requirements'); ?></label>
                <textarea name="requirements" class="form-control" rows="5">
<?php echo $row['requirements'] ?? ''; ?>
                </textarea>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">

            <div class="form-group">
                <label><?php echo __('admin_processing_time'); ?></label>
                <input type="text" name="processing_time" class="form-control"
                       value="<?php echo $row['processing_time'] ?? ''; ?>"
                       placeholder="<?php echo __('admin_example_4_working_days'); ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('fee'); ?></label>
                <input type="text" name="fee" class="form-control"
                       value="<?php echo $row['fee'] ?? ''; ?>"
                       placeholder="<?php echo __('admin_depends_epassport_category'); ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_provided_by'); ?></label>
                <input type="text" name="provided_by" class="form-control"
                       value="<?php echo $row['provided_by'] ?? ''; ?>"
                       placeholder="DGIE">
            </div>

            <div class="form-group">
                <label><?php echo __('status'); ?></label>
                <select name="status" class="form-control">
                    <option value="Active" <?php if(($row['status'] ?? '')=='Active') echo 'selected'; ?>><?php echo __('admin_active'); ?></option>
                    <option value="Inactive" <?php if(($row['status'] ?? '')=='Inactive') echo 'selected'; ?>><?php echo __('admin_inactive'); ?></option>
                </select>
            </div>

        </div>

    </div>

    <button type="submit" name="savepassport" class="btn btn-primary btn-block mt-3">
        <?php echo __('admin_save_service'); ?>
    </button>

    </form>

</div>
</section>