
































<?php
include 'service_mappings.php';

/* -----------------------------
   AI DOCUMENT COMPARISON
------------------------------*/
if(isset($_POST['ai_compare'])){

    $imagePath = $_POST['image'];
    $type  = $_POST['type'];

    // Possible absolute paths
    $workspaceRoot = realpath(__DIR__ . '/../../'); // /xampp/htdocs/aipowered/
    $adminsectionRoot = realpath(__DIR__ . '/../');  // /xampp/htdocs/aipowered/adminsection/
    
    // Normalize path by removing duplicate 'adminsection/' or 'salaryslip/' etc prefixes if they exist at the start of $imagePath
    // This handles cases where $folder already contains 'adminsection/' and $imagePath is passed with it again.
    $cleanImagePath = ltrim($imagePath, '/\\');
    
    $possiblePaths = [
        $cleanImagePath,
        $adminsectionRoot . '/' . $cleanImagePath,
        $workspaceRoot . '/' . $cleanImagePath,
        $workspaceRoot . '/adminsection/' . $cleanImagePath,
        // Also check if the path is already absolute (unlikely from POST but safe)
        $imagePath
    ];

    $foundPath = null;
    foreach($possiblePaths as $path){
        if(!empty($path) && file_exists($path)){
            $foundPath = realpath($path);
            break;
        }
    }

    if(!$foundPath){
        // Provide more debugging info if file not found
        echo "<div class='alert alert-danger font-monospace' style='font-size: 0.8rem;'>
                                <strong>" . __('admin_document_not_found') . "</strong><br>
                                " . __('admin_post_data') . ": " . htmlspecialchars($imagePath) . "<br>
                                " . __('admin_looked_in') . ":<br>
                - " . implode("<br>- ", $possiblePaths) . "
              </div>";
        exit();
    }
    $imagePath = $foundPath;

    $expectedType = isset($service_mappings[$type]) ? $service_mappings[$type]['ai_type'] : 'unknown';
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
        echo "<div class='alert alert-danger'>" . __('admin_connection_error') . ": $err</div>";
    } else {
        $result = json_decode($response, true);

        if (isset($result['success']) && $result['success']) {
            $isAuthentic = $result['is_authentic'];
            $statusClass = $isAuthentic ? 'text-success' : 'text-danger';
            $verdictIcon = $isAuthentic ? '' : '';
            
            echo "
            <div class='card shadow-sm border-0'>
                <div class='card-header bg-dark text-white d-flex justify-content-between align-items-center'>
                    <span class='fw-bold'>" . __('admin_forensic_analysis_report') . "</span>
                    <span class='badge " . ($isAuthentic ? 'bg-success' : 'bg-danger') . "'>$verdictIcon " . __('admin_local_ai_scan') . "</span>
                </div>
                <div class='card-body p-4'>
                    <div class='text-center mb-4'>
                        <h2 class='$statusClass fw-bold mb-1'>" . __('admin_verdict') . ": {$result['status']}</h2>
                        <p class='text-muted'>$verdictIcon " . __('admin_identity_forgery_check_complete') . "</p>
                    </div>

                    <div class='row g-4'>
                        <!-- Left Column: Credential Matching -->
                        <div class='col-md-6 border-end'>
                            <h6 class='text-uppercase fw-bold text-primary mb-3'><i class='fas fa-user-check me-2'></i>" . __('admin_identity_verification') . "</h6>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    " . __('admin_person_match_name') . "
                                    <span>" . ($result['ocr_forensics']['name_match_score'] >= 70 ? "<span class='text-success'>" . __('admin_match') . " ({$result['ocr_forensics']['name_match_score']}%)</span>" : "<span class='text-danger'>" . __('admin_mismatch') . "</span>") . "</span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    " . __('admin_national_id_match') . "
                                    <span>" . ($result['ocr_forensics']['id_match'] ? "<span class='text-success'>" . __('admin_match') . "</span>" : "<span class='text-danger'>" . __('admin_not_found') . "</span>") . "</span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    " . __('admin_document_type_expected') . "
                                    <span class='text-dark fw-bold'>" . ucfirst($expectedType) . "</span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-center px-0'>
                                    " . __('admin_document_type_detected') . "
                                    <span>" . ($result['ocr_forensics']['type_match'] ? "<span class='text-success'>" . ucfirst($result['ocr_forensics']['doc_type_detected']) . "</span>" : "<span class='text-danger'>" . __('admin_wrong_type') . "</span>") . "</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Right Column: Forgery Analysis -->
                        <div class='col-md-6 px-4'>
                            <h6 class='text-uppercase fw-bold text-primary mb-3'><i class='fas fa-microscope me-2'></i>" . __('admin_forensic_integrity') . "</h6>
                            <div class='progress mb-3' style='height: 25px;'>
                                <div class='progress-bar " . ($result['digital_integrity'] > 50 ? 'bg-success' : 'bg-danger') . "' 
                                     role='progressbar' style='width: {$result['digital_integrity']}%'>
                                     " . __('admin_digital_integrity') . ": {$result['digital_integrity']}%
                                </div>
                            </div>
                            
                            <p class='small text-muted mb-2 fw-bold'>" . __('admin_tampering_heatmap') . "</p>
                            <div class='position-relative'>
                                <a href='{$result['heatmap_url']}' target='_blank'>
                                    <img src='{$result['heatmap_url']}' class='img-fluid border rounded shadow-sm' style='max-height:180px; width:100%; object-fit:cover;'>
                                    <div class='position-absolute bottom-0 end-0 bg-dark text-white p-1 small opacity-75'>" . __('admin_click_to_enlarge') . "</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class='mt-4 p-3 bg-light rounded border-start border-4 " . ($isAuthentic ? 'border-success' : 'border-danger') . "'>
                        <strong>" . __('admin_summary') . ":</strong> <span class='text-muted'>{$result['explanation']}</span>
                    </div>
                </div>
            </div>";
        } else {
            echo "<div class='alert alert-danger'>" . __('admin_ai_backend_error') . ": " . ($result['error'] ?? __('admin_unknown_error')) . "</div>";
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
    echo "<script>alert('" . __('admin_appeal_marked_resolved') . "'); window.location.href='$current_file';</script>";
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

    if(array_key_exists($app_type, $service_mappings)){

        $table = $service_mappings[$app_type]['table'];

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
            title: '" . __('admin_success') . "',
            text: '" . __('admin_status_updated_email_sent') . "',
            icon: 'success',
            button: 'OK'
        });
        </script>";

    } else {
        echo "<script>
        swal({
            title: '" . __('admin_status_updated') . "',
            text: '" . __('admin_email_not_sent_invalid') . "',
            icon: 'warning',
            button: 'OK'
        });
        </script>";
    }

} catch (Exception $e) {
    echo "<script>
    swal({
        title: '" . __('admin_status_updated') . "',
        text: '" . __('admin_email_could_not_be_sent') . ": {$mail->ErrorInfo}',
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
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Notarial Act' as type, full_name, national_id
FROM applicationnotarialact
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Administrative Document' as type, full_name, national_id
FROM applicationadministrative
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Commercial Building Permit' as type, full_name, national_id
FROM applicationcommercialbuilding
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Academic Transcript' as type, full_name, national_id
FROM applicationacademictranscript
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Bank Statement' as type, full_name, national_id
FROM applicationbankstatement
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Business License' as type, full_name, national_id
FROM applicationbusinesslicense
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Medical Report' as type, full_name, national_id
FROM applicationmedicalreport
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Employment Contract' as type, full_name, national_id
FROM applicationemploymentcontract
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Property Ownership' as type, full_name, national_id
FROM applicationpropertyownership
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Power of Attorney' as type, full_name, national_id
FROM applicationpowerofattorney
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Court Judgment' as type, full_name, national_id
FROM applicationcourtjudgment
UNION ALL
SELECT id, service_name, application_date, status,
attachment as file1, NULL as file2,
'Salary Certificate' as type, full_name, national_id
FROM applicationsalarycertificate
ORDER BY application_date DESC
");
?>

<section class="p-4" style="margin-top:60px;">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><?php echo __('admin_all_applications_panel'); ?></h4>
    
</div>

<?php if(mysqli_num_rows($allApplications) > 0): ?>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo __('admin_id'); ?></th>
<th><?php echo __('admin_type'); ?></th>
<th><?php echo __('date'); ?></th>
<th><?php echo __('status'); ?></th>
<th><?php echo __('documents'); ?></th>
<th><?php echo __('actions'); ?></th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($allApplications)):
$status = strtolower($row['status']);
$formId = safe_id($row['type'], $row['id']);
?>
<tr id="app-<?= $formId; ?>" data-status="<?= htmlspecialchars($status); ?>">
<td><?= $row['id']; ?></td>
<td><?= $row['type']; ?></td>
<td><?= $row['application_date']; ?></td>
<td>
<?php
if($status=='pending') echo "<span class='text-warning fw-bold'>" . __('pending') . "</span>";
elseif($status=='approved') echo "<span class='text-success fw-bold'>" . __('approved') . "</span>";
elseif($status=='rejected') echo "<span class='text-danger fw-bold'>" . __('rejected') . "</span>";
elseif($status=='denied') echo "<span class='text-dark fw-bold'>" . __('admin_denied') . "</span>";
elseif($status=='cancelled') echo "<span class='text-dark fw-bold'>" . __('cancelled') . "</span>";
?>
</td>
<td>
<?php
$folder = isset($service_mappings[$row['type']]) ? $service_mappings[$row['type']]['folder'] : "";

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

                                            <?php
$status = strtolower($row['status']);
if($status!='cancelled')
{
?>
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

                <div style="color: #333; font-weight: 500; font-size: 0.75rem; line-height: 1.2;"><?php echo __('admin_ai_forensics'); ?></div>

                <div class="text-muted" style="font-size: 0.6rem;"><?php echo __('admin_deep_analysis'); ?></div>

            </div>

            <div class="text-primary" style="font-size: 0.8rem;">
                
            </div>
        </button>

  

    </div>
                                              <?php
}
                ?>
    <?php elseif($status == 'approved'): ?>
    <!-- VERIFIED BADGE (SIDE BY SIDE) -->
    <div class="d-flex align-items-center justify-content-center p-2 rounded-3 border border-success-subtle bg-success-subtle shadow-sm flex-grow-1" 
         style="border-radius: 8px !important; border-left: 4px solid #198754 !important; max-width: 160px; height: 45px;">
        <div class="text-center">
            <div class="text-success fw-bold" style="font-size: 0.65rem; line-height: 1;"><i class="fas fa-shield-alt me-1"></i> <?php echo __('admin_official'); ?></div>
            <div class="text-success-emphasis" style="font-size: 0.55rem;"><?php echo __('admin_verified'); ?></div>
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
                <div style="color: #333; font-weight: 500; font-size: 0.75rem; line-height: 1.2;"><?php echo __('admin_review_case'); ?></div>
                <div class="text-muted" style="font-size: 0.6rem;"><?php echo __('admin_manual_audit'); ?></div>
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
if(isset($service_mappings[$row['type']])){
    $table = $service_mappings[$row['type']]['table'];
    $q = mysqli_query($conn,"SELECT * FROM $table WHERE id=".$row['id']);
    if($q && mysqli_num_rows($q)>0) $details = mysqli_fetch_assoc($q);
}
?>

<?php if($details): ?>
<div class="card mb-3">
<div class="card-header bg-light fw-bold"><?php echo __('admin_application_details'); ?></div>
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

<?php
$status = strtolower($row['status']);
if($status!='cancelled')
{
?>
<form method="POST">
<input type="hidden" name="app_id" value="<?= $row['id']; ?>">
<input type="hidden" name="app_type" value="<?= $row['type']; ?>">
<input type="hidden" name="new_status">
<div class="mb-3">
<label><?php echo __('admin_reason'); ?></label>
<textarea name="reason" class="form-control" required></textarea>
</div>
<button type="submit" name="update_status" class="btn btn-success" onclick="this.form.new_status.value='Approved'"><?php echo __('admin_approve'); ?></button>
<button type="submit" name="update_status" class="btn btn-danger" onclick="this.form.new_status.value='Rejected'"><?php echo __('admin_reject'); ?></button>
<button type="submit" name="update_status" class="btn btn-dark" onclick="this.form.new_status.value='Denied'"><?php echo __('admin_deny'); ?></button>
<button type="button" class="btn btn-secondary close-form-btn"><?php echo __('close'); ?></button>
</form>
<?php
}
?>
</td>
</tr>

<?php endwhile; ?>
</tbody>
</table>
<?php else: ?>
<p><?php echo __('admin_no_applications_found'); ?></p>
<?php endif; ?>
</section>

<!-- AI RESULT MODAL -->
<div class="modal fade" id="aiModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo __('admin_ai_document_analysis'); ?></h5>
        <button type="button" class="btn-close" id="closeAiModal" aria-label="Close"> <?php echo __('close'); ?></button>
      </div>
      <div class="modal-body">
        <div id="aiResult">
          <center>
            <div class="spinner-border"></div>
            <p><?php echo __('admin_analyzing_document'); ?></p>
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
            document.getElementById('aiResult').innerHTML="<center><div class='spinner-border'></div><p><?php echo __('admin_analyzing'); ?>...</p></center>";
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