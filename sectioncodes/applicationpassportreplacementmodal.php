<div class="modal fade" id="applyPassportReplacementModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Passport Replacement Application</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="POST">
        <div class="modal-body">

          <input type="text" name="full_name" class="form-control mb-2" placeholder="Full Name" required>
          <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
          <input type="text" name="phone" class="form-control mb-2" placeholder="Phone Number" required>
          <input type="text" name="national_id" class="form-control mb-2" placeholder="National ID" required>
          <input type="text" name="passport_number" class="form-control mb-2" placeholder="Old Passport Number" required>

          <textarea name="reason" class="form-control mb-2" placeholder="Reason for Replacement" required></textarea>

          <!-- Hidden service values -->
          <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($row['service_name']); ?>">
          <input type="hidden" name="processing_time" value="<?php echo (int)$row['processing_time']; ?>">
          <input type="hidden" name="fee" value="<?php echo htmlspecialchars($row['fee']); ?>">
          <input type="hidden" name="provided_by" value="<?php echo htmlspecialchars($row['provided_by']); ?>">

        </div>

        <div class="modal-footer">
          <button type="submit" name="applypassportreplacement" class="btn btn-primary">
              Submit Application
          </button>
        </div>
      </form>

    </div>
  </div>
</div>