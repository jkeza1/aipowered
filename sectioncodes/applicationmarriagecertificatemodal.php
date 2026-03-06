<!-- Marriage Certificate Modal -->
<div class="modal fade" id="applyMarriageModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Apply for Marriage Certificate</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="service_name" value="<?php echo $row['service_name']; ?>">
          <input type="hidden" name="processing_time" value="<?php echo (int)$row['processing_time']; ?>">
          <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
          <input type="hidden" name="currency" value="<?php echo $row['currency']; ?>">

          <div class="form-group">
            <label>Husband Full Name</label>
            <input type="text" name="husband_full_name" class="form-control" placeholder="Enter husband_full_name" required>
          </div>

          <div class="form-group">
            <label>Husband National ID</label>
            <input type="text" name="husband_national_id" class="form-control" placeholder="Enter husband ID no" required>
          </div>

          <div class="form-group">
            <label>Wife Full Name</label>
            <input type="text" name="wife_full_name" class="form-control" placeholder="Enter wife_full_name" required>
          </div>

          <div class="form-group">
            <label>Wife National ID</label>
            <input type="text" name="wife_national_id" class="form-control" placeholder="Enter wife ID no" required>
          </div>

          <div class="form-group">
            <label>Applicant Email</label>
            <input type="email" name="applicant_email" class="form-control" placeholder="Enter Applicant email" required>
          </div>

          <div class="form-group">
            <label>Applicant Phone</label>
            <input type="text" name="applicant_phone" class="form-control" placeholder="Enter Applicant phone" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" name="applymarriagecertificate" class="btn btn-primary">
            Submit Application
          </button>
        </div>

      </form>
    </div>
  </div>
</div>