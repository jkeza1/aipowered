<!-- Salary Slip Modal -->
<div class="modal fade" id="applySalarySlipModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">New Application: Salary Slip Certification</h5>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <!-- Citizen Info (ReadOnly) -->
                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?php echo $_SESSION['full_name'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>National ID</label>
                            <input type="text" name="national_id" class="form-control" value="<?php echo $_SESSION['national_id'] ?? ''; ?>" required>
                        </div>

                        <!-- Specific Requirements -->
                        <div class="col-md-6 mb-3">
                            <label>Employer Name</label>
                            <input type="text" name="employer_name" class="form-control" required placeholder="Example: Rwanda Energy Group">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Monthly Net Salary (RWF)</label>
                            <input type="number" name="monthly_net" class="form-control" required placeholder="500000">
                        </div>

                        <div class="col-12 mb-3">
                            <label>Upload Original Salary Slip (Image/PDF)</label>
                            <input type="file" name="salary_doc" class="form-control" required accept="image/*,.pdf">
                            <small class="text-muted">AI will scan this document for forensic integrity.</small>
                        </div>

                        <!-- Hidden Metadata -->
                        <input type="hidden" name="service_name" value="<?php echo $row['service_name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                        <input type="hidden" name="currency" value="<?php echo $row['currency']; ?>">
                        <input type="hidden" name="processing_time" value="<?php echo (int)$row['processing_time']; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="applysalaryslip" class="btn btn-success">Submit for AI Verification</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>