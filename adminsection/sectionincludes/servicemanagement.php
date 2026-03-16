<?php
$service_key = isset($_GET['type']) ? $_GET['type'] : 'notarialact';

$service_map = [
    'notarialact' => ['table' => 'notarialactinfo', 'label' => 'Notarial Act'],
    'administrative' => ['table' => 'administrativeinfo', 'label' => 'Administrative Document'],
    'commercialbuilding' => ['table' => 'commercialbuildinginfo', 'label' => 'Commercial Building Permit'],
    'academictranscript' => ['table' => 'academictranscriptinfo', 'label' => 'Academic Transcript'],
    'bankstatement' => ['table' => 'bankstatementinfo', 'label' => 'Bank Statement'],
    'businesslicense' => ['table' => 'businesslicenseinfo', 'label' => 'Business License'],
    'medicalreport' => ['table' => 'medicalreportinfo', 'label' => 'Medical Report'],
    'employmentcontract' => ['table' => 'employmentcontractinfo', 'label' => 'Employment Contract'],
    'propertyownership' => ['table' => 'propertyownershipinfo', 'label' => 'Property Ownership'],
    'powerofattorney' => ['table' => 'powerofattorneyinfo', 'label' => 'Power of Attorney'],
    'courtjudgment' => ['table' => 'courtjudgmentinfo', 'label' => 'Court Judgment'],
    'salarycertificate' => ['table' => 'salarycertificateinfo', 'label' => 'Salary Certificate']
];

if(!array_key_exists($service_key, $service_map)) {
    die("Invalid service type.");
}

$config = $service_map[$service_key];
$table = $config['table'];

if(isset($_POST['saveservice'])){
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $processing_time = mysqli_real_escape_string($conn, $_POST['processing_time']);
    $price = intval($_POST['price']);
    $currency = mysqli_real_escape_string($conn, $_POST['currency']);
    $provided_by = mysqli_real_escape_string($conn, $_POST['provided_by']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $check = mysqli_query($conn, "SELECT id FROM $table LIMIT 1");
    if(mysqli_num_rows($check) > 0){
        $res = mysqli_fetch_assoc($check);
        $id = $res['id'];
        mysqli_query($conn, "UPDATE $table SET 
            service_name='$service_name', 
            description='$description', 
            requirements='$requirements', 
            processing_time='$processing_time', 
            price='$price', 
            currency='$currency', 
            provided_by='$provided_by', 
            status='$status' 
            WHERE id=$id");
    } else {
        mysqli_query($conn, "INSERT INTO $table (service_name, description, requirements, processing_time, price, currency, provided_by, status) 
            VALUES ('$service_name', '$description', '$requirements', '$processing_time', '$price', '$currency', '$provided_by', '$status')");
    }
    echo "<script>alert('Service updated successfully');</script>";
}

$result = mysqli_query($conn, "SELECT * FROM $table ORDER BY id ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>
<section class="ftco-section services-section">
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Service Management: <?= $config['label']; ?></h3>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <form method="POST">
                <div class="row">
                    <!-- LEFT SIDE -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Service Name</label>
                            <input type="text" name="service_name" class="form-control"
                                   value="<?php echo $row['service_name'] ?? $config['label']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">About this Service</label>
                            <textarea name="description" class="form-control" rows="5" required><?php echo $row['description'] ?? ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Requirements</label>
                            <textarea name="requirements" class="form-control" rows="4"><?php echo $row['requirements'] ?? ''; ?></textarea>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Processing Time</label>
                            <input type="text" name="processing_time" class="form-control"
                                   value="<?php echo $row['processing_time'] ?? ''; ?>"
                                   placeholder="e.g. 3 Working Days">
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price</label>
                                    <input type="number" name="price" class="form-control"
                                           value="<?php echo $row['price'] ?? '0'; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Currency</label>
                                    <input type="text" name="currency" class="form-control"
                                           value="<?php echo $row['currency'] ?? 'RWF'; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Provided By</label>
                            <input type="text" name="provided_by" class="form-control"
                                   value="<?php echo $row['provided_by'] ?? ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" <?php if(($row['status'] ?? 'Active')=='Active') echo 'selected'; ?>>Active</option>
                                <option value="Inactive" <?php if(($row['status'] ?? '')=='Inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" name="saveservice" class="btn btn-primary px-5 py-2 fw-bold" style="border-radius: 8px;">
                        Save Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
