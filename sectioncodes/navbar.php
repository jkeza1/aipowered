<?php
// Fetch logged-in user info
$user_info = [];
if(isset($_SESSION['user_id'])){
    $uid = intval($_SESSION['user_id']); 
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id=$uid LIMIT 1");
    if($res && mysqli_num_rows($res) > 0){
        $user_info = mysqli_fetch_assoc($res);
        // Ensure email is always available in session if logged in
        if(!isset($_SESSION['email'])) {
            $_SESSION['email'] = $user_info['email'];
        }
    } else {
        // Clear session if user not found
        unset($_SESSION['user_id']);
        session_destroy();
    }
}
?>
<div class="top-bar bg-warning text-dark p-4">
    <div class="container text-center ">
        <small class="fw-semibold ">
            <i class="fa fa-bell me-1 text-primary"></i> <b>New!</b> The fiscal year 2025/2026 has started. Pay for your family’s mutuelle coverage
        </small>
    </div>
</div>

<!-- Main Navbar -->

<nav class="navbar navbar-expand-lg navbar-light bg-info main-navbar p-2 fixed-top shadow-sm">
    <div class="container">
        <a href="index.php" class="navbar-brand d-flex align-items-center">
            <h4 class="m-0 text-white">iremboGov</h4>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php if(!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-white active"><?php echo __('home'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="signup.php" class="nav-link text-white">
                            <i class="fa fa-user-plus me-1"></i> <?php echo __('signup'); ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="login.php" class="nav-link text-white">
                            <i class="fa fa-sign-in-alt me-1"></i> <?php echo __('login'); ?>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Logged In State: Display Email Directly -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center fw-bold" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span><?php echo htmlspecialchars($_SESSION['email'] ?? $user_info['email'] ?? 'User'); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="accountDropdown">
                            <?php 
                            // Determine current page
                            $current_page = basename($_SERVER['PHP_SELF']);
                            
                            if($current_page == 'userdashboard.php'): ?>
                                <!-- Dashboard View: Show Home and Logout -->
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="index.php">
                                        <i class="fa fa-home me-2 text-primary"></i> <?php echo __('home'); ?>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="backendcodes/logout.php">
                                        <i class="fa fa-sign-out-alt me-2"></i> <?php echo __('logout'); ?>
                                    </a>
                                </li>
                            <?php else: ?>
                                <!-- Other Pages (Home/index.php): Show My Applications, Manage Account, Logout -->
                                <li><h6 class="dropdown-header border-bottom mb-2">My Account</h6></li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="userdashboard.php">
                                        <i class="fa fa-list-alt me-2 text-primary"></i> <?php echo __('my_applications'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">
                                        <i class="fa fa-user-cog me-2 text-secondary"></i> Manage My IremboAccount
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="backendcodes/logout.php">
                                        <i class="fa fa-sign-out-alt me-2"></i> <?php echo __('logout'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="fa fa-globe me-1"></i> <?php 
                        $current_lang = $_SESSION['lang'] ?? 'en';
                        if($current_lang == 'en') echo __('english');
                        elseif($current_lang == 'rw') echo __('kinyarwanda');
                        elseif($current_lang == 'fr') echo __('french');
                        else echo __('language'); 
                        ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if($current_lang !== 'en'): ?>
                        <li><a class="dropdown-item" href="?lang=en"><?php echo __('english'); ?></a></li>
                        <?php endif; ?>
                        <?php if($current_lang !== 'rw'): ?>
                        <li><a class="dropdown-item" href="?lang=rw"><?php echo __('kinyarwanda'); ?></a></li>
                        <?php endif; ?>
                        <?php if($current_lang !== 'fr'): ?>
                        <li><a class="dropdown-item" href="?lang=fr"><?php echo __('french'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Account Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="accountModalLabel">Update Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" readonly id="email" value="<?php echo $user_info['email'] ?? ''; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="text" class="form-control" name="phone" readonly id="phone" value="<?php echo $user_info['phone'] ?? ''; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="password" class="form-label">Password (leave blank to keep current)</label>
                  <input type="password" class="form-control" name="password" id="password">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?php
if(isset($_POST['update_profile'])){
    $user_id = $_SESSION['user_id'];
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $new_password = $_POST['password'];

    $update_sql = "UPDATE users SET email='$new_email', phone='$new_phone'";

    if(!empty($new_password)){
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql .= ", password='$hashed_password'";
    }

    $update_sql .= " WHERE id=$user_id";

    if(mysqli_query($conn, $update_sql)){
        $_SESSION['email'] = $new_email;
        $_SESSION['phone'] = $new_phone;
 echo "<script>swal('Profile updated successfully','Done!');</script>";

    } else {
         echo "<script>swal('Failed to update profile.','Failed!');</script>";
    }
}
?>