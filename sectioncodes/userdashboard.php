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
    'Provisional License' => 'applicationprovisionallicense'
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

<section class="ftco-section services-section">
<div class="container">
<div class="p-4">
<h5>Your Applications</h5>

<?php if(mysqli_num_rows($allApplications) > 0): ?>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Service Type</th>
<th>Service Name</th>
<th>Application Date</th>
<th>Status</th>
<th>Action</th>
<th>View</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($allApplications)):
$status = strtolower($row['status']);
$modalId = safe_modal_id($row['type'],$row['id']);

$total_pending = ($status=='pending') ? count_pending_by_type($conn,$row['type']) : null;
$position = ($status=='pending') ? get_application_position_by_type($conn,$row['type'],$row['application_date']) : null;

$show_remind = false;
if($status=='pending' && !empty($row['expected_feedback_date'])){
    $today = new DateTime();
    $feedback = new DateTime($row['expected_feedback_date']);
    $interval = $today->diff($feedback)->days;
    if($today > $feedback && $interval >=5){
        $show_remind = true;
    }
}
?>

<tr>
<td><?= $row['id']; ?></td>
<td><?= $row['type']; ?></td>
<td><?= $row['service_name']; ?></td>
<td><?= $row['application_date']; ?></td>

<td>
<?php
if($status=='pending'){
echo "<span style='color:orange;font-weight:bold;'>Pending</span><br>";
echo "<small>Pending: <b>$total_pending</b><br>Position: <b>$position</b><br>Before You: <b>".($position-1)."</b></small>";
}
elseif($status=='approved') echo "<span style='color:green;font-weight:bold;'>Approved</span>";
elseif($status=='rejected') echo "<span style='color:red;font-weight:bold;'>Rejected</span>";
elseif($status=='cancelled') echo "<span style='color:gray;font-weight:bold;'>Cancelled</span>";
?>
</td>

<td>
<?php if($status=='pending'): ?>

<form method="POST" style="display:inline;">
<input type="hidden" name="app_id" value="<?= $row['id']; ?>">
<input type="hidden" name="app_type" value="<?= $row['type']; ?>">
<button type="submit" name="cancel_application" class="btn btn-danger btn-sm"
onclick="return confirm('Cancel this application?');">Cancel</button>
</form>

<?php if($show_remind): 
$remindModal = "remind".$modalId;
?>

<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#<?= $remindModal; ?>">
Appear
</button>

<div class="modal fade" id="<?= $remindModal; ?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title">Send Reminder</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">

<input type="hidden" name="app_id" value="<?= $row['id']; ?>">
<input type="hidden" name="app_type" value="<?= $row['type']; ?>">

<textarea name="citizen_message" class="form-control" rows="4" required
placeholder="Write short message to administration..."></textarea>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="submit" name="send_reminder_message" class="btn btn-primary">Send</button>
</div>
</form>
</div>
</div>
</div>

<?php endif; endif; ?>
</td>

<td>
<button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#<?= $modalId; ?>">
View More
</button>
</td>

</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php else: ?>
<p>No applications found.</p>
<?php endif; ?>

</div>
</div>
</section>