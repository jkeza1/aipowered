<!-- Bank Statement Modal -->
<div class="modal fade" id="applyBankStatementModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">New Application: Bank Statement Authentication</h5>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?php echo $_SESSION['full_name'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>National ID</label>
                            <input type="text" name="national_id" class="form-control" value="<?php echo $_SESSION['national_id'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" required placeholder="Example: BK, I&M, Equity">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Account Number</label>
                            <input type="text" name="account_number" class="form-control" required placeholder="1234567890">
                        </div>
                        <div class="col-12 mb-3">
                            <label>Upload Original Bank Statement (Image/PDF)</label>
                            <input type="file" name="bank_doc" class="form-control" required accept="image/*,.pdf">
                            <small class="text-muted">AI will scan for structural integrity and manipulation artifacts.</small>
                        </div>
                        <input type="hidden" name="service_name" value="<?php echo $row['service_name'] ?? 'Authentication of Bank Statement'; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="applybankstatement" class="btn btn-info text-white">Submit for Forensic Scan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>