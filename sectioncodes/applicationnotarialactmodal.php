<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Application Form: <?php echo $row['service_name'] ?? 'Notarial Act Authentication'; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <form action="backendcodes/sendapplicationnotarialact.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Applicant Full Name</label>
                            <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Phone Number</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">National ID</label>
                            <input type="text" class="form-control" name="national_id" placeholder="National ID" maxlength="16" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Type of Notarial Act</label>
                            <select class="form-control" name="act_type" required>
                                <option value="">Select Act Type...</option>
                                <option value="Signature Authentication">Signature Authentication</option>
                                <option value="Certified Copy of Original">Certified Copy of Original</option>
                                <option value="Affidavit Support">Affidavit Support</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">District</label>
                            <input type="text" class="form-control" name="district" placeholder="District" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Sector</label>
                            <input type="text" class="form-control" name="sector" placeholder="Sector" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Reason for Application</label>
                            <textarea class="form-control" name="reason" rows="2" placeholder="Reason for this application" required></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Upload Document (PDF/JPG/PNG)</label>
                            <input type="file" class="form-control-file border p-2" name="document" id="document" required>
                            <small class="text-muted">Allowed types: PDF, JPG, PNG. Max size: 5MB.</small>
                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4" name="submit_application">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Apply Modal End -->