<?php


/* ================================
   OPENAI CONFIG
================================ */
$apiKey = "YOUR_OPENAI_API_KEY";

/* ================================
   SAFE ID GENERATOR
================================ */
function safe_id($type, $id){
    $cleanType = preg_replace('/[^a-zA-Z0-9]/', '', $type);
    return $cleanType . $id;
}

/* ================================
   AI COMPARISON FUNCTION
================================ */
function compare_with_sample($userImagePath, $docType, $conn, $apiKey) {

    $docColumnMap = [
        'National ID' => 'nationalid',
        'Driving License' => 'drivinglicense',
        'Passport' => 'passport',
        'Marriage Certificate' => 'marriagecertificate',
        'Good Conduct' => 'goodconduct',
        'Provisional License' => 'provisionaldriving'
    ];

    if(!isset($docColumnMap[$docType])) {
        return "No official sample configured for this document type.";
    }

    $column = $docColumnMap[$docType];

    $sampleQuery = mysqli_query($conn, "SELECT $column FROM systeminfo LIMIT 1");
    if(mysqli_num_rows($sampleQuery) == 0){
        return "Official sample not found.";
    }

    $sampleRow = mysqli_fetch_assoc($sampleQuery);
    $sampleImagePath = $sampleRow[$column];

    if(empty($sampleImagePath) || !file_exists($sampleImagePath)){
        return "Official sample image missing.";
    }

    if(!file_exists($userImagePath)){
        return "User image not found.";
    }

    $userImageData = base64_encode(file_get_contents($userImagePath));
    $sampleImageData = base64_encode(file_get_contents($sampleImagePath));

    $prompt = "Compare the second image (user submitted document) with the first image (official government sample). 
    Check if layout, format, seals, fonts and structure match. 
    Detect differences, missing elements or possible tampering.
    Give a clear verification result.";

    $postData = [
        "model" => "gpt-4.1-mini",
        "messages" => [
            [
                "role" => "user",
                "content" => [
                    [
                        "type" => "input_image",
                        "image_data" => $sampleImageData
                    ],
                    [
                        "type" => "input_image",
                        "image_data" => $userImageData
                    ],
                    [
                        "type" => "text",
                        "text" => $prompt
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    return $result['choices'][0]['message']['content'] ?? "AI analysis unavailable.";
}

/* ================================
   HANDLE ADMIN ACTION
================================ */
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

        mysqli_query($conn,
            "UPDATE $table 
             SET status='$new_status', admin_reason='$reason' 
             WHERE id=$app_id");

        echo "<script>
        alert('Action saved successfully.');
        window.location.href='allapplications.php';
        </script>";
    }
}

/* ================================
   FETCH APPLICATIONS
================================ */
$allApplications = mysqli_query($conn, "
SELECT id, service_name, application_date, status,
old_id_image as file1,
'National ID' as type
FROM applicationnationalid
ORDER BY application_date DESC
");
?>


<section class="container mt-4">
<h4>All Applications (Admin Panel)</h4>

<?php if(mysqli_num_rows($allApplications) > 0): ?>
<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>Service</th>
    <th>Date</th>
    <th>Status</th>
    <th>Documents</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($allApplications)): 
$status = strtolower($row['status']);
$formId = safe_id($row['type'], $row['id']);
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['type']; ?></td>
<td><?php echo $row['service_name']; ?></td>
<td><?php echo $row['application_date']; ?></td>

<td>
<?php
if($status == 'pending') echo '<span class="text-warning fw-bold">Pending</span>';
elseif($status == 'approved') echo '<span class="text-success fw-bold">Approved</span>';
elseif($status == 'rejected') echo '<span class="text-danger fw-bold">Rejected</span>';
else echo $row['status'];
?>
</td>

<td>
<?php
$folder = "nationalid/";
if(!empty($row['file1'])){
    echo "<a href='{$folder}{$row['file1']}' target='_blank'>
            <img src='{$folder}{$row['file1']}' width='60'>
          </a>";
}
?>
</td>

<td>
<?php if($status == 'pending'): ?>
<button class="btn btn-primary btn-sm toggle-form-btn" data-form-id="<?php echo $formId; ?>">
Review
</button>
<?php endif; ?>
</td>
</tr>

<tr class="review-form-row" id="form-<?php echo $formId; ?>" style="display:none;">
<td colspan="7">

<?php
$analysis = "";
if(!empty($row['file1'])){
    $userImagePath = $folder . $row['file1'];
    $analysis = compare_with_sample($userImagePath, $row['type'], $conn, $apiKey);
}
?>

<div class="alert alert-info">
<strong>AI Document Comparison Result:</strong><br>
<?php echo nl2br(htmlspecialchars($analysis)); ?>
</div>

<form method="POST">
<input type="hidden" name="app_id" value="<?php echo $row['id']; ?>">
<input type="hidden" name="app_type" value="<?php echo $row['type']; ?>">
<input type="hidden" name="new_status">

<div class="mb-3">
<label>Reason</label>
<textarea name="reason" class="form-control" required></textarea>
</div>

<button type="submit" name="update_status" class="btn btn-success"
onclick="this.form.new_status.value='Approved';">Approve</button>

<button type="submit" name="update_status" class="btn btn-danger"
onclick="this.form.new_status.value='Rejected';">Reject</button>

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

<script>
document.querySelectorAll('.toggle-form-btn').forEach(btn => {
btn.addEventListener('click', function(){
const formId = 'form-' + this.dataset.formId;
document.querySelectorAll('.review-form-row').forEach(f => f.style.display = 'none');
document.getElementById(formId).style.display = 'table-row';
});
});
document.querySelectorAll('.close-form-btn').forEach(btn => {
btn.addEventListener('click', function(){
this.closest('.review-form-row').style.display = 'none';
});
});
</script>

