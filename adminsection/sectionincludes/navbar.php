
<div class="sidebar" id="sidebar"  style="height:100vh; overflow-y: scroll; ">
<div class="sidebar-header">
<a class="navbar-brand text-white" href="dashboard.php">|||</a>
<button class="close-btn " onclick="toggleSidebar()">✕</button>
</div>
<ul class="nav flex-column" >
<li class="nav-item"><a href="dashboard.php" class="nav-link active">Home</a></li>
<li class="nav-item"><a href="systeminfo.php" class="nav-link">System info</a></li>
<li class="nav-item"><a href="nationalidinfo.php" class="nav-link">National Id</a></li>
<li class="nav-item"><a href="drivinglicenseinfo.php" class="nav-link">Driving License</a></li>
<li class="nav-item"><a href="passportinfo.php" class="nav-link">Passport</a></li>
<li class="nav-item"><a href="marriagecertificateinfo.php" class="nav-link">Marriage Certificate</a></li>
<li class="nav-item"><a href="criminalrecordinfo.php" class="nav-link">Criminal Record</a></li>
<li class="nav-item"><a href="goodconductinfo.php" class="nav-link">Good Conduct</a></li>
<li class="nav-item"><a href="provisionaldrivinginfo.php" class="nav-link">Provisional Driving</a></li>
<li class="nav-item"><a href="citizenregister.php" class="nav-link">Citizen</a></li>
<li class="nav-item"><a href="allapplications.php" class="nav-link">Applications</a></li>
<li class="nav-item"><a href="phpincludes/logout.php" class="nav-link">Logout</a></li>
</ul>
</div>

<button class="btn menu-toggle text-white btn-primary" onclick="toggleSidebar()">☰ <?php echo $row['name'] ?? ''; ?></button>
<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>
