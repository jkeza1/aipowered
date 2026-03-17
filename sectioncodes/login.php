<!-- Login Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="service-item-main pt-3   ">
                    <div class="p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="mb-1"><?php echo __('irembo_account'); ?></h4>
                            <p class="mb-0"><?php echo __('sign_in_with'); ?></p>
                            <small class="text-muted">
                                <?php echo __('please_enter_details'); ?>
                            </small>
                        </div>

                        <!-- Switch Buttons -->
                        <div class="d-flex justify-content-center mb-3">
                            <button type="button" class="btn btn-outline-primary me-2" onclick="showPhone()"><?php echo __('use_phone'); ?></button>
                            <button type="button" class="btn btn-outline-secondary" onclick="showEmail()"><?php echo __('use_email'); ?></button>
                        </div>

    <form method="POST">

    <!-- Phone Field -->
<div class="mb-3" id="phoneField">
    <label class="form-label"><?php echo __('phone_number'); ?></label>
    <input type="text" name="phone" class="form-control" placeholder="<?php echo __('enter_phone'); ?>"
        pattern="^\+2507[0-9]{8}$" value="+250" 
        title="Phone number must start with +2507 and contain 12 digits (example: +2507XXXXXXXX)">
</div>

<!-- Email Field -->
<div class="mb-3 d-none" id="emailField">
    <label class="form-label"><?php echo __('email_address'); ?></label>
    <input type="email" name="email" class="form-control rounded" placeholder="<?php echo __('enter_email'); ?>">
</div>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label"><?php echo __('password'); ?></label>
        <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo __('password'); ?>">
    </div>

    <div class="d-grid">
        <button type="submit" name="login" class="btn btn-primary rounded"><?php echo __('sign_in'); ?></button>
    </div>

</form>

                        <!-- Terms -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <?php echo __('login_agree'); ?>
                                <a href="terms.php"><?php echo __('terms_of_use'); ?></a> <?php echo __('and'); ?>
                                <a href="privacy.php"><?php echo __('privacy_policy'); ?></a>.
                            </small>
                        </div>

                        <!-- Register -->
                        <div class="text-center mt-3">
                            <small>
                                <?php echo __('no_account'); ?>
                                <a href="signup.php"><strong><?php echo __('create_account'); ?></strong></a>
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Login Section End -->

<script>
function showPhone() {
    const phoneInput = document.getElementById("phoneField").querySelector("input");
    const emailInput = document.getElementById("emailField").querySelector("input");

    document.getElementById("phoneField").classList.remove("d-none");
    document.getElementById("emailField").classList.add("d-none");

    // Enable phone input and disable email input
    phoneInput.disabled = false;
    phoneInput.required = true;

    emailInput.disabled = true;
    emailInput.required = false;
}

function showEmail() {
    const phoneInput = document.getElementById("phoneField").querySelector("input");
    const emailInput = document.getElementById("emailField").querySelector("input");

    document.getElementById("emailField").classList.remove("d-none");
    document.getElementById("phoneField").classList.add("d-none");

    // Enable email input and disable phone input
    emailInput.disabled = false;
    emailInput.required = true;

    phoneInput.disabled = true;
    phoneInput.required = false;
}

function togglePassword() {
    var pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}

// On page load, disable email by default
window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById("emailField").querySelector("input").disabled = true;
});
</script>6