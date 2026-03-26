<div class="modal fade" id="applyModalnot" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- IMPORTANT: enctype added -->
      <form method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Apply for Notarial Act</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- Hidden -->
          <input type="hidden" name="service_name" value="<?php echo $row['service_name']; ?>">

          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
          </div>

          <div class="form-group">
            <label>National ID Number</label>
            <input type="text" name="national_id" class="form-control" required>
          </div>

          <!-- REQUIRED FIELD -->
          <div class="form-group">
            <label>Type of Notarial Act</label>
            <select name="act_type" class="form-control" required>
              <option value="">Select Type</option>
              <option value="Affidavit">Affidavit</option>
              <option value="Power of Attorney">Power of Attorney</option>
              <option value="Agreement">Agreement</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <!-- FILE UPLOAD -->
          <div class="form-group">
            <label>Upload Document</label>
            <input type="file" name="attachment" class="form-control" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" name="applynotarialact" class="btn btn-primary">
            Submit Application
          </button>
        </div>

      </form>

    </div>
  </div>
</div>