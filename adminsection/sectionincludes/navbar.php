<?php
$serviceTypeLabels = [
    'notarialact' => __('svc_notarial'),
    'bankstatement' => __('svc_bank'),
    'academictranscript' => __('svc_academic'),
    'administrative' => __('admin_service_administrative'),
    'businesslicense' => __('admin_service_business_license_short'),
    'medicalreport' => __('admin_service_medical_report_short'),
    'commercialbuilding' => __('admin_service_building_permit_short'),
    'employmentcontract' => __('svc_employment_contract'),
    'propertyownership' => __('admin_service_property_short'),
    'powerofattorney' => __('svc_power_attorney'),
    'courtjudgment' => __('svc_court_judgment'),
    'salarycertificate' => __('svc_salary'),
];
?>

<div class="sidebar shadow" id="sidebar" style="height:100vh; overflow-y: auto; background: #f8f9fa; border-right: 1px solid #dee2e6;">
    <div class="sidebar-header p-4 d-flex align-items-center justify-content-between" style="background: #0063CF;">
        <h5 class="text-white mb-0 fw-bold"><?php echo __('admin_panel'); ?></h5>
        <button class="btn btn-sm text-white border-0" onclick="toggleSidebar()">X</button>
    </div>
    
    <div class="p-3">
        <small class="text-uppercase text-muted fw-bold mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;"><?php echo __('admin_main_menu'); ?></small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark" style="transition: all 0.2s;">
                    <i class="fa fa-home me-3 text-primary" style="width: 20px;"></i> <?php echo __('admin_dashboard'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="systeminfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark">
                    <i class="fa fa-cog me-3 text-secondary" style="width: 20px;"></i> <?php echo __('admin_system_settings'); ?>
                </a>
            </li>
        </ul>

        <small class="text-uppercase text-muted fw-bold mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;"><?php echo __('admin_service_management'); ?></small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item"><a href="nationalidinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo __('svc_replace_nid'); ?></a></li>
            <li class="nav-item"><a href="drivinglicenseinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo __('svc_definitive'); ?></a></li>
            <li class="nav-item"><a href="passportinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo __('svc_passport'); ?></a></li>
            <li class="nav-item"><a href="marriagecertificateinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo __('svc_marriage'); ?></a></li>
            <li class="nav-item"><a href="criminalrecordinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo __('svc_criminal_record'); ?></a></li>
            <li class="nav-item"><a href="goodconductinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo __('svc_good_conduct'); ?></a></li>
            
            <li class="nav-item"><a href="servicemanagement.php?type=notarialact" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo $serviceTypeLabels['notarialact']; ?></a></li>
            <li class="nav-item"><a href="servicemanagement.php?type=bankstatement" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo $serviceTypeLabels['bankstatement']; ?></a></li>
            <li class="nav-item"><a href="servicemanagement.php?type=academictranscript" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><?php echo $serviceTypeLabels['academictranscript']; ?></a></li>
            
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark dropdown-toggle" href="#" data-toggle="collapse" data-target="#moreServicesMenu" aria-expanded="false">
                    <i class="fa fa-plus-circle me-3 text-secondary" style="width: 20px;"></i> <?php echo __('admin_more_services'); ?>
                </a>
                <div class="collapse" id="moreServicesMenu">
                    <ul class="nav flex-column ms-4 small">
                        <li><a href="servicemanagement.php?type=administrative" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['administrative']; ?></a></li>
                        <li><a href="servicemanagement.php?type=businesslicense" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['businesslicense']; ?></a></li>
                        <li><a href="servicemanagement.php?type=medicalreport" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['medicalreport']; ?></a></li>
                        <li><a href="servicemanagement.php?type=commercialbuilding" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['commercialbuilding']; ?></a></li>
                        <li><a href="servicemanagement.php?type=employmentcontract" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['employmentcontract']; ?></a></li>
                        <li><a href="servicemanagement.php?type=propertyownership" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['propertyownership']; ?></a></li>
                        <li><a href="servicemanagement.php?type=powerofattorney" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['powerofattorney']; ?></a></li>
                        <li><a href="servicemanagement.php?type=courtjudgment" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['courtjudgment']; ?></a></li>
                        <li><a href="servicemanagement.php?type=salarycertificate" class="nav-link py-1 text-dark"><?php echo $serviceTypeLabels['salarycertificate']; ?></a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <small class="text-uppercase text-muted fw-bold mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;"><?php echo __('admin_system_data'); ?></small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item"><a href="citizenregister.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-users me-3 text-dark" style="width: 20px;"></i> <?php echo __('admin_registry'); ?></a></li>
            <li class="nav-item"><a href="allapplications.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-list me-3 text-primary" style="width: 20px;"></i> <?php echo __('admin_applications'); ?></a></li>
        </ul>

        <div class="mt-5 border-top pt-3">
            <a href="phpincludes/logout.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-danger">
                <i class="fa fa-sign-out-alt me-3" style="width: 20px;"></i> <?php echo __('logout'); ?>
            </a>
        </div>
    </div>
</div>

<style>
.sidebar .nav-link:hover {
    background-color: #e9ecef;
    transform: translateX(5px);
}
.sidebar .nav-link {
    font-weight: 500;
    font-size: 0.9rem;
}
</style>

<button class="btn menu-toggle text-white d-flex align-items-center px-4 py-2 shadow" onclick="toggleSidebar()" style="background: #0063CF; border-radius: 0 25px 25px 0; position: fixed; left: 0; top: 20px; z-index: 1000;">
    <i class="fa fa-bars me-2"></i> 
</button>

<!-- Admin Language Selector (separate from citizen language) -->
<div class="position-fixed" style="top: 20px; right: 78px; z-index: 1050;">
    <?php
    $adminCurrentLang = $_SESSION['admin_lang'] ?? 'en';
    $adminBasePath = basename($_SERVER['PHP_SELF']);
    $adminQuery = $_GET;
    unset($adminQuery['admin_lang']);

    $adminQueryEn = $adminQuery;
    $adminQueryEn['admin_lang'] = 'en';
    $adminQueryRw = $adminQuery;
    $adminQueryRw['admin_lang'] = 'rw';
    $adminQueryFr = $adminQuery;
    $adminQueryFr['admin_lang'] = 'fr';

    $adminLangUrlEn = $adminBasePath . '?' . http_build_query($adminQueryEn);
    $adminLangUrlRw = $adminBasePath . '?' . http_build_query($adminQueryRw);
    $adminLangUrlFr = $adminBasePath . '?' . http_build_query($adminQueryFr);
    ?>
    <div class="dropdown">
        <button class="btn btn-light shadow-sm rounded-circle d-flex align-items-center justify-content-center position-relative"
                type="button"
                id="adminLangBtn"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                title="<?php echo __('language'); ?>"
                style="width: 45px; height: 45px; border: 1px solid #dee2e6;">
            <i class="fa fa-globe text-primary"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 p-0 mt-2" aria-labelledby="adminLangBtn" style="width: 210px; border-radius: 12px; overflow: hidden; right: 0; left: auto;">
            <div class="bg-primary p-2 text-white text-center small fw-bold"><?php echo __('language'); ?></div>
            <div class="p-2">
                <a class="dropdown-item rounded d-flex justify-content-between align-items-center py-2" href="<?= $adminLangUrlEn; ?>">
                    <?php echo __('english'); ?>
                    <?php if ($adminCurrentLang === 'en'): ?><i class="fa fa-check text-success"></i><?php endif; ?>
                </a>
                <a class="dropdown-item rounded d-flex justify-content-between align-items-center py-2" href="<?= $adminLangUrlRw; ?>">
                    <?php echo __('kinyarwanda'); ?>
                    <?php if ($adminCurrentLang === 'rw'): ?><i class="fa fa-check text-success"></i><?php endif; ?>
                </a>
                <a class="dropdown-item rounded d-flex justify-content-between align-items-center py-2" href="<?= $adminLangUrlFr; ?>">
                    <?php echo __('french'); ?>
                    <?php if ($adminCurrentLang === 'fr'): ?><i class="fa fa-check text-success"></i><?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Appeal Notification Button (Top Right) -->
<div class="position-fixed" style="top: 20px; right: 20px; z-index: 1050;">
    <?php
    // Fetch pending appeals count
    $appealResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM application_appeals WHERE status = 'Pending'");
    $appealData = mysqli_fetch_assoc($appealResult);
    $pendingAppeals = $appealData['count'] ?? 0;
    ?>
    <div class="dropdown">
        <button class="btn btn-light shadow-sm rounded-circle d-flex align-items-center justify-content-center position-relative" 
                type="button" id="appealNotifyBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                style="width: 45px; height: 45px; border: 1px solid #dee2e6;">
            <i class="fa fa-bell text-primary"></i>
            <?php if ($pendingAppeals > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark border border-white" style="font-size: 0.65rem;">
                    <?= $pendingAppeals ?>
                </span>
            <?php endif; ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 p-0 mt-2" aria-labelledby="appealNotifyBtn" style="width: 320px; border-radius: 12px; overflow: hidden; right: 0; left: auto;">
            <div class="bg-primary p-3 text-white">
                <h6 class="mb-0 fw-bold text-white"><i class="fa fa-exclamation-triangle me-2"></i> <?php echo __('admin_service_appeals'); ?></h6>
                <small class="opacity-75"><?php echo __('admin_recent_review_requests'); ?></small>
            </div>
            <div class="p-2" style="max-height: 350px; overflow-y: auto;">
                <?php
                $appealList = mysqli_query($conn, "SELECT * FROM application_appeals WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 5");
                if (mysqli_num_rows($appealList) > 0):
                    while ($appeal = mysqli_fetch_assoc($appealList)):
                        $appealTargetUrl = "allapplications.php?app_id=" . urlencode((string)$appeal['application_id']) . "&app_type=" . urlencode((string)$appeal['application_type']);
                ?>
                    <a href="<?= $appealTargetUrl; ?>" class="dropdown-item p-3 border-bottom rounded mb-1 bg-light-hover">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge bg-info-subtle text-info border border-info-subtle small"><?= $appeal['application_type'] ?></span>
                            <small class="text-muted" style="font-size: 0.7rem;"><?= date('d M', strtotime($appeal['created_at'])) ?></small>
                        </div>
                        <p class="mb-1 text-dark small text-truncate-2" style="line-height: 1.3; font-size: 0.8rem;">
                            <?= htmlspecialchars($appeal['message']) ?>
                        </p>
                        <small class="text-primary fw-semibold" style="font-size: 0.7rem;"><?php echo __('admin_citizen_id'); ?>: <?= $appeal['citizen_email'] ?></small>
                    </a>
                <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fa fa-check-circle fa-2x text-success mb-2 opacity-25"></i>
                        <p class="text-muted mb-0 small"><?php echo __('admin_no_pending_appeals'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <a href="allapplications.php" class="bg-light text-center py-2 d-block text-decoration-none small fw-bold text-primary border-top">
                <?php echo __('admin_view_all_applications'); ?>
            </a>
        </div>
    </div>
</div>

<style>
.bg-light-hover:hover { background-color: #f8f9fa; }
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
</style>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>
