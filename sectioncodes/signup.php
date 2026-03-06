<!-- Register Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="service-item-main pt-3  rounded">
                    <div class="p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="mb-1">Create IremboAccount</h4>
                            <p class="mb-0">Sign up with IremboAccount</p>
                            <small class="text-muted">
                                Please enter your details to continue
                            </small>
                        </div>

<form method="POST">

    <!-- Phone Field -->
    <div class="mb-3">
        <label class="form-label">Phone Number *</label>
        <input type="text"
               name="phone"
               class="form-control"
               placeholder="Enter phone number (+2507XXXXXXXX)"
               pattern="^\+2507[0-9]{8}$"
               value="+250"
               title="Phone must start with +2507 and contain 12 digits (example: +2507XXXXXXXX)"
               required>
    </div>

    <!-- Email Field -->
    <div class="mb-3">
        <label class="form-label">Email Address *</label>
        <input type="email"
               name="email"
               class="form-control"
               placeholder="Enter your email address"
               required>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label">Password *</label>
        <input type="password"
               name="password"
               class="form-control"
               placeholder="Create a password"
               required>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label class="form-label">Confirm Password *</label>
        <input type="password"
               name="confirm_password"
               class="form-control"
               placeholder="Confirm your password"
               required>
    </div>

    <div class="d-grid">
        <button type="submit" name="register" class="btn btn-primary">
            Create Account
        </button>
    </div>

</form>

                        <!-- Terms -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                By registering, you agree to our 
                                 <a href="terms.php">Terms of Use</a> and 
                                <a href="privacy.php">Privacy Policy</a>.
                            </small>
                        </div>

                        <!-- Login -->
                        <div class="text-center mt-3">
                            <small>
                                Already have an account? 
                                <a href="login.php"><strong>Log in</strong></a>
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