<!-- Passport Application Modal -->
<div class="modal fade" id="applyPassportModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Apply for e-Passport</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
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