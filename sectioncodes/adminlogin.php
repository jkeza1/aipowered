

<!-- Login Section Start -->
<!-- Admin Login Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="service-item-main pt-3">
                    <div class="p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="mb-1">Admin Portal</h4>
                        </div>

                        <!-- ERROR MESSAGE -->
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php endif; ?>

                        <!-- FORM -->
                        <form method="POST">

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" 
                                       class="form-control rounded" 
                                       placeholder="Enter your email address" 
                                       required>
                            </div>

                            <!-- Password -->
                        <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" 
           id="password" 
           class="form-control" 
           placeholder="Enter password" 
           required>
</div>



                            <div class="d-grid">
                                <button type="submit" name="login" 
                                        class="btn btn-primary rounded">
                                    Sign In
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Admin Login Section End -->

<script>
function togglePassword() {
    var pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>