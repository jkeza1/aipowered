<!-- Forgot Password Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="service-item-main pt-3  rounded">
                    <div class="p-4">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h4 class="mb-1"><?php echo __('reset_password'); ?></h4>
                            <small class="text-muted">
                                <?php echo __('please_enter_details'); ?>
                            </small>
                        </div>

<form action="" method="POST">

    <div class="mb-3">
         <label class="form-label"><?php echo __('email_address'); ?> *</label>
         <input type="email" name="email" class="form-control"
             placeholder="<?php echo __('enter_email_reset'); ?>" required>
    </div>

    <div class="d-grid">
        <button type="submit" name="resetpassword"
                class="btn btn-primary"><?php echo __('continue_btn'); ?></button>
    </div>

</form>

                        <!-- Back to Login -->
                        <div class="text-center mt-4">
                            <small>
                                <?php echo __('remember_password'); ?>
                                <a href="login.php"><strong><?php echo __('login'); ?></strong></a>
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Section End -->