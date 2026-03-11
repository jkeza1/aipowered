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
include 'sectionincludes/hero.php';
?>
<?php
include 'sectionincludes/loader.php';
?>
<?php
include 'sectionincludes/jslink.php';
?>
<script>
function scrollToApplication(appId) {
    const row = document.getElementById('form-' + appId);
    if (!row) {
        alert("Application #" + appId + " not found in this view.");
        return;
    }

    // Identify the main table row above this review row
    const mainRow = row.previousElementSibling;
    
    // Smooth scroll to the application
    mainRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
    
    // Highlight the row temporarily
    mainRow.style.backgroundColor = '#fff3cd'; 
    setTimeout(() => {
        mainRow.style.backgroundColor = '';
        // Automatically open the "Review Case" form
        const btn = mainRow.querySelector('.toggle-form-btn');
        if (btn) btn.click();
    }, 800);
}
</script>
</body>
</html>