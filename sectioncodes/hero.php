
    <!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div class="position-relative">

        <!-- Background Section -->
        <div class="d-flex align-items-center justify-content-center text-center bg-primary" style="min-height: 300px;">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        <!-- Welcome Text -->
                        <h1 class="text-white mb-4">
                            <?php echo __('hero_welcome'); ?>
                        </h1>

                        <!-- Search Input -->
                        <div class="position-relative mx-auto">
                            <input type="text"
                   id="serviceSearch"
                   class="form-control form-control-lg ps-5"
                   placeholder="<?php echo __('search_placeholder'); ?>">

                            <!-- Search Icon Inside -->
                            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
<p id="noResultMessage" class="text-white mt-3" style="display:none;">
            <?php echo __('no_service_found'); ?>
        </p>
                        <h4 class="p-4 text-white"><?php echo __('hero_subtitle'); ?></h4>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>