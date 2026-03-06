<?php

// Tables to check pending applications
$tables = [
    'applicationdrivinglicense' => 'Driving License',
    'applicationprovisionallicense' => 'Provisional Driving License',
    'applicationpassport' => 'Passport',
    'applicationmarriagecertificate' => 'Marriage Certificate',
    'applicationgoodconduct' => 'Good Conduct',
    'applicationcriminalrecord' => 'Criminal Record',
    'applicationnationalid' => 'National ID'
];

$pendingCounts = [];
foreach($tables as $table => $label) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table WHERE status='Pending'");
    $row = mysqli_fetch_assoc($result);
    $pendingCounts[$table] = $row['cnt'] ?? 0;
}

// Example: total pending across all tables
$totalPending = array_sum($pendingCounts);
?>

<div class="d-flex flex-column mb-4">

  <!-- Dashboard Header -->
  <div class="container py-4">
    <div class="row align-items-center mt-4">
      <div class="col-md-12 mt-4">
        <h3 class="mb-1">Dashboard</h3>
        <p class="text-muted mb-0">Welcome back! Here is the overview of your system.</p>
      </div>
    </div>
  </div>

  <!-- Dashboard Cards -->
  <div class="container flex-grow-1 d-flex align-items-center">
    <div class="row w-100 p-2 bg-light rounded">

      <!-- Pending Applications (Total) -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Total Pending Applications</h6>
            <h4 class="fw-bold"><?php echo $totalPending; ?></h4>
          </div>
        </div>
      </div>

      <!-- Driving License -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Driving License Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationdrivinglicense']; ?></h4>
          </div>
        </div>
      </div>

      <!-- Provisional Driving License -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Provisional License Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationprovisionallicense']; ?></h4>
          </div>
        </div>
      </div>

      <!-- Passport -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Passport Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationpassport']; ?></h4>
          </div>
        </div>
      </div>

      <!-- Marriage Certificate -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Marriage Certificate Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationmarriagecertificate']; ?></h4>
          </div>
        </div>
      </div>

      <!-- Good Conduct -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Good Conduct Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationgoodconduct']; ?></h4>
          </div>
        </div>
      </div>

      <!-- Criminal Record -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Criminal Record Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationcriminalrecord']; ?></h4>
          </div>
        </div>
      </div>

      <!-- National ID -->
      <div class="col-md-4 col-sm-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">National ID Pending</h6>
            <h4 class="fw-bold"><?php echo $pendingCounts['applicationnationalid']; ?></h4>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>