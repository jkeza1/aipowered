<!-- applicationpowerofattorneymodal.php -->
<div class="modal fade" id="applyPowerOfAttorneyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title h4 text-white">New Application: Power of Attorney Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <form  method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Grantor Full Name</label>
                            <input type="text" class="form-control" name="full_name" required>
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
                            <input type="text" class="form-control" name="national_id" maxlength="16" required>
                        </div>
                        <div class="col-md-6 border-left border-primary pl-4">
                            <label class="font-weight-bold">Proxy (Agent) Full Name</label>
                            <input type="text" class="form-control" name="appointee_name" required>
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
                            <label class="font-weight-bold">Upload Signed POA (PDF/JPG)</label>
                            <input type="file" class="form-control-file border p-2" name="document" required>
                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn btn-primary px-4">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>