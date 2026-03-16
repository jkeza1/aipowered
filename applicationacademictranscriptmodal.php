<!-- Academic Transcript Modal -->
<div class="modal fade" id="applyAcademicTranscriptModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">New Application: Academic Transcript Equivalence</h5>
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
                            <label>School/University Name</label>
                            <input type="text" name="school_name" class="form-control" required placeholder="University of Rwanda">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Year of Graduation</label>
                            <input type="number" name="grad_year" class="form-control" required min="1990" max="2026" placeholder="2024">
                        </div>
                        <div class="col-12 mb-3">
                            <label>Upload Original Transcript (Image/PDF)</label>
                            <input type="file" name="transcript_doc" class="form-control" required accept="image/*,.pdf">
                            <small class="text-muted">AI will scan for credential tampering and structural layout anomalies.</small>
                        </div>
                        <input type="hidden" name="service_name" value="<?php echo $row['service_name'] ?? 'Equivalence of Foreign Academic Quals'; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="applyacademictranscript" class="btn btn-success text-white">Submit for Forensic Scan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>