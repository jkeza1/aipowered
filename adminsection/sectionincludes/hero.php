<?php
// Tables grouped by category for a cleaner UI
$categories = [
    __('admin_cat_governance_id') => [
        'applicationnationalid' => ['label' => __('svc_replace_nid'), 'icon' => 'fa-address-card', 'color' => '#0063CF'],
        'applicationpassport' => ['label' => __('svc_passport'), 'icon' => 'fa-passport', 'color' => '#0063CF'],
        'applicationmarriagecertificate' => ['label' => __('svc_marriage'), 'icon' => 'fa-ring', 'color' => '#0063CF'],
    ],
    __('admin_cat_justice_safety') => [
        'applicationcriminalrecord' => ['label' => __('svc_criminal_record'), 'icon' => 'fa-file-invoice', 'color' => '#1cc88a'],
        'applicationgoodconduct' => ['label' => __('svc_good_conduct'), 'icon' => 'fa-user-check', 'color' => '#1cc88a'],
        'applicationcourtjudgment' => ['label' => __('svc_court_judgment'), 'icon' => 'fa-gavel', 'color' => '#1cc88a'],
    ],
    __('admin_cat_transport_licensing') => [
        'applicationdrivinglicense' => ['label' => __('svc_definitive'), 'icon' => 'fa-id-card', 'color' => '#f6c23e'],
        'applicationprovisionallicense' => ['label' => __('svc_provisional'), 'icon' => 'fa-car', 'color' => '#f6c23e'],
        'applicationbusinesslicense' => ['label' => __('business_license'), 'icon' => 'fa-briefcase', 'color' => '#f6c23e'],
    ],
    __('admin_cat_legal_financial') => [
        'applicationnotarialact' => ['label' => __('svc_notarial'), 'icon' => 'fa-stamp', 'color' => '#36b9cc'],
        'applicationbankstatement' => ['label' => __('svc_bank'), 'icon' => 'fa-university', 'color' => '#36b9cc'],
        'applicationpowerofattorney' => ['label' => __('svc_power_attorney'), 'icon' => 'fa-user-shield', 'color' => '#36b9cc'],
        'applicationpropertyownership' => ['label' => __('property_ownership'), 'icon' => 'fa-house-user', 'color' => '#36b9cc'],
    ],
    __('admin_cat_education_health') => [
        'applicationacademictranscript' => ['label' => __('svc_academic'), 'icon' => 'fa-graduation-cap', 'color' => '#4e73df'],
        'applicationmedicalreport' => ['label' => __('medical_report'), 'icon' => 'fa-notes-medical', 'color' => '#4e73df'],
        'applicationemploymentcontract' => ['label' => __('svc_employment_contract'), 'icon' => 'fa-file-contract', 'color' => '#4e73df'],
        'applicationsalarycertificate' => ['label' => __('svc_salary'), 'icon' => 'fa-money-check-alt', 'color' => '#4e73df'],
        'applicationadministrative' => ['label' => __('admin_service_administrative'), 'icon' => 'fa-folder-open', 'color' => '#4e73df'],
        'applicationcommercialbuilding' => ['label' => __('admin_service_building_permit'), 'icon' => 'fa-building', 'color' => '#4e73df'],
    ]
];

$pendingCounts = [];
$totalPending = 0;
foreach($categories as $cat => $services) {
    foreach($services as $table => $info) {
        $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if(mysqli_num_rows($tableCheck) > 0) {
            $result = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table WHERE status='Pending'");
            $row = mysqli_fetch_assoc($result);
            $count = $row['cnt'] ?? 0;
            $pendingCounts[$table] = $count;
            $totalPending += $count;
        } else {
            $pendingCounts[$table] = 0;
        }
    }
}

// Fetch active appeals specifically for a dash section
$activeAppeals = mysqli_query($conn, "SELECT * FROM application_appeals WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 6");
$appealCount = mysqli_num_rows($activeAppeals);
?>

<div class="container-fluid px-4" style="margin-top: 40px; background-color: #f8f9fc; min-height: 100vh; padding-bottom: 50px;">
    
    <!-- Hero Header -->
    <div class="row align-items-center mb-5 pt-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark" style="letter-spacing: -0.5px;">Dashboard <span class="text-primary">Overview</span></h2>
            <div class="badge bg-white shadow-sm text-primary px-3 py-2 border mt-2" style="border-radius: 12px; font-weight: 600;">
                <i class="fa fa-calendar-alt me-2"></i> <?= date('l, F d, Y'); ?>
            </div>
            <p class="text-muted mt-3 mb-0"><?php echo __('admin_manage_monitor_services'); ?></p>
        </div>
        <div class="col-md-4 text-md-end d-none d-md-block">
             <!-- Placeholder for potential future action button -->
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Main Service Status Column -->
        <div class="col-xl-8">
            <div class="row g-4">
                <!-- Summary Card -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background: linear-gradient(135deg, #0063CF 0%, #004da3 100%); color: white;">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h3 class="fw-bold mb-1"><?php echo __('admin_welcome_back'); ?></h3>
                                <p class="opacity-75 mb-4"><?php echo __('admin_pending_requires_verification'); ?>: <?= $totalPending; ?></p>
                                <a href="allapplications.php" class="btn btn-light text-primary fw-bold px-4 py-2" style="border-radius: 10px;"><?php echo __('admin_review_applications'); ?></a>
                            </div>
                            <div class="col-md-5 text-center d-none d-md-block">
                                <div class="display-1 fw-bold opacity-25" style="font-size: 5rem;"><?= $totalPending; ?></div>
                                <div class="text-uppercase small fw-bold tracking-wider"><?php echo __('admin_total_tasks'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorized Service Grid -->
                <?php foreach($categories as $categoryName => $services): ?>
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3 mt-2">
                        <hr class="flex-grow-1 opacity-10">
                        <span class="px-3 text-muted small fw-bold text-uppercase tracking-wider"><?= $categoryName; ?></span>
                        <hr class="flex-grow-1 opacity-10">
                    </div>
                    <div class="row g-3">
                        <?php foreach($services as $table => $info): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 border-0 shadow-sm service-card" style="border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box me-3 text-center" style="width: 45px; height: 45px; line-height: 45px; border-radius: 12px; background: <?= $info['color']; ?>15; color: <?= $info['color']; ?>;">
                                            <i class="fas <?= $info['icon']; ?> fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <div class="text-dark fw-bold text-truncate small mb-0"><?= $info['label']; ?></div>
                                            <div class="h5 mb-0 fw-bold <?= $pendingCounts[$table] > 0 ? 'text-primary' : 'text-muted opacity-50' ?>">
                                                <?= $pendingCounts[$table]; ?> <span class="small fw-normal text-muted" style="font-size: 0.7rem;"><?php echo __('pending'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Side: Appeals & Activity -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><?php echo __('admin_citizens_appeals'); ?></h5>
                        <?php if($appealCount > 0): ?>
                            <span class="badge bg-danger rounded-pill px-3 py-2"><?= $appealCount; ?> <?php echo __('admin_new'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body px-4">
                    <p class="text-muted small mb-4"><?php echo __('admin_latest_complaints'); ?></p>
                    
                    <?php if($appealCount > 0): ?>
                        <div class="appeal-timeline">
                            <?php while($appeal = mysqli_fetch_assoc($activeAppeals)): ?>
                                <div class="appeal-item d-flex mb-4">
                                    <div class="appeal-icon-line me-3">
                                        <div class="rounded-circle bg-warning p-1" style="width: 10px; height: 10px; margin-top: 5px;"></div>
                                        <div class="line" style="width: 2px; background: #eee; height: 100%; margin: 5px auto;"></div>
                                    </div>
                                    <div class="appeal-content flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold text-dark small"><?= $appeal['application_type']; ?> #<?= $appeal['application_id']; ?></div>
                                            <small class="text-muted"><?= date('H:i', strtotime($appeal['created_at'])); ?></small>
                                        </div>
                                        <p class="mb-2 text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            <?= htmlspecialchars($appeal['message']); ?>
                                        </p>
                                        <form method="POST" action="allapplications.php">
                                            <input type="hidden" name="appeal_id" value="<?= $appeal['id']; ?>">
                                            <button type="submit" name="resolve_appeal" class="btn btn-sm btn-outline-success border-0 px-0 fw-bold" style="font-size: 0.7rem;"><?php echo __('admin_mark_as_done'); ?> <i class="fa fa-check ms-1"></i></button>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="allapplications.php" class="text-primary small fw-bold text-decoration-none"><?php echo __('admin_view_all_records'); ?> <i class="fa fa-arrow-right ms-1"></i></a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted opacity-25">
                                <i class="fa fa-check-circle fa-4x"></i>
                            </div>
                            <p class="text-muted small"><?php echo __('admin_no_pending_clear'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.service-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
    cursor: pointer;
}
.tracking-wider { letter-spacing: 0.08em; }
.min-width-0 { min-width: 0; }
.appeal-timeline .appeal-item:last-child .line { display: none; }
</style>