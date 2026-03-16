<!-- applicationcourtjudgmentmodal.php -->
<div class="modal fade" id="applyCourtJudgmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title h4 text-white" id="exampleModalLongTitle">New Application: Court Judgment Forensic Copy</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5">
                <form action="backendcodes/sendapplicationcourtjudgment.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Full Name</label>
                            <input type="text" class="form-control" name="full_name" placeholder="As it appears on your ID" required>
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
                            <label class="font-weight-bold">National ID Number</label>
                            <input type="text" class="form-control" name="national_id" placeholder="119..." maxlength="16" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Court Case Number</label>
                            <input type="text" class="form-control" name="case_number" placeholder="RC 001/..." required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Year of Ruling</label>
                            <input type="number" class="form-control" name="ruling_year" min="1900" max="2024" required>
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
                            <label class="font-weight-bold">Upload Scanned Court Record (PDF/JPG)</label>
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
