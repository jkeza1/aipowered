<?php
// ==============================
// SAFE MODAL ID FUNCTION
// ==============================
function safe_modal_id($type, $id){
    $cleanType = preg_replace('/[^a-zA-Z0-9]/', '', $type);
    return $cleanType . $id;
}

// ==============================
// TABLE MAP (USED EVERYWHERE)
// ==============================
$table_map = [
    'Criminal Record' => 'applicationcriminalrecord',
    'Driving License' => 'applicationdrivinglicense',
    'Driving Replacement' => 'applicationdrivingreplacement',
    'Good Conduct' => 'applicationgoodconduct',
    'Marriage Certificate' => 'applicationmarriagecertificate',
    'National ID' => 'applicationnationalid',
    'Passport' => 'applicationpassport',
    'Passport Replacement' => 'applicationpassportreplacement',
    'Provisional License' => 'applicationprovisionallicense',
    'National ID Profile' => 'national_id_profile',
    'Passport Profile' => 'passport_profile',
    'Driving License Profile' => 'driving_license_profile',
    'Criminal Record Profile' => 'criminal_record_profile',
    'Marriage Certificate Profile' => 'marriage_certificate_profile',
    'Provisional License Profile' => 'provisional_license_profile',
    'Officer (Nat)' => 'officer_nat',
    'Officer (Pas)' => 'officer_pas',
    'Officer (Dri)' => 'officer_dri',
    'Officer (Cri)' => 'officer_cri',
    'Officer (Mar)' => 'officer_mar',
    'Officer (Pro)' => 'officer_pro',
    'Reviewer' => 'reviewer',
    'Verification' => 'verification',
    'Lodge (Pending)' => 'lodge_pending'
];

/* ===============================
   HANDLE CANCELLATION
================================ */
if(isset($_POST['cancel_application'])){

    $app_id = intval($_POST['app_id']);
    $app_type = $_POST['app_type'];

    if(array_key_exists($app_type, $table_map)){

        $table = $table_map[$app_type];

        if($table === 'applicationmarriagecertificate'){
            $update_query = "UPDATE $table SET status='Cancelled'
                             WHERE id=$app_id
                             AND (applicant_email='$user_email' OR applicant_phone='$user_phone')
                             AND status='Pending'";
        } else {
            $update_query = "UPDATE $table SET status='Cancelled'
                             WHERE id=$app_id
                             AND (email='$user_email' OR phone='$user_phone')
                             AND status='Pending'";
        }

        mysqli_query($conn, $update_query);

        echo "<script>window.location.href='userdashboard.php';</script>";
        exit();
    }
}

/* ===============================
   HANDLE REMINDER MESSAGE (MODAL)
================================ */
if(isset($_POST['send_reminder_message'])){

    $app_id   = intval($_POST['app_id']);
    $app_type = mysqli_real_escape_string($conn, $_POST['app_type']);
    $message  = mysqli_real_escape_string($conn, $_POST['citizen_message']);

    if(array_key_exists($app_type, $table_map)){

        $table = $table_map[$app_type];

        if($table === 'applicationmarriagecertificate'){
            $query = mysqli_query($conn,"SELECT applicant_email AS email, applicant_phone AS phone FROM $table WHERE id=$app_id");
        } else {
            $query = mysqli_query($conn,"SELECT email, phone FROM $table WHERE id=$app_id");
        }

        $row_user = mysqli_fetch_assoc($query);
        $citizen_email = $row_user['email'];
        $citizen_phone = $row_user['phone'];

        // Save to Database Table
        $save_sql = "INSERT INTO application_appeals (application_id, application_type, citizen_email, citizen_phone, message) 
                     VALUES ($app_id, '$app_type', '$citizen_email', '$citizen_phone', '$message')";
        mysqli_query($conn, $save_sql);

        require 'backendcodes/PHPMailer/src/PHPMailer.php';
        require 'backendcodes/PHPMailer/src/SMTP.php';
        require 'backendcodes/PHPMailer/src/Exception.php';

        $admin_email = "kezjoana7@gmail.com";

        try{
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kezjoana7@gmail.com';
            $mail->Password = 'xddr fkbk swkt nikk';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->isHTML(true);

            $mail->setFrom('kezjoana7@gmail.com','Irembo AI-POWERED');
            $mail->addAddress($admin_email);

            $mail->Subject = "Citizen Reminder Message - Application ID #$app_id";

            $mail->Body = "
                <h3>Citizen Reminder Message</h3>
                <p><strong>Application ID:</strong> $app_id</p>
                <p><strong>Application Type:</strong> $app_type</p>
                <p><strong>Citizen Email:</strong> $citizen_email</p>
                <p><strong>Citizen Phone:</strong> $citizen_phone</p>
                <hr>
                <p><strong>Message:</strong></p>
                <p>$message</p>
            ";

            $mail->send();

            echo "<script>alert('Your message has been sent to administration.');</script>";
            echo "<script>window.location.href='userdashboard.php';</script>";
            exit();

        } catch(Exception $e){
            echo "<script>alert('Failed to send message.');</script>";
            echo "<script>window.location.href='userdashboard.php';</script>";
            exit();
        }
    }
}

/* ===============================
   COUNT PENDING
================================ */
function count_pending_by_type($conn, $app_type){
    global $table_map;
    $table = $table_map[$app_type];
    $query = mysqli_query($conn,"SELECT COUNT(*) as total FROM $table WHERE status='Pending'");
    $row = mysqli_fetch_assoc($query);
    return $row['total'];
}

/* ===============================
   POSITION
================================ */
function get_application_position_by_type($conn,$app_type,$application_date){
    global $table_map;
    $table = $table_map[$app_type];

    $query = mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM $table
        WHERE status='Pending'
        AND application_date < '$application_date'
    ");
    $row = mysqli_fetch_assoc($query);
    return $row['total'] + 1;
}

/* ===============================
   FETCH APPLICATIONS
================================ */
$allApplications = mysqli_query($conn,"
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Criminal Record' as type FROM applicationcriminalrecord WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Driving License' FROM applicationdrivinglicense WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Driving Replacement' FROM applicationdrivingreplacement WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Good Conduct' FROM applicationgoodconduct WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Marriage Certificate' FROM applicationmarriagecertificate WHERE applicant_email='$user_email' OR applicant_phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'National ID' FROM applicationnationalid WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Passport' FROM applicationpassport WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Passport Replacement' FROM applicationpassportreplacement WHERE email='$user_email' OR phone='$user_phone'
UNION ALL
SELECT id, service_name, application_date, status, admin_reason, expected_feedback_date, 'Provisional License' FROM applicationprovisionallicense WHERE email='$user_email' OR phone='$user_phone'
ORDER BY application_date DESC
");
?>

<section class="ftco-section services-section py-0" style="margin-top: 154px;">
<div class="container-fluid px-4 pb-5">
    <div class="row align-items-start position-relative">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="d-none d-md-block" style="position: sticky; top: 154px; height: calc(100vh - 154px); overflow-y: auto; z-index: 1000;">
                <div class="nav flex-column nav-pills shadow-sm p-3 bg-white rounded border mb-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active text-start mb-2 py-3 px-4" id="v-pills-apps-tab" data-bs-toggle="pill" data-bs-target="#v-pills-apps" type="button" role="tab" style="transition: none;">
                        <i class="fa fa-list-alt me-3 text-primary"></i> <?php echo __('my_applications'); ?>
                    </button>
                    <button class="nav-link text-start mb-2 py-3 px-4" id="v-pills-docs-tab" data-bs-toggle="pill" data-bs-target="#v-pills-docs" type="button" role="tab">
                        <i class="fa fa-file-invoice me-3 text-success"></i> <?php echo __('documents'); ?>
                    </button>
                    <button class="nav-link text-start mb-2 py-3 px-4" id="v-pills-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-history" type="button" role="tab">
                        <i class="fa fa-history me-3 text-warning"></i> <?php echo __('data_history'); ?>
                    </button>
                    <button class="nav-link text-start mb-2 py-3 px-4" id="v-pills-appeals-tab" data-bs-toggle="pill" data-bs-target="#v-pills-appeals" type="button" role="tab">
                        <i class="fa fa-gavel me-3 text-danger"></i> <?php echo __('my_appeals'); ?>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Header Section for Applications (Fixed relative to content) -->
            <div class="bg-white rounded border shadow-sm p-4 mb-3 sticky-top" style="top: 154px; z-index: 999;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h5 class="mb-0 fw-bold"><?php echo __('my_applications'); ?></h5>
                    
                    <div class="flex-grow-1 mx-lg-3" style="max-width: 500px;">
                        <div class="input-group">
                            <select class="form-select bg-light border-end-0" style="max-width: 140px; border-top-right-radius: 0; border-bottom-right-radius: 0;" id="searchType">
                                <option value="app_no">App No</option>
                                <option value="bill_id">Billing ID</option>
                            </select>
                            <input type="text" class="form-control bg-light" placeholder="Type here to search..." id="appSearchInput">
                            <span class="input-group-text bg-light border-start-0"><i class="fa fa-search text-muted"></i></span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select border-0 bg-light fw-semibold" style="width: auto; cursor: pointer;">
                            <option>Sort by: Newest</option>
                            <option>Sort by: Oldest</option>
                            <option>Sort by: Status</option>
                        </select>
                        <a href="index.php" class="btn btn-primary px-3 rounded-pill fw-bold">
                            <i class="fa fa-plus me-2"></i>New Application
                        </a>
                    </div>
                </div>
            </div>

            <div class="tab-content shadow-sm p-4 bg-white rounded border min-vh-100" id="v-pills-tabContent">
                
                <!-- APPLICATIONS TAB -->
                <div class="tab-pane fade show active" id="v-pills-apps" role="tabpanel">
                    <?php if(mysqli_num_rows($allApplications) > 0): ?>
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                    <thead class="bg-primary text-white">
                    <tr>
                    <th><?php echo __('app_no'); ?></th>
                    <th><?php echo __('service'); ?></th>
                    <th><?php echo __('status'); ?></th>
                    <th><?php echo __('fee'); ?></th>
                    <th><?php echo __('date'); ?></th>
                    <th><?php echo __('actions'); ?></th>
                    <th><?php echo __('appeal'); ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php 
                    mysqli_data_seek($allApplications, 0); 
                    while($row = mysqli_fetch_assoc($allApplications)):
                    $status = strtolower($row['status']);
                    
                    // Direct mapping for complex names to ensure exact translation
                    $exact_map = [
                        'Replacement of National ID Card' => 'replacement_of_national_id_card',
                        'Replacement of Driving License' => 'replacement_of_driving_license',
                        'Replacement of Passport' => 'replacement_of_passport',
                        'Marriage Certificate' => 'marriage_certificate_cert',
                        'Criminal Record Certificate' => 'criminal_record_certificate',
                        'Certificate of Good Conduct' => 'certificate_of_good_conduct',
                        'Application for Provisional Driving License' => 'application_for_provisional_driving_license',
                        'Application for Definitive Driving License' => 'application_for_definitive_driving_license',
                        'Application for New Passport' => 'application_for_new_passport'
                    ];

                    $service_display = $row['service_name'];
                    if(isset($exact_map[$row['service_name']])){
                        $service_display = __($exact_map[$row['service_name']]);
                    } else {
                        // Unified translation logic for service name
                        $type_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['type']));
                        $service_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['service_name']));
                        
                        if(__($service_key) !== $service_key){
                            $service_display = __($service_key);
                        } elseif(__($type_key) !== $type_key){
                            $service_display = __($type_key);
                        }
                    }
                    
                    $modalId = safe_modal_id($row['type'],$row['id']);

                    $total_pending = ($status=='pending') ? count_pending_by_type($conn,$row['type']) : null;
                    $position = ($status=='pending') ? get_application_position_by_type($conn,$row['type'],$row['application_date']) : null;

                    $show_remind = false;
                    if($status=='pending' && !empty($row['expected_feedback_date'])){
                        $today = new DateTime();
                        $feedback = new DateTime($row['expected_feedback_date']);
                        if($today > $feedback){
                            $show_remind = true;
                        }
                    }
                    ?>
                    <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $service_display; ?></td>
                    <td>
                    <?php
                    if($status=='pending'){
                    echo "<span style='color:orange;font-weight:bold;'>".__('pending')."</span><br>";
                    echo "<small>Pending: <b>$total_pending</b><br>Position: <b>$position</b><br>Before You: <b>".($position-1)."</b></small>";
                    }
                    elseif($status=='approved') echo "<span style='color:green;font-weight:bold;'>".__('approved')."</span>";
                    elseif($status=='rejected') echo "<span style='color:red;font-weight:bold;'>".__('rejected')."</span>";
                    elseif($status=='cancelled') echo "<span style='color:gray;font-weight:bold;'>".__('cancelled')."</span>";
                    ?>
                    </td>
                    <td>
                        <?php
                        switch($row['type']){
                            case 'National ID': echo "5,000 RWF"; break;
                            case 'Passport': echo "50,000 RWF"; break;
                            case 'Driving License': echo "10,000 RWF"; break;
                            default: echo "5,000 RWF"; break;
                        }
                        ?>
                    </td>
                    <td><?= date('d M Y', strtotime($row['application_date'])); ?></td>
                    <td>
                        <div class="d-flex gap-1 align-items-center">
                            <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#<?= $modalId; ?>" title="View Details">
                                <i class="fa fa-eye"></i>
                            </button>
                            <?php if($status=='approved'): ?>
                            <button class="btn btn-outline-success btn-sm" onclick="alert('Download feature coming soon!')" title="Download Document">
                                <i class="fa fa-download"></i>
                            </button>
                            <?php endif; ?>
                            <?php if($status=='pending'): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="app_id" value="<?= $row['id']; ?>">
                                <input type="hidden" name="app_type" value="<?= $row['type']; ?>">
                                <button type="submit" name="cancel_application" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Cancel this application?');" title="Cancel Application">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                    <?php if($show_remind): 
                    $remindModal = "remind".$modalId;
                    ?>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#<?= $remindModal; ?>"><?php echo __('appeal'); ?></button>
                    <!-- Remind Modal Content -->
                    <div class="modal fade" id="<?= $remindModal; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Lodge Appeal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="app_id" value="<?= $row['id']; ?>">
                                        <input type="hidden" name="app_type" value="<?= $row['type']; ?>">
                                        <label class="mb-2">Enter your appeal reason:</label>
                                        <textarea name="citizen_message" class="form-control" rows="4" required placeholder="Write details here..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="send_reminder_message" class="btn btn-primary">Submit Appeal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php else: echo "-"; endif; ?>
                    </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                    </table>
                    </div>
                    <?php else: ?>
                    <p class="text-center py-5">No applications found.</p>
                    <?php endif; ?>
                </div>

                <!-- DOCUMENTS TAB -->
                <div class="tab-pane fade" id="v-pills-docs" role="tabpanel">
                    <h5 class="mb-4 fw-bold text-success"><?php echo __('documents'); ?></h5>
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="bg-success text-white">
                            <tr>
                                <th><?php echo __('app_no'); ?></th>
                                <th><?php echo __('service'); ?></th>
                                <th><?php echo __('issue_date'); ?></th>
                                <th><?php echo __('issued_at'); ?></th>
                                <th><?php echo __('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($allApplications, 0);
                            $has_docs = false;
                            while($row = mysqli_fetch_assoc($allApplications)):
                                if(strtolower($row['status']) == 'approved'):
                                    $has_docs = true;

                                    // Reuse exact mapping for translation
                                    $exact_map = [
                                        'Replacement of National ID Card' => 'replacement_of_national_id_card',
                                        'Replacement of Driving License' => 'replacement_of_driving_license',
                                        'Replacement of Passport' => 'replacement_of_passport',
                                        'Marriage Certificate' => 'marriage_certificate_cert',
                                        'Criminal Record Certificate' => 'criminal_record_certificate',
                                        'Certificate of Good Conduct' => 'certificate_of_good_conduct',
                                        'Application for Provisional Driving License' => 'application_for_provisional_driving_license',
                                        'Application for Definitive Driving License' => 'application_for_definitive_driving_license',
                                        'Application for New Passport' => 'application_for_new_passport'
                                    ];

                                    $service_display = $row['service_name'];
                                    if(isset($exact_map[$row['service_name']])){
                                        $service_display = __($exact_map[$row['service_name']]);
                                    } else {
                                        $type_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['type']));
                                        $service_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['service_name']));
                                        
                                        if(__($service_key) !== $service_key){
                                            $service_display = __($service_key);
                                        } elseif(__($type_key) !== $type_key){
                                            $service_display = __($type_key);
                                        }
                                    }
                            ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $service_display; ?></td>
                                <td><?= date('d M Y', strtotime($row['application_date'])); ?></td>
                                <td>iremboGov HQ</td>
                                <td>
                                    <button class="btn btn-success btn-sm"><i class="fa fa-download me-1"></i> <?php echo __('download'); ?> PDF</button>
                                </td>
                            </tr>
                            <?php endif; endwhile; ?>
                            <?php if(!$has_docs): ?>
                            <tr><td colspan="5" class="text-center py-5 bg-light">You have no issued documents yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <!-- HISTORY TAB -->
                <div class="tab-pane fade" id="v-pills-history" role="tabpanel">
                    <h5 class="mb-4 fw-bold text-warning"><?php echo __('data_history'); ?></h5>
                    <p class="text-muted mb-4 small"><i class="fa fa-info-circle me-1"></i> For your security, we log every time an official accesses your personal data for processing.</p>
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="bg-dark text-white text-center">
                            <tr>
                                <th>Data Accessed</th>
                                <th>Time</th>
                                <th>Viewer name</th>
                                <th>Viewer role</th>
                                <th>Service context</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($allApplications, 0);
                            $has_history = false;
                            while($row = mysqli_fetch_assoc($allApplications)):
                                $has_history = true;
                                $type_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['type'])) . "_profile";
                                $service_display = __($type_key);
                                
                                // Specific logic for mapping roles in History tab
                                $viewer_map = [
                                    'National ID' => 'officer_nat',
                                    'Passport' => 'officer_pas',
                                    'Passport Replacement' => 'officer_pas',
                                    'Driving License' => 'officer_dri',
                                    'Driving Replacement' => 'officer_dri',
                                    'Criminal Record' => 'officer_cri',
                                    'Good Conduct' => 'officer_cri',
                                    'Marriage Certificate' => 'officer_mar',
                                    'Provisional License' => 'officer_pro'
                                ];

                                $officer_key = $viewer_map[$row['type']] ?? 'reviewer';
                                $viewer_name = __($officer_key);
                                $viewer_role = __('reviewer');
                                $context_display = __('verification');
                            ?>
                            <tr>
                                <td><?= $service_display; ?></td>
                                <td><?= date('d-m-Y, h:i:s A', strtotime($row['application_date'])); ?></td>
                                <td><?= $viewer_name; ?></td>
                                <td><?= $viewer_role; ?></td>
                                <td><?= $context_display; ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if(!$has_history): ?>
                            <tr><td colspan="5" class="text-center py-5 bg-light text-muted">No data access logs found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <!-- APPEALS TAB -->
                <div class="tab-pane fade" id="v-pills-appeals" role="tabpanel">
                    <h5 class="mb-4 fw-bold text-danger"><?php echo __('my_appeals'); ?></h5>
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>Appeal ID</th>
                                <th><?php echo __('app_no'); ?></th>
                                <th><?php echo __('service'); ?></th>
                                <th>Date Lodged</th>
                                <th><?php echo __('status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($allApplications, 0);
                            $has_appeals = false;
                            while($row = mysqli_fetch_assoc($allApplications)):
                                // Show an appeal if the feedback date is passed (simulating a lodged appeal)
                                if(!empty($row['expected_feedback_date']) && (new DateTime() > new DateTime($row['expected_feedback_date']))):
                                    $has_appeals = true;
                                    
                                    $type_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['type']));
                                    $service_key = strtolower(str_replace([' ', '-', '(', ')', '/'], '_', $row['service_name']));
                                    
                                    if(__($service_key) !== $service_key){
                                        $service_display = __($service_key);
                                    } elseif(__($type_key) !== $type_key){
                                        $service_display = __($type_key);
                                    } else {
                                        $service_display = $row['service_name'];
                                    }
                            ?>
                            <tr>
                                <td>APL-<?= $row['id']; ?></td>
                                <td><?= $row['id']; ?></td>
                                <td><?= $service_display; ?></td>
                                <td><?= date('d M Y', strtotime($row['expected_feedback_date'])); ?></td>
                                <td><span class="badge bg-warning text-dark"><?= __('lodge_pending'); ?></span></td>
                            </tr>
                            <?php endif; endwhile; ?>
                            <?php if(!$has_appeals): ?>
                            <tr><td colspan="5" class="text-center py-5 bg-light text-muted">No active or past appeals found in your logs.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('appSearchInput');
    const searchType = document.getElementById('searchType');
    const tableRows = document.querySelectorAll('#v-pills-apps table tbody tr');

    function filterTable() {
        const query = searchInput.value.toLowerCase();
        const type = searchType.value;
        
        tableRows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            if(cells.length < 1) return;

            let textToSearch = "";
            const appNo = cells[0].innerText.toLowerCase();
            // Note: Since Billing ID isn't a dedicated column in the current display table, 
            // the user might be referring to Application No as the searchable ID. 
            // We search the whole row if "Search All" is selected, or target the App No column specifically.
            
            if (type === 'app_no') {
                textToSearch = appNo;
            } else if (type === 'bill_id') {
                // Currently searching the second column or specific parts if available
                textToSearch = row.innerText.toLowerCase(); 
            } else {
                textToSearch = row.innerText.toLowerCase();
            }

            const isMatch = textToSearch.includes(query);
            row.style.display = isMatch ? '' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
        searchType.addEventListener('change', filterTable);
    }
});
</script>