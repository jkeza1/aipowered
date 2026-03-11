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
        alert("Application #" + appId + " is not currently visible on this list.");
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
</script>
</body>
</html>