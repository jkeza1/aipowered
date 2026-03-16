<!-- applicationbankstatementmodal.php -->
<div class="modal fade" id="applyBankStatementModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title h4 text-white">New Application: Bank Statement Authentication</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-5">
                <form action="backendcodes/sendapplicationbankstatement.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="service_name" value="Bank Statement Authentication">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Full Name (as on bank account)</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">National ID</label>
                            <input type="text" class="form-control" name="national_id" maxlength="16" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Account Number</label>
                            <input type="text" class="form-control" name="account_number" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Upload Bank Statement (PDF/JPG)</label>
                            <input type="file" class="form-control-file border p-2" name="bank_doc" required>
                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="applybankstatement" class="btn btn-primary px-4">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>