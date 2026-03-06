<?php
$result = mysqli_query($conn, "SELECT * FROM systeminfo ORDER BY id ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);

$companyName = $row['name'] ?? 'IremboGov';
$aboutSystem = $row['aboutsystem'] ?? 'Government Service Platform';
$pageTitle = $companyName;
$description = $aboutSystem;
$baseUrl = "https://yourdomain.com"; // change to your real domain
?>

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- ================= SEO TITLE ================= -->
<title><?php echo $pageTitle; ?></title>

<!-- ================= BASIC SEO ================= -->
<meta name="description" content="<?php echo htmlspecialchars($description); ?>">
<meta name="keywords" content="online government services, digital services platform, public services portal, secure citizen services">
<meta name="author" content="<?php echo htmlspecialchars($companyName); ?>">
<meta name="robots" content="index, follow">
<meta name="language" content="English">

<!-- ================= CANONICAL ================= -->
<link rel="canonical" href="<?php echo $baseUrl; ?>/">

<!-- ================= FAVICON ================= -->
<link rel="icon" href="systemimages/<?php echo $row['icon'] ?? 'favicon.png'; ?>" type="image/png">

<!-- ================= OPEN GRAPH ================= -->
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
<meta property="og:image" content="<?php echo $baseUrl; ?>/systemimages/<?php echo $row['logo'] ?? 'logo.png'; ?>">
<meta property="og:url" content="<?php echo $baseUrl; ?>/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo htmlspecialchars($companyName); ?>">

<!-- ================= TWITTER ================= -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
<meta name="twitter:image" content="<?php echo $baseUrl; ?>/systemimages/<?php echo $row['logo'] ?? 'logo.png'; ?>">

<!-- ================= STRUCTURED DATA (GENERIC ORGANIZATION) ================= -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "<?php echo $companyName; ?>",
  "url": "<?php echo $baseUrl; ?>",
  "logo": "<?php echo $baseUrl; ?>/systemimages/<?php echo $row['logo'] ?? 'logo.png'; ?>"
}
</script>

<!-- ================= FONTS & CSS ================= -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<link rel="stylesheet" href="css/magnific-popup.css">
<link rel="stylesheet" href="css/bootstrap-datepicker.css">
<link rel="stylesheet" href="css/jquery.timepicker.css">
<link rel="stylesheet" href="css/flaticon.css">
<link rel="stylesheet" href="css/style.css">

<script src="js/sweetalert.js"></script>
</head>