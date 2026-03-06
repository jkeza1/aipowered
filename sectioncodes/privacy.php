<?php
$resultsysteminfo = mysqli_query($conn, "SELECT * FROM systeminfo ORDER BY id ASC LIMIT 1");
$row = mysqli_fetch_assoc($resultsysteminfo);
?>

<section class="ftco-section services-section">
<div class="container">
<div class="p-4">
<h5>Privacy policy</h5>
<p><?php echo nl2br($row['privacypolicy']); ?></p>
</div>
</div>
</section>