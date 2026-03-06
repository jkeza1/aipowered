<div class="modal fade" id="applyCriminalRecordModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Criminal Record Certificate Application</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="POST" enctype="multipart/form-data">
        <div class="modal-body">

          <input type="text" name="full_name" class="form-control mb-2" placeholder="Full Name" required>
          <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
          <input type="text" name="phone" class="form-control mb-2" placeholder="Phone Number" required>
          <input type="text" name="national_id" class="form-control mb-2" placeholder="National ID" required>

          <textarea name="purpose" class="form-control mb-2" placeholder="Purpose of Request" required></textarea>

          <label>Upload Required Attachment</label>
          <input type="file" name="attachment" class="form-control mb-2" required>

          <!-- Hidden fields -->
          <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($row['service_name']); ?>">
          <input type="hidden" name="processing_time" value="<?php echo (int)$row['processing_time']; ?>">
          <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
          <input type="hidden" name="provided_by" value="<?php echo htmlspecialchars($row['provided_by']); ?>">

        </div>

        <div class="modal-footer">
          <button type="submit" name="applycriminalrecord" class="btn btn-primary">
              Submit Application
          </button>
        </div>
      </form>

    </div>
  </div>
</div>