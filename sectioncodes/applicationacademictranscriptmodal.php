<!-- applicationacademictranscriptmodal.php -->
<div class="modal fade" id="applyAcademicTranscriptModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title h4 text-white">New Application: Academic Transcript Verification</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <form  method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="service_name" value="Equivalence of Foreign Academic Quals">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Full Name (as on transcript)</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">National ID</label>
                            <input type="text" class="form-control" name="national_id" maxlength="16" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">School Name</label>
                            <input type="text" class="form-control" name="school_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Graduation Year</label>
                            <input type="number" class="form-control" name="grad_year" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Upload Academic Transcript (PDF/JPG)</label>
                            <input type="file" class="form-control-file border p-2" name="transcript_doc" required>
                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="applyacademictranscript" class="btn btn-primary px-4">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>