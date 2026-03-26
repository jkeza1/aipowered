<!-- applicationcertificateofcelibacymodal.php -->
<div class="modal fade" id="applyCertificateOfCelibacyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title h4 text-white">New Application: Certificate of Being Single</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <form action="backendcodes/sendapplicationcertificateofcelibacy.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Full Name</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">National ID Number</label>
                            <input type="text" class="form-control" name="national_id" maxlength="16" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">District of Birth</label>
                            <input type="text" class="form-control" name="birth_district" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Upload Local Gov Recommendation (PDF/JPG)</label>
                            <input type="file" class="form-control-file border p-2" name="document" required>
                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>