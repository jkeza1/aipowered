<?php
include 'backendcodes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'sectioncodes/navlink.php';
?>
<body>
<?php
include 'sectioncodes/loading.php';
?>
<?php
include 'sectioncodes/navbar.php';
?>
<?php
include 'sectioncodes/hero.php';
?>
<?php
include 'sectioncodes/services.php';
?>
<?php
include 'sectioncodes/footer.php';
?> 
<?php
include 'sectioncodes/backtop.php';
?>
<?php
include 'sectioncodes/footerlink.php';
?>
<script>
document.getElementById("serviceSearch").addEventListener("keyup", function() {

    let filter = this.value.toLowerCase();
    let services = document.querySelectorAll(".service-link");
    let categories = document.querySelectorAll(".service-category");
    let visibleCount = 0;

    services.forEach(function(service) {

        let text = service.textContent.toLowerCase();

        if (text.includes(filter)) {
            service.style.display = "";
            visibleCount++;
        } else {
            service.style.display = "none";
        }

    });

    // Hide empty categories
    categories.forEach(function(category) {

        let visibleServices = category.querySelectorAll(".service-link:not([style*='display: none'])");

        if (visibleServices.length === 0) {
            category.style.display = "none";
        } else {
            category.style.display = "";
        }

    });

    // Show No Result Message
    if (visibleCount === 0) {
        document.getElementById("noResultMessage").style.display = "block";
    } else {
        document.getElementById("noResultMessage").style.display = "none";
    }

});
</script>
</body>
</html>