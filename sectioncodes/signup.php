<!-- Register Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="service-item-main pt-3  rounded">
                    <div class="p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="mb-1"><?php echo __('create_irembo_account'); ?></h4>
                            <p class="mb-0"><?php echo __('signup_with_irembo_account'); ?></p>
                            <small class="text-muted">
                                <?php echo __('please_enter_details'); ?>
                            </small>
                        </div>

<form method="POST">

    <!-- Full Name Field -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('full_name'); ?> *</label>
        <input type="text"
               name="full_name"
               class="form-control"
               placeholder="<?php echo __('enter_full_name'); ?>"
               required>
    </div>

    <!-- Gender Field -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('gender'); ?> *</label>
        <select name="gender" class="form-control" required>
            <option value=""><?php echo __('select_gender'); ?></option>
            <option value="Male"><?php echo __('male'); ?></option>
            <option value="Female"><?php echo __('female'); ?></option>
        </select>
    </div>

    <!-- Date of Birth Field -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('dob'); ?> *</label>
        <input type="date"
               name="dob"
               class="form-control"
               required>
    </div>

    <!-- National ID Field -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('national_id_long'); ?> *</label>
        <input type="text"
               name="national_id"
               class="form-control"
               placeholder="<?php echo __('enter_national_id'); ?>"
               pattern="[0-9]{16}"
               title="National ID must be exactly 16 digits"
               required>
    </div>

    <!-- Phone Field -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('phone_number'); ?> *</label>
        <input type="text"
               name="phone"
               class="form-control"
               placeholder="<?php echo __('enter_phone'); ?>"
               pattern="^\+2507[0-9]{8}$"
               value="+250"
               title="Phone must start with +2507 and contain 12 digits (example: +2507XXXXXXXX)"
               required>
    </div>

    <!-- Email Field -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('email_address'); ?> *</label>
        <input type="email"
               name="email"
               class="form-control"
               placeholder="<?php echo __('enter_email'); ?>"
               required>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('password'); ?> *</label>
        <input type="password"
               name="password"
               class="form-control"
               placeholder="<?php echo __('create_password'); ?>"
               required>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('confirm_password'); ?> *</label>
        <input type="password"
               name="confirm_password"
               class="form-control"
               placeholder="<?php echo __('confirm_your_password'); ?>"
               required>
    </div>

    <!-- Submit Button -->
    <div class="d-grid gap-2 mt-4">
        <button type="submit" name="register" class="btn btn-primary py-2 fw-bold">
            <?php echo __('register'); ?>
        </button>
    </div>

    <div class="text-center mt-3">
        <p class="mb-0">
            <?php echo __('already_have_account'); ?> 
            <a href="login.php" class="fw-bold"><?php echo __('login_here'); ?></a>
        </p>
    </div>

                        <!-- Terms -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <?php echo __('terms_agree'); ?> 
                                <a href="terms.php"><?php echo __('terms_of_use'); ?></a> <?php echo __('and'); ?> 
                                <a href="privacy.php"><?php echo __('privacy_policy'); ?></a>.
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Register Section End -->


<script>
function showPhone() {
    document.getElementById("phoneField").classList.remove("d-none");
    document.getElementById("emailField").classList.add("d-none");
}

function showEmail() {
    document.getElementById("emailField").classList.remove("d-none");
    document.getElementById("phoneField").classList.add("d-none");
}
</script>