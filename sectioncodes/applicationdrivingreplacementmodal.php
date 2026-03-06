<!-- Driving License Replacement Modal -->
<div class="modal fade" id="applyDrivingReplacementModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Driving License Replacement Application</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="service_name" value="<?php echo $row['service_name']; ?>">
          <input type="hidden" name="processing_time" value="<?php echo (int)$row['processing_time']; ?>">
          <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
          <input type="hidden" name="currency" value="<?php echo $row['currency']; ?>">

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
            <label>National ID</label>
            <input type="text" name="national_id" class="form-control" placeholder="Enter your ID no" required>
          </div>

          <div class="form-group">
            <label>Driving License Number</label>
            <input type="text" name="license_number" class="form-control" placeholder="Enter your Driving ID no" required>
          </div>

          <div class="form-group">
            <label>Upload Old/ License</label>
            <input type="file" name="old_license_image" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Upload Police Declaration (If Lost)</label>
            <input type="file" name="police_document" class="form-control">
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" name="applydrivingreplacement" class="btn btn-primary">
            Submit Application
          </button>
        </div>

      </form>
    </div>
  </div>
</div>