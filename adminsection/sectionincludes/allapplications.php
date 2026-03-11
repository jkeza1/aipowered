
































<?php

/* -----------------------------
   AI DOCUMENT COMPARISON
------------------------------*/
if(isset($_POST['ai_compare'])){

    $imagePath = $_POST['image'];
    $type  = $_POST['type'];

    if(!file_exists($imagePath)){
        echo "<div class='alert alert-danger'>Document file not found at $imagePath</div>";
        exit();
    }

    // Map application types to the backend's expected types
    $typeMapping = [
        'National ID' => 'nationalid',
        'Criminal Record' => 'criminalrecord',
        'Driving License' => 'drivinglicense',
        'Driving Replacement' => 'drivinglicense',
        'Passport' => 'passport',
        'Marriage Certificate' => 'marriagecertificate',
        'Good Conduct' => 'goodconduct',
        'Provisional License' => 'drivinglicense'
    ];

    $expectedType = isset($typeMapping[$type]) ? $typeMapping[$type] : 'unknown';
    $expectedName = $_POST['expected_name'] ?? '';
    $expectedId = $_POST['expected_id'] ?? '';

    // Prepare the FastAPI verify request
    $url = "http://127.0.0.1:8001/verify";
    
    // Create CURLFile for multipart upload
    $cfile = new CURLFile(realpath($imagePath), mime_content_type($imagePath), basename($imagePath));
    
    $postData = [
        'file' => $cfile,
        'expected_type' => $expectedType,
        'expected_name' => $expectedName,
        'expected_id' => $expectedId
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_TIMEOUT => 300 // Increased timeout to 5 minutes for heavy ML processing
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "<div class='alert alert-danger'>Connection Error: $err</div>";
    } else {
        $result = json_decode($response, true);

        if (isset($result['success']) && $result['success']) {
            $isAuthentic = $result['is_authentic'];
            $statusClass = $isAuthentic ? 'text-success' : 'text-danger';
            $verdictIcon = $isAuthentic ? '' : '';
            
            echo "
            <div class='card shadow-sm border-0'>
                <div class='card-header bg-dark text-white d-flex justify-content-between align-items-center'>
                    <span class='fw-bold'>Forensic Analysis Report</span>
                    <span class='badge " . ($isAuthentic ? 'bg-success' : 'bg-danger') . "'>$verdictIcon Local AI Scan</span>
                </div>
                <div class='card-body p-4'>
                    <div class='text-center mb-4'>
                        <h2 class='$statusClass fw-bold mb-1'>Verdict: {$result['status']}</h2>
                        <p class='text-muted'>$verdictIcon Identity & Forgery Check Complete</p>
                    </div>

                    <div class='row g-4'>
                        <!-- Left Column: Credential Matching -->
                        <div class='col-md-6 border-end'>
                            <h6 class='text-uppercase fw-bold text-primary mb-3'><i class='fas fa-user-check me-2'></i>Identity Verification</h6>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    Person Match (Name)
                                    <span>" . ($result['ocr_forensics']['name_match_score'] >= 70 ? "<span class='text-success'>MATCH ({$result['ocr_forensics']['name_match_score']}%)</span>" : "<span class='text-danger'>MISMATCH</span>") . "</span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    National ID Match
                                    <span>" . ($result['ocr_forensics']['id_match'] ? "<span class='text-success'>MATCH</span>" : "<span class='text-danger'>NOT FOUND</span>") . "</span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    Document Type (Expected)
                                    <span class='text-dark fw-bold'>" . ucfirst($expectedType) . "</span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    Document Type (Detected)
                                    <span>" . ($result['ocr_forensics']['type_match'] ? "<span class='text-success'>" . ucfirst($result['ocr_forensics']['doc_type_detected']) . "</span>" : "<span class='text-danger'>WRONG TYPE</span>") . "</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Right Column: Forgery Analysis -->
                        <div class='col-md-6 px-4'>
                            <h6 class='text-uppercase fw-bold text-primary mb-3'><i class='fas fa-microscope me-2'></i>Forensic Integrity</h6>
                            <div class='progress mb-3' style='height: 25px;'>
                                <div class='progress-bar " . ($result['digital_integrity'] > 50 ? 'bg-success' : 'bg-danger') . "' 
                                     role='progressbar' style='width: {$result['digital_integrity']}%'>
                                     Digital Integrity: {$result['digital_integrity']}%
                                </div>
                            </div>
                            
                            <p class='small text-muted mb-2 fw-bold'>Tampering Heatmap (Grad-CAM):</p>
                            <div class='position-relative'>
                                <a href='{$result['heatmap_url']}' target='_blank'>
                                    <img src='{$result['heatmap_url']}' class='img-fluid border rounded shadow-sm' style='max-height:180px; width:100%; object-fit:cover;'>
                                    <div class='position-absolute bottom-0 end-0 bg-dark text-white p-1 small opacity-75'>Click to enlarge</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class='mt-4 p-3 bg-light rounded border-start border-4 " . ($isAuthentic ? 'border-success' : 'border-danger') . "'>
                        <strong> Summary:</strong> <span class='text-muted'>{$result['explanation']}</span>
                    </div>
                </div>
            </div>";
        } else {
            echo "<div class='alert alert-danger'>AI Backend Error: " . ($result['error'] ?? 'Unknown error') . "</div>";
        }
    }
    exit();
}

/* -----------------------------
   RESOLVE APPEAL
------------------------------*/
if(isset($_POST['resolve_appeal'])){
    $appeal_id = intval($_POST['appeal_id']);
    mysqli_query($conn, "UPDATE application_appeals SET status='Resolved' WHERE id=$appeal_id");
    
    // Determine the redirect URL based on current script
    $current_file = basename($_SERVER['PHP_SELF']);
    echo "<script>alert('Appeal marked as resolved.'); window.location.href='$current_file';</script>";
}

/* -----------------------------
   SAFE ID FUNCTION
------------------------------*/
function safe_id($type, $id){
    $cleanType = preg_replace('/[^a-zA-Z0-9]/', '', $type);
    return $cleanType . $id;
}

/* -----------------------------
   UPDATE STATUS
------------------------------*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['update_status'])){

    $app_id = intval($_POST['app_id']);
    $app_type = $_POST['app_type'];
    $new_status = $_POST['new_status'];
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    $table_map = [
        'Criminal Record' => 'applicationcriminalrecord',
        'Driving License' => 'applicationdrivinglicense',
        'Driving Replacement' => 'applicationdrivingreplacement',
        'Good Conduct' => 'applicationgoodconduct',
        'Marriage Certificate' => 'applicationmarriagecertificate',
        'National ID' => 'applicationnationalid',
        'Passport' => 'applicationpassport',
        'Passport Replacement' => 'applicationpassportreplacement',
        'Provisional License' => 'applicationprovisionallicense'
    ];

    if(array_key_exists($app_type, $table_map)){

        $table = $table_map[$app_type];

        // Fetch applicant details
        $res = mysqli_query($conn, "SELECT * FROM $table WHERE id=$app_id");
        $applicant = mysqli_fetch_assoc($res);

// Update status
mysqli_query($conn, "UPDATE $table SET status='$new_status', admin_reason='$reason' WHERE id=$app_id");

// =========================
// Send Email Notification
// =========================
require 'phpincludes/PHPMailer/src/PHPMailer.php';
require 'phpincludes/PHPMailer/src/SMTP.php';
require 'phpincludes/PHPMailer/src/Exception.php';

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kezjoana7@gmail.com';
    $mail->Password   = 'xddr fkbk swkt nikk'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->isHTML(true);
    $mail->setFrom('kezjoana7@gmail.com', 'Irembo AI-POWERED');

    // ✅ Validate email before sending
    if (!empty($applicant['email']) && filter_var($applicant['email'], FILTER_VALIDATE_EMAIL)) {
        $mail->addAddress($applicant['email']);
        $mail->Subject = "Irembo AI-POWERED: Your {$app_type} Application Status Updated";

        $mail->Body = "
            <p>Dear friend,</p>
            <p>Your <strong>{$app_type}</strong> application has been updated by the admin.</p>
            <p><strong>New Status:</strong> {$new_status}</p>
            <p><strong>Reason:</strong> {$reason}</p>
            <p><strong>National ID:</strong> {$applicant['national_id']}<br>
            <strong>Service:</strong> {$applicant['service_name']}</p>
            <p>If you have any questions, please contact support immediately.</p>
            <p>Thank you,<br>Irembo AI-POWERED Team</p>
        ";

        $mail->send();

        echo "<script>
        swal({
            title: 'Success!',
            text: 'Status updated and email sent to applicant.',
            icon: 'success',
            button: 'OK'
        });
        </script>";

    } else {
        echo "<script>
        swal({
            title: 'Status Updated!',
            text: 'Email not sent: invalid email address.',
            icon: 'warning',
            button: 'OK'
        });
        </script>";
    }

} catch (Exception $e) {
    echo "<script>
    swal({
        title: 'Status Updated!',
        text: 'Email could not be sent. Error: {$mail->ErrorInfo}',
        icon: 'warning',
        button: 'OK'
    });
    </script>";
}
    }
}


/* -----------------------------
   LOAD APPLICATIONS
------------------------------*/

// Fetch pending appeals
$activeAppeals = mysqli_query($conn, "SELECT * FROM application_appeals WHERE status != 'Resolved' ORDER BY created_at DESC");

$allApplications = mysqli_query($conn, "
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Criminal Record' as type, full_name, national_id
FROM applicationcriminalrecord
UNION ALL
SELECT id, service_name, application_date, status,
NULL,NULL,'Driving License', full_name, national_id
FROM applicationdrivinglicense
UNION ALL
SELECT id, service_name, application_date, status,
old_license_image, police_document,
'Driving Replacement', full_name, national_id
FROM applicationdrivingreplacement
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Good Conduct', full_name, national_id
FROM applicationgoodconduct
UNION ALL
SELECT id, service_name, application_date, status,
NULL,NULL,'Marriage Certificate', husband_full_name as full_name, husband_national_id as national_id
FROM applicationmarriagecertificate
UNION ALL
SELECT id, service_name, application_date, status,
old_id_image, police_document,
'National ID', full_name, national_id
FROM applicationnationalid
UNION ALL
SELECT id, service_name, application_date, status,
NULL,NULL,'Passport', full_name, national_id
FROM applicationpassport
UNION ALL
SELECT id, service_name, application_date, status,
NULL,NULL,'Passport Replacement', full_name, national_id
FROM applicationpassportreplacement
UNION ALL
SELECT id, service_name, application_date, status,
NULL,NULL,'Provisional License', full_name, national_id
FROM applicationprovisionallicense
ORDER BY application_date DESC
");
?>

<section class="p-4" style="margin-top:60px;">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>All Applications (Admin Panel)</h4>
    
    <!-- Appeal Reminders Dropdown -->
    <div class="dropdown">
        <button class="btn btn-warning dropdown-toggle position-relative fw-bold" type="button" data-bs-toggle="dropdown">
            <i class="fa fa-bell me-2"></i> Appeals
            <?php if(mysqli_num_rows($activeAppeals) > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= mysqli_num_rows($activeAppeals); ?>
                </span>
            <?php endif; ?>
        </button>
        <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0" style="width: 350px; max-height: 400px; overflow-y: auto; border-radius: 12px;">
            <h6 class="dropdown-header px-0 mb-2 border-bottom pb-2 text-dark fw-bold">Recent Citizen Appeals</h6>
            <?php if(mysqli_num_rows($activeAppeals) > 0): ?>
                <?php while($appeal = mysqli_fetch_assoc($activeAppeals)): ?>
                    <div class="appeal-item border-bottom mb-2 pb-2">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge bg-warning text-dark small"><?= $appeal['application_type']; ?> #<?= $appeal['application_id']; ?></span>
                            <small class="text-muted"><?= date('d M, H:i', strtotime($appeal['created_at'])); ?></small>
                        </div>
                        <p class="mb-1 small text-dark" style="line-height: 1.4;"><?= htmlspecialchars($appeal['message']); ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="small text-primary fw-semibold" style="font-size: 0.7rem;"><?= $appeal['citizen_email']; ?></span>
                            <!-- Use distinct links instead of buttons to prevent dropdown conflict -->
                            <div class="d-flex gap-2" onclick="event.stopPropagation();">
                                <button type="button" 
                                   class="btn btn-sm btn-info py-1 px-3 fw-bold text-white appeal-find-btn" 
                                   style="font-size: 0.7rem; border-radius: 4px; pointer-events: auto; position: relative; z-index: 10001;"
                                   data-app-id="<?= safe_id($appeal['application_type'], $appeal['application_id']); ?>">
                                    <i class="fa fa-search me-1"></i> FIND
                                </button>
                                <form method="POST" class="m-0" style="display:inline;" onclick="event.stopPropagation();">
                                    <input type="hidden" name="appeal_id" value="<?= $appeal['id']; ?>">
                                    <button type="submit" name="resolve_appeal" class="btn btn-sm btn-outline-success py-1 px-2 fw-bold" style="font-size: 0.7rem; border-radius: 4px; pointer-events: auto; position: relative; z-index: 10001;">DONE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php mysqli_data_seek($activeAppeals, 0); // Reset for possible future reuse ?>
            <?php else: ?>
                <div class="text-center py-3 text-muted small">No pending appeals found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if(mysqli_num_rows($allApplications) > 0): ?>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>ID</th>
<th>Type</th>
<th>Date</th>
<th>Status</th>
<th>Documents</th>
<th>Actions</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($allApplications)):
$status = strtolower($row['status']);
$formId = safe_id($row['type'], $row['id']);
?>
<tr id="app-<?= $formId; ?>">
<td><?= $row['id']; ?></td>
<td><?= $row['type']; ?></td>
<td><?= $row['application_date']; ?></td>
<td>
<?php
if($status=='pending') echo "<span class='text-warning fw-bold'>Pending</span>";
elseif($status=='approved') echo "<span class='text-success fw-bold'>Approved</span>";
elseif($status=='rejected') echo "<span class='text-danger fw-bold'>Rejected</span>";
elseif($status=='denied') echo "<span class='text-dark fw-bold'>Denied</span>";
?>
</td>
<td>
<?php
$folder = '';
switch($row['type']){
    case 'Criminal Record': $folder="criminalrecord/"; break;
    case 'Good Conduct': $folder="goodconduct/"; break;
    case 'Driving Replacement': $folder="drivingreplacement/"; break;
    case 'National ID': $folder="nationalid/"; break;
}
if($folder!="" && !empty($row['file1'])){
    $img=$folder.$row['file1'];
    echo "<a href='$img' target='_blank'><img src='$img' width='60' style='border:1px solid #ccc;border-radius:4px;padding:2px;'></a>";
}else echo "-";
?>
</td>
<td>
<div class="d-flex flex-row gap-2 align-items-center justify-content-start" style="min-width: 320px;">
    <?php if($folder!="" && !empty($row['file1']) && $status != 'approved'): ?>
    <!-- AI FORENSICS CARD (SIDE BY SIDE) -->
    <div class="ai-button-wrapper position-relative overflow-hidden shadow-sm flex-grow-1" 
         style="border-radius: 8px; cursor: pointer; transition: all 0.2s ease-in-out; border: 1px solid #e0e0e0; max-width: 160px; height: 45px; background: #fff;"
         onmouseover="this.style.borderColor='#0056b3'; this.style.backgroundColor='#f8fbff';"
         onmouseout="this.style.borderColor='#e0e0e0'; this.style.backgroundColor='#fff';"
         onclick="this.querySelector('.ai-btn').click()">
        <button class='ai-btn p-0 border-0 bg-transparent w-100 h-100 d-flex align-items-center justify-content-between px-3' 
                style="outline: none;"
                data-img='<?= $folder.$row['file1']; ?>' 
                data-type='<?= $row['type']; ?>'
                data-name='<?= htmlspecialchars($row['full_name']); ?>'
                data-id='<?= htmlspecialchars($row['national_id']); ?>'>
            <div class="text-start">
                <div style="color: #333; font-weight: 500; font-size: 0.75rem; line-height: 1.2;">AI Forensics</div>
                <div class="text-muted" style="font-size: 0.6rem;">Deep Analysis</div>
            </div>
            <div class="text-primary" style="font-size: 0.8rem;">
                
            </div>
        </button>
    </div>
    <?php elseif($status == 'approved'): ?>
    <!-- VERIFIED BADGE (SIDE BY SIDE) -->
    <div class="d-flex align-items-center justify-content-center p-2 rounded-3 border border-success-subtle bg-success-subtle shadow-sm flex-grow-1" 
         style="border-radius: 8px !important; border-left: 4px solid #198754 !important; max-width: 160px; height: 45px;">
        <div class="text-center">
            <div class="text-success fw-bold" style="font-size: 0.65rem; line-height: 1;"><i class="fas fa-shield-alt me-1"></i> OFFICIAL</div>
            <div class="text-success-emphasis" style="font-size: 0.55rem;">VERIFIED</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- REVIEW CASE CARD (SIDE BY SIDE) -->
    <div class="review-button-wrapper position-relative overflow-hidden shadow-sm flex-grow-1" 
         style="border-radius: 8px; cursor: pointer; transition: all 0.2s ease-in-out; border: 1px solid #e0e0e0; max-width: 160px; height: 45px; background: #fff;"
         onmouseover="this.style.borderColor='#333'; this.style.backgroundColor='#f9f9f9';"
         onmouseout="this.style.borderColor='#e0e0e0'; this.style.backgroundColor='#fff';"
         onclick="const btn = this.querySelector('.toggle-form-btn'); btn.click(); event.stopPropagation();">
        <button class="toggle-form-btn p-0 border-0 bg-transparent w-100 h-100 d-flex align-items-center justify-content-between px-3" 
                style="outline: none;"
                onclick="event.stopPropagation();"
                data-form-id="<?= $formId; ?>">
            <div class="text-start">
                <div style="color: #333; font-weight: 500; font-size: 0.75rem; line-height: 1.2;">Review Case</div>
                <div class="text-muted" style="font-size: 0.6rem;">Manual Audit</div>
            </div>
            <div class="text-dark" style="font-size: 0.8rem;">
                <i class="fa fa-eye"></i>
            </div>
        </button>
    </div>
</div>
</td>
</tr>

<tr class="review-form-row" id="form-<?= $formId; ?>" style="display:none;">
<td colspan="8">
<?php
$details = null;
$table_map = [
    'Criminal Record' => 'applicationcriminalrecord',
    'Driving License' => 'applicationdrivinglicense',
    'Driving Replacement' => 'applicationdrivingreplacement',
    'Good Conduct' => 'applicationgoodconduct',
    'Marriage Certificate' => 'applicationmarriagecertificate',
    'National ID' => 'applicationnationalid',
    'Passport' => 'applicationpassport',
    'Passport Replacement' => 'applicationpassportreplacement',
    'Provisional License' => 'applicationprovisionallicense'
];
if(isset($table_map[$row['type']])){
    $table = $table_map[$row['type']];
    $q = mysqli_query($conn,"SELECT * FROM $table WHERE id=".$row['id']);
    if(mysqli_num_rows($q)>0) $details = mysqli_fetch_assoc($q);
}
?>

<?php if($details): ?>
<div class="card mb-3">
<div class="card-header bg-light fw-bold">Application Details</div>
<div class="card-body">
<div class="row">
<?php foreach($details as $field=>$value): ?>
<?php if($field!='status' && $field!='admin_reason'): ?>
<div class="col-md-4">
<label class="fw-bold text-muted"><?= ucfirst(str_replace("_"," ",$field)); ?></label>
<div>
<?php
if(!empty($value) && preg_match('/\.(jpg|jpeg|png|gif)$/i',$value)){
    echo "<img src='$folder$value' width='120' class='img-thumbnail'>";
}else{
    echo htmlspecialchars($value);
}
?>
</div>
</div>
<?php endif; ?>
<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="app_id" value="<?= $row['id']; ?>">
<input type="hidden" name="app_type" value="<?= $row['type']; ?>">
<input type="hidden" name="new_status">
<div class="mb-3">
<label>Reason</label>
<textarea name="reason" class="form-control" required></textarea>
</div>
<button type="submit" name="update_status" class="btn btn-success" onclick="this.form.new_status.value='Approved'">Approve</button>
<button type="submit" name="update_status" class="btn btn-danger" onclick="this.form.new_status.value='Rejected'">Reject</button>
<button type="submit" name="update_status" class="btn btn-dark" onclick="this.form.new_status.value='Denied'">Deny</button>
<button type="button" class="btn btn-secondary close-form-btn">Close</button>
</form>

</td>
</tr>

<?php endwhile; ?>
</tbody>
</table>
<?php else: ?>
<p>No applications found.</p>
<?php endif; ?>
</section>

<!-- AI RESULT MODAL -->
<div class="modal fade" id="aiModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">AI Document Analysis</h5>
        <button type="button" class="btn-close" id="closeAiModal" aria-label="Close"> Close</button>
      </div>
      <div class="modal-body">
        <div id="aiResult">
          <center>
            <div class="spinner-border"></div>
            <p>Analyzing document...</p>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// REVIEW FORM TOGGLE
document.querySelectorAll('.toggle-form-btn').forEach(btn=>{
    btn.onclick = function(e){
        e.stopPropagation(); // Prevent card wrapper click conflict
        const targetId = 'form-' + this.dataset.formId;
        const targetRow = document.getElementById(targetId);
        
        // Check if the current row is already visible
        const isVisible = targetRow.style.display === 'table-row';
        
        // First, hide all open review rows to keep it clean
        document.querySelectorAll('.review-form-row').forEach(row => {
            row.style.display = 'none';
        });

        // If it wasn't visible before, show it now (Toggle behavior)
        if (!isVisible) {
            targetRow.style.display = 'table-row';
        }
    }
});

document.querySelectorAll('.close-form-btn').forEach(btn=>{
    btn.onclick = function(){
        const row = this.closest('.review-form-row');
        row.style.display = 'none';
        
        // Reset the corresponding button icon
        const btnId = row.id.replace('form-', '');
        const triggerBtn = document.querySelector(`[data-form-id="${btnId}"] i`);
        if(triggerBtn) {
            triggerBtn.classList.remove('fa-eye-slash');
            triggerBtn.classList.add('fa-eye');
        }
    }
});

// AI MODAL & BUTTONS
document.addEventListener("DOMContentLoaded", function(){
    const modalElement = document.getElementById("aiModal");
    const aiModal = new bootstrap.Modal(modalElement, {}); // single instance

    // close button
    document.getElementById("closeAiModal").onclick = function(){ aiModal.hide(); };

    // AI Compare buttons
    document.querySelectorAll('.ai-btn').forEach(btn=>{
        btn.onclick=function(){
            let img=this.dataset.img;
            let type=this.dataset.type;
            let name=this.dataset.name;
            let id=this.dataset.id;
            document.getElementById('aiResult').innerHTML="<center><div class='spinner-border'></div><p>Analyzing...</p></center>";
            aiModal.show();
            fetch("",{
                method:"POST",
                headers:{"Content-Type":"application/x-www-form-urlencoded"},
                body:"ai_compare=1&image="+encodeURIComponent(img)+"&type="+encodeURIComponent(type)+"&expected_name="+encodeURIComponent(name)+"&expected_id="+encodeURIComponent(id)
            }).then(res=>res.text()).then(data=>{
                document.getElementById('aiResult').innerHTML=data;
            });
        };
    });
});
</script>