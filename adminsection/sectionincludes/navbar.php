
<div class="sidebar shadow" id="sidebar" style="height:100vh; overflow-y: auto; background: #f8f9fa; border-right: 1px solid #dee2e6;">
    <div class="sidebar-header p-4 d-flex align-items-center justify-content-between" style="background: #0063CF;">
        <h5 class="text-white mb-0 fw-bold">ADMIN PANEL</h5>
        <button class="btn btn-sm text-white border-0" onclick="toggleSidebar()">✕</button>
    </div>
    
    <div class="p-3">
        <small class="text-uppercase text-muted fw-bold mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Main Menu</small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark" style="transition: all 0.2s;">
                    <i class="fa fa-home me-3 text-primary" style="width: 20px;"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="systeminfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark">
                    <i class="fa fa-cog me-3 text-secondary" style="width: 20px;"></i> System Settings
                </a>
            </li>
        </ul>

        <small class="text-uppercase text-muted fw-bold mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Service Management</small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item"><a href="nationalidinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-address-card me-3 text-info" style="width: 20px;"></i> National Id</a></li>
            <li class="nav-item"><a href="drivinglicenseinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-id-card me-3 text-success" style="width: 20px;"></i> Driving License</a></li>
            <li class="nav-item"><a href="passportinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-passport me-3 text-primary" style="width: 20px;"></i> Passport</a></li>
            <li class="nav-item"><a href="marriagecertificateinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-ring me-3 text-warning" style="width: 20px;"></i> Marriage Cert.</a></li>
            <li class="nav-item"><a href="criminalrecordinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-file-invoice me-3 text-danger" style="width: 20px;"></i> Criminal Record</a></li>
            <li class="nav-item"><a href="goodconductinfo.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-check-circle me-3 text-success" style="width: 20px;"></i> Good Conduct</a></li>
            
            <li class="nav-item"><a href="servicemanagement.php?type=notarialact" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-stamp me-3 text-warning" style="width: 20px;"></i> Notarial Act</a></li>
            <li class="nav-item"><a href="servicemanagement.php?type=bankstatement" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-university me-3 text-primary" style="width: 20px;"></i> Bank Statement</a></li>
            <li class="nav-item"><a href="servicemanagement.php?type=academictranscript" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-graduation-cap me-3 text-info" style="width: 20px;"></i> Transcript</a></li>
            
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark dropdown-toggle" href="#" data-toggle="collapse" data-target="#moreServicesMenu" aria-expanded="false">
                    <i class="fa fa-plus-circle me-3 text-secondary" style="width: 20px;"></i> More Services
                </a>
                <div class="collapse" id="moreServicesMenu">
                    <ul class="nav flex-column ms-4 small">
                        <li><a href="servicemanagement.php?type=administrative" class="nav-link py-1 text-dark">Administrative</a></li>
                        <li><a href="servicemanagement.php?type=businesslicense" class="nav-link py-1 text-dark">Business Lic.</a></li>
                        <li><a href="servicemanagement.php?type=medicalreport" class="nav-link py-1 text-dark">Medical Rep.</a></li>
                        <li><a href="servicemanagement.php?type=commercialbuilding" class="nav-link py-1 text-dark">Bldg Permit</a></li>
                        <li><a href="servicemanagement.php?type=employmentcontract" class="nav-link py-1 text-dark">Employment</a></li>
                        <li><a href="servicemanagement.php?type=propertyownership" class="nav-link py-1 text-dark">Property</a></li>
                        <li><a href="servicemanagement.php?type=powerofattorney" class="nav-link py-1 text-dark">Power of Attorney</a></li>
                        <li><a href="servicemanagement.php?type=courtjudgment" class="nav-link py-1 text-dark">Court Judgment</a></li>
                        <li><a href="servicemanagement.php?type=salarycertificate" class="nav-link py-1 text-dark">Salary Certificate</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <small class="text-uppercase text-muted fw-bold mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">System Data</small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item"><a href="citizenregister.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-users me-3 text-dark" style="width: 20px;"></i> Registry</a></li>
            <li class="nav-item"><a href="allapplications.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-dark"><i class="fa fa-list me-3 text-primary" style="width: 20px;"></i> Applications</a></li>
        </ul>

        <div class="mt-5 border-top pt-3">
            <a href="phpincludes/logout.php" class="nav-link py-2 px-3 rounded d-flex align-items-center text-danger">
                <i class="fa fa-sign-out-alt me-3" style="width: 20px;"></i> Logout
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
    <i class="fa fa-bars me-2"></i> <?php echo $row['name'] ?? 'ADMIN MENU'; ?>
</button>

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
                <h6 class="mb-0 fw-bold text-white"><i class="fa fa-exclamation-triangle me-2"></i> Service Appeals</h6>
                <small class="opacity-75">Recent citizen requests for review</small>
            </div>
            <div class="p-2" style="max-height: 350px; overflow-y: auto;">
                <?php
                $appealList = mysqli_query($conn, "SELECT * FROM application_appeals WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 5");
                if (mysqli_num_rows($appealList) > 0):
                    while ($appeal = mysqli_fetch_assoc($appealList)):
                ?>
                    <a href="allapplications.php" class="dropdown-item p-3 border-bottom rounded mb-1 bg-light-hover">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge bg-info-subtle text-info border border-info-subtle small"><?= $appeal['application_type'] ?></span>
                            <small class="text-muted" style="font-size: 0.7rem;"><?= date('d M', strtotime($appeal['created_at'])) ?></small>
                        </div>
                        <p class="mb-1 text-dark small text-truncate-2" style="line-height: 1.3; font-size: 0.8rem;">
                            <?= htmlspecialchars($appeal['message']) ?>
                        </p>
                        <small class="text-primary fw-semibold" style="font-size: 0.7rem;">ID: <?= $appeal['citizen_email'] ?></small>
                    </a>
                <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fa fa-check-circle fa-2x text-success mb-2 opacity-25"></i>
                        <p class="text-muted mb-0 small">No pending appeals</p>
                    </div>
                <?php endif; ?>
            </div>
            <a href="allapplications.php" class="bg-light text-center py-2 d-block text-decoration-none small fw-bold text-primary border-top">
                View All Applications
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
