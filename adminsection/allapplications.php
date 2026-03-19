<?php
include 'phpincludes/sessionstart.php';
?>
<?php
include 'phpincludes/sessioncheck.php';
?>
<?php
include 'phpincludes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'sectionincludes/navlink.php';
?>
<body>
<?php
include 'sectionincludes/navbar.php';
?>
<?php
include 'sectionincludes/allapplications.php';
?>
<?php
include 'sectionincludes/jslink.php';
?>
<script>
function toSafeFormId(appType, appId) {
    const cleanType = (appType || '').replace(/[^a-zA-Z0-9]/g, '');
    return cleanType + String(appId || '');
}

function getAppealTargetFromQuery() {
    const params = new URLSearchParams(window.location.search);
    const appId = params.get('app_id');
    const appType = params.get('app_type');
    if (!appId || !appType) return null;
    return toSafeFormId(appType, appId);
}

function getStatusFilterFromQuery() {
    const params = new URLSearchParams(window.location.search);
    const raw = (params.get('status') || '').trim().toLowerCase();
    const allowed = new Set(['pending', 'approved', 'rejected', 'denied', 'cancelled', 'declined']);
    return allowed.has(raw) ? raw : null;
}

function applyStatusFilter(statusFilter) {
    if (!statusFilter) return;

    const table = document.querySelector('table.table');
    if (!table) return;

    let visibleCount = 0;
    const mainRows = table.querySelectorAll('tbody > tr[id^="app-"]');

    mainRows.forEach((row) => {
        const rowStatus = (row.dataset.status || '').trim().toLowerCase();
        const isMatch = statusFilter === 'declined'
            ? (rowStatus === 'rejected' || rowStatus === 'denied')
            : rowStatus === statusFilter;

        row.style.display = isMatch ? '' : 'none';

        const detailRowId = 'form-' + row.id.replace('app-', '');
        const detailRow = document.getElementById(detailRowId);
        if (detailRow) {
            detailRow.style.display = 'none';
        }

        if (isMatch) visibleCount += 1;
    });

    const info = document.createElement('div');
    info.className = 'alert alert-success d-flex justify-content-between align-items-center';
    info.style.marginTop = '12px';
    const statusLabel = statusFilter === 'declined' ? 'declined (rejected + denied)' : statusFilter;
    info.innerHTML = `
        <span>Showing <strong>${visibleCount}</strong> ${statusLabel} application(s).</span>
        <a class="btn btn-sm btn-outline-secondary" href="allapplications.php">Clear filter</a>
    `;

    table.parentNode.insertBefore(info, table);
}

// Use Event Delegation to ensure clicks are captured even inside Bootstrap Dropdowns
document.addEventListener('click', function(e) {
    // Debug: console.log("Clicked element:", e.target);
    const findBtn = e.target.closest('.appeal-find-btn');
    if (findBtn) {
        // console.log("Find button detected");
        const appId = findBtn.getAttribute('data-app-id');
        
        // Stop default behaviors
        e.preventDefault();
        e.stopPropagation();
        
        // Target specifically for the dropdown to close (optional but helps reliability)
        const dropdown = findBtn.closest('.dropdown-menu');
        if (dropdown) {
            const toggle = dropdown.parentElement.querySelector('.dropdown-toggle');
            if (toggle && window.bootstrap && bootstrap.Dropdown) {
                const bDropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
                bDropdown.hide();
            }
        }
        
        // Execute the scroll
        scrollToApplication(appId);
        return false;
    }
});

function scrollToApplication(appId) {
    const mainRow = document.getElementById('app-' + appId);
    const detailRow = document.getElementById('form-' + appId);
    
    if (!mainRow) {
        alert("<?php echo __('admin_application_not_visible'); ?> #" + appId);
        return;
    }

    // 1. Close any other open review rows first
    document.querySelectorAll('.review-form-row').forEach(row => {
        if(row.id !== 'form-' + appId) row.style.display = 'none';
    });

    // 2. Smooth scroll to the main application row
    mainRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
    
    // 3. Visual highlight
    mainRow.style.transition = 'background-color 0.5s ease';
    mainRow.style.backgroundColor = '#fff3cd'; 
    
    setTimeout(() => {
        mainRow.style.backgroundColor = '';
        
        // 4. Open the review panel if it's closed
        if (detailRow && (detailRow.style.display === 'none' || detailRow.style.display === '')) {
            const btn = mainRow.querySelector('.toggle-form-btn');
            if (btn) {
                btn.click();
            } else {
                detailRow.style.display = 'table-row';
            }
        }
    }, 600);
}

document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = getStatusFilterFromQuery();
    applyStatusFilter(statusFilter);

    const target = getAppealTargetFromQuery();
    if (!target) return;

    // Slight delay ensures table rows are present and layout is stable.
    setTimeout(() => scrollToApplication(target), 150);
});
</script>
</body>
</html>