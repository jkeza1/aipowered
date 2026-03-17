<?php
$result = mysqli_query($conn, "SELECT * FROM goodconductinfo WHERE id=1 LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center"><?php echo __('admin_setting_good_conduct'); ?></h3>

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
                <label><?php echo __('admin_about_this_service'); ?></label>
                <textarea name="description" class="form-control" rows="6" required>
<?php echo $row['description'] ?? ''; ?>
                </textarea>
            </div>

            <div class="form-group">
                <label><?php echo __('admin_required_attachments'); ?></label>
                <textarea name="required_attachments" class="form-control" rows="6"
                placeholder="<?php echo __('admin_enter_each_attachment_new_line'); ?>">
<?php echo $row['required_attachments'] ?? ''; ?>
                </textarea>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">

            <div class="form-group">
                <label><?php echo __('admin_processing_time'); ?></label>
                <input type="text" name="processing_time" class="form-control"
                       value="<?php echo $row['processing_time'] ?? ''; ?>"
                       placeholder="<?php echo __('admin_example_7_days'); ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_price'); ?></label>
                <input type="text" name="price" class="form-control"
                       value="<?php echo $row['price'] ?? ''; ?>"
                       placeholder="<?php echo __('admin_free'); ?>">
            </div>

            <div class="form-group">
                <label><?php echo __('admin_provided_by'); ?></label>
                <input type="text" name="provided_by" class="form-control"
                       value="<?php echo $row['provided_by'] ?? ''; ?>"
                       placeholder="RIB">
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

    <button type="submit" name="savegoodconduct" class="btn btn-primary btn-block mt-3">
        <?php echo __('admin_save_service'); ?>
    </button>

    </form>

</div>
</section>