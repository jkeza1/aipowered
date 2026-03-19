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
$approvedCounts = [];
$declinedCounts = [];
$totalPending = 0;
$totalApproved = 0;
$totalDeclined = 0;
foreach($categories as $cat => $services) {
    foreach($services as $table => $info) {
        $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if(mysqli_num_rows($tableCheck) > 0) {
            $pendingResult = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table WHERE status='Pending'");
            $pendingRow = mysqli_fetch_assoc($pendingResult);
            $pendingCount = $pendingRow['cnt'] ?? 0;

            $approvedResult = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table WHERE status='Approved'");
            $approvedRow = mysqli_fetch_assoc($approvedResult);
            $approvedCount = $approvedRow['cnt'] ?? 0;

            $rejectedResult = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table WHERE status='Rejected'");
            $rejectedRow = mysqli_fetch_assoc($rejectedResult);
            $rejectedCount = $rejectedRow['cnt'] ?? 0;

            $deniedResult = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table WHERE status='Denied'");
            $deniedRow = mysqli_fetch_assoc($deniedResult);
            $deniedCount = $deniedRow['cnt'] ?? 0;

            $declinedCount = $rejectedCount + $deniedCount;

            $pendingCounts[$table] = $pendingCount;
            $approvedCounts[$table] = $approvedCount;
            $declinedCounts[$table] = $declinedCount;
            $totalPending += $pendingCount;
            $totalApproved += $approvedCount;
            $totalDeclined += $declinedCount;
        } else {
            $pendingCounts[$table] = 0;
            $approvedCounts[$table] = 0;
            $declinedCounts[$table] = 0;
        }
    }
}

$documentTypeCount = 0;
foreach ($categories as $services) {
    $documentTypeCount += count($services);
}

// Fetch active appeals specifically for a dash section
$activeAppeals = mysqli_query($conn, "SELECT * FROM application_appeals WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 6");
$appealCount = mysqli_num_rows($activeAppeals);
?>

<div class="container-fluid px-4 admin-dashboard-shell" style="margin-top: 36px; background-color: #f5f7fb; min-height: 100vh; padding-bottom: 56px;">

    <div class="row align-items-center mb-4 pt-3">
        <div class="col-lg-8">
            <h2 class="fw-bold text-dark mb-2" style="letter-spacing: -0.4px;">Dashboard <span class="text-primary">Overview</span></h2>
            <p class="text-muted mb-0"><?php echo __('admin_manage_monitor_services'); ?></p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <span class="badge bg-white text-primary px-3 py-2 border dashboard-date-badge">
                <i class="fa fa-calendar-alt me-2"></i> <?= date('l, F d, Y'); ?>
            </span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">

            <div class="card border-0 shadow-sm admin-welcome-card mb-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
                        <div>
                            <h3 class="fw-bold mb-2 text-dark">Welcome back, Admin</h3>
                            <p class="text-muted mb-0"><?php echo __('admin_pending_requires_verification'); ?></p>
                        </div>
                        <div class="metrics-grid">
                            <div class="metric-chip metric-primary">
                                <div class="metric-topline">
                                    <span class="metric-icon"><i class="fas fa-list-check"></i></span>
                                    <span class="metric-label"><?php echo __('admin_total_tasks'); ?></span>
                                </div>
                                <div class="metric-value"><?= $totalPending; ?></div>
                            </div>
                            <div class="metric-chip">
                                <div class="metric-topline">
                                    <span class="metric-icon"><i class="fas fa-folder-open"></i></span>
                                    <span class="metric-label">Document Types</span>
                                </div>
                                <div class="metric-value"><?= $documentTypeCount; ?></div>
                            </div>
                            <div class="metric-chip metric-danger-soft">
                                <div class="metric-topline">
                                    <span class="metric-icon"><i class="fas fa-bell"></i></span>
                                    <span class="metric-label"><?php echo __('admin_citizens_appeals'); ?></span>
                                </div>
                                <div class="metric-value"><?= $appealCount; ?></div>
                            </div>
                            <a href="allapplications.php?status=approved" class="metric-chip metric-success-soft metric-link" title="View approved documents">
                                <div class="metric-topline">
                                    <span class="metric-icon"><i class="fas fa-check-circle"></i></span>
                                    <span class="metric-label">Approved</span>
                                </div>
                                <div class="metric-value"><?= $totalApproved; ?></div>
                            </a>
                            <a href="allapplications.php?status=declined" class="metric-chip metric-warning-soft metric-link" title="View declined documents">
                                <div class="metric-topline">
                                    <span class="metric-icon"><i class="fas fa-times-circle"></i></span>
                                    <span class="metric-label">Declined</span>
                                </div>
                                <div class="metric-value"><?= $totalDeclined; ?></div>
                            </a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="allapplications.php" class="btn btn-primary px-4 py-2 fw-semibold admin-review-btn"><?php echo __('admin_review_applications'); ?></a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm admin-docs-card">
                <div class="card-header bg-white border-0 px-4 pt-4 pb-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="fw-bold mb-0 text-dark"><?php echo __('documents'); ?></h5>
                        <span class="small text-muted"><?php echo __('pending'); ?>: <strong class="text-dark"><?= $totalPending; ?></strong> | Approved: <a href="allapplications.php?status=approved" class="text-success text-decoration-none fw-semibold"><?= $totalApproved; ?></a> | Declined: <a href="allapplications.php?status=declined" class="text-danger text-decoration-none fw-semibold"><?= $totalDeclined; ?></a></span>
                    </div>
                </div>

                <div class="card-body px-3 px-md-4 pb-4">
                    <div class="row g-3">
                        <?php foreach($categories as $categoryName => $services): ?>
                        <div class="col-12">
                            <div class="category-block">
                                <div class="category-header d-flex justify-content-between align-items-center">
                                    <span class="category-title"><?= $categoryName; ?></span>
                                    <?php
                                    $catPending = 0;
                                    $catApproved = 0;
                                    $catDeclined = 0;
                                    foreach($services as $table => $info) {
                                        $catPending += (int)($pendingCounts[$table] ?? 0);
                                        $catApproved += (int)($approvedCounts[$table] ?? 0);
                                        $catDeclined += (int)($declinedCounts[$table] ?? 0);
                                    }
                                    ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-pill bg-light text-dark border"><?= $catPending; ?> <?php echo __('pending'); ?></span>
                                        <span class="badge rounded-pill bg-light text-dark border"><?= $catApproved; ?> Approved</span>
                                        <span class="badge rounded-pill bg-light text-dark border"><?= $catDeclined; ?> Declined</span>
                                    </div>
                                </div>

                                <div class="service-list">
                                    <?php foreach($services as $table => $info): ?>
                                    <div class="service-row">
                                        <div class="service-left">
                                            <span class="service-icon" style="background: <?= $info['color']; ?>16; color: <?= $info['color']; ?>;">
                                                <i class="fas <?= $info['icon']; ?>"></i>
                                            </span>
                                            <div>
                                                <div class="service-name"><?= $info['label']; ?></div>
                                                <div class="service-subtext"><?php echo __('documents'); ?></div>
                                            </div>
                                        </div>
                                        <div class="service-right">
                                            <span class="service-count <?= $pendingCounts[$table] > 0 ? 'has-pending' : ''; ?>"><?= (int)$pendingCounts[$table]; ?></span>
                                            <span class="service-pending-text"><?php echo __('pending'); ?></span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100 admin-appeals-card">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><?php echo __('admin_citizens_appeals'); ?></h5>
                        <?php if($appealCount > 0): ?>
                            <span class="badge bg-danger rounded-pill px-3 py-2"><?= $appealCount; ?> <?php echo __('admin_new'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body px-4 pt-3">
                    <p class="text-muted small mb-3"><?php echo __('admin_latest_complaints'); ?></p>

                    <?php if($appealCount > 0): ?>
                        <div class="appeal-list-modern">
                            <?php while($appeal = mysqli_fetch_assoc($activeAppeals)): ?>
                                <?php $appealTargetUrl = "allapplications.php?app_id=" . urlencode((string)$appeal['application_id']) . "&app_type=" . urlencode((string)$appeal['application_type']); ?>
                                <div class="appeal-card" onclick="window.location.href='<?= $appealTargetUrl; ?>'">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="appeal-app"><?= $appeal['application_type']; ?> #<?= $appeal['application_id']; ?></span>
                                        <small class="text-muted"><?= date('H:i', strtotime($appeal['created_at'])); ?></small>
                                    </div>
                                    <p class="appeal-msg mb-2"><?= htmlspecialchars($appeal['message']); ?></p>
                                    <form method="POST" action="allapplications.php">
                                        <input type="hidden" name="appeal_id" value="<?= $appeal['id']; ?>">
                                        <button type="submit" name="resolve_appeal" class="btn btn-sm btn-outline-success fw-semibold" onclick="event.stopPropagation();"><?php echo __('admin_mark_as_done'); ?></button>
                                    </form>
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
.admin-dashboard-shell {
    --ui-border: #e6ebf2;
    --ui-muted: #6b7280;
    --ui-ink: #0f172a;
}

.dashboard-date-badge {
    border-color: var(--ui-border) !important;
    border-radius: 12px;
    font-weight: 600;
}

.admin-welcome-card,
.admin-docs-card,
.admin-appeals-card {
    border-radius: 16px;
    border: 1px solid var(--ui-border);
}

.admin-welcome-card {
    background: #fff;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05) !important;
}

.metric-chip {
    display: block;
    min-width: 132px;
    background: #f8fafc;
    border: 1px solid var(--ui-border);
    border-radius: 12px;
    padding: 10px 12px;
    text-align: left;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(132px, 1fr));
    gap: 10px;
}

.metric-topline {
    display: flex;
    align-items: center;
    gap: 7px;
}

.metric-icon {
    width: 22px;
    height: 22px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    background: #e9f1ff;
    color: #0d6efd;
}

.metric-value {
    margin-top: 6px;
    font-size: 1.3rem;
    font-weight: 800;
    color: #111827;
    line-height: 1.1;
}

.metric-label {
    margin-top: 0;
    font-size: 0.68rem;
    color: var(--ui-muted);
    text-transform: uppercase;
    letter-spacing: 0.045em;
    font-weight: 700;
}

.metric-primary {
    background: linear-gradient(180deg, #f6faff 0%, #f3f8ff 100%);
}

.metric-primary .metric-icon {
    background: #dcebff;
}

.metric-danger-soft {
    background: linear-gradient(180deg, #fff8f8 0%, #fff4f4 100%);
}

.metric-danger-soft .metric-icon {
    background: #ffe9e9;
    color: #dc3545;
}

.metric-success-soft {
    background: linear-gradient(180deg, #f6fff8 0%, #f1fff5 100%);
}

.metric-success-soft .metric-icon {
    background: #dff8e7;
    color: #198754;
}

.metric-warning-soft {
    background: linear-gradient(180deg, #fff8f3 0%, #fff4ec 100%);
}

.metric-warning-soft .metric-icon {
    background: #ffe9d9;
    color: #dc3545;
}

.metric-link {
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.metric-link:hover {
    transform: translateY(-1px);
    border-color: #d4e8dd;
    box-shadow: 0 6px 14px rgba(25, 135, 84, 0.08);
}

@media (max-width: 1200px) {
    .metrics-grid {
        grid-template-columns: repeat(2, minmax(132px, 1fr));
    }
}

.admin-review-btn {
    border-radius: 10px;
}

.category-block {
    border: 1px solid var(--ui-border);
    border-radius: 14px;
    background: #fff;
    overflow: hidden;
}

.category-header {
    padding: 10px 14px;
    background: #f8fafc;
    border-bottom: 1px solid var(--ui-border);
}

.category-title {
    font-size: 0.78rem;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 700;
}

.service-list {
    padding: 6px 10px;
}

.service-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 9px 6px;
    border-bottom: 1px dashed #edf1f6;
}

.service-row:last-child {
    border-bottom: none;
}

.service-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

.service-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 34px;
}

.service-name {
    color: var(--ui-ink);
    font-weight: 700;
    font-size: 0.9rem;
    line-height: 1.2;
}

.service-subtext {
    color: var(--ui-muted);
    font-size: 0.72rem;
}

.service-right {
    text-align: right;
    min-width: 58px;
}

.service-count {
    display: inline-block;
    min-width: 28px;
    padding: 2px 8px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 0.8rem;
    color: #64748b;
    background: #eef2f7;
}

.service-count.has-pending {
    color: #0d6efd;
    background: #e8f1ff;
}

.service-pending-text {
    display: block;
    margin-top: 2px;
    font-size: 0.68rem;
    color: var(--ui-muted);
}

.appeal-list-modern {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.appeal-card {
    background: #fff;
    border: 1px solid var(--ui-border);
    border-radius: 12px;
    padding: 12px;
    cursor: pointer;
    transition: all .2s ease;
}

.appeal-card:hover {
    transform: translateY(-1px);
    border-color: #d7e2f0;
    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.05);
}

.appeal-app {
    font-size: 0.82rem;
    font-weight: 700;
    color: #111827;
}

.appeal-msg {
    font-size: 0.78rem;
    color: var(--ui-muted);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 768px) {
    .metrics-grid {
        grid-template-columns: 1fr;
    }

    .metric-chip {
        min-width: 100%;
        padding: 10px 12px;
    }

    .service-name {
        font-size: 0.86rem;
    }
}
</style>