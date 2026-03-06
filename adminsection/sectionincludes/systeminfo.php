<?php
$result = mysqli_query($conn, "SELECT * FROM systeminfo ORDER BY id ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center">System info</h3>

    <form method="POST" enctype="multipart/form-data">

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-6">

            <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">

            <div class="form-group">
                <label>System Name</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Enter system name"
                       value="<?php echo $row['name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Terms of use</label>
                <textarea name="termsofuse" class="form-control" rows="10"
                    placeholder="Terms of use"><?php echo $row['termsofuse'] ?? ''; ?></textarea>
            </div>

                        <div class="form-group">
                <label>Privacy policy</label>
                <textarea name="privacypolicy" class="form-control" rows="10"
                    placeholder="privacypolicy"><?php echo $row['privacypolicy'] ?? ''; ?></textarea>
            </div>

                                    <div class="form-group">
                <label>About system</label>
                <textarea name="aboutsystem" class="form-control" rows="10"
                    placeholder="aboutsystem"><?php echo $row['aboutsystem'] ?? ''; ?></textarea>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">

            <?php
            // Function to show small preview
            function imagePreview($row, $field){
                if(!empty($row[$field])){
                    echo '
                    <div class="mb-2">
                        <img src="aboutimages/'.$row[$field].'" 
                             style="width:100%; max-height:120px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                    </div>';
                }
            }

            $imageFields = [
                'icon' => 'Favicon / Icon',
                'logo' => 'Logo',
                'nationalid' => 'Sample (National Id)',
                'drivinglicense' => 'Sample (Driving License)',
                'passport' => 'Sample (Passport)',
                'marriagecertificate' => 'Sample (Marriage Certificate)',
                'goodconduct' => 'Sample (Good Conduct)',
                'provisionaldriving' => 'Sample (Provisional Driving)'
            ];

            foreach($imageFields as $field => $label){
                echo '<div class="form-group mb-4">
                        <label>Upload '.$label.'</label>
                        <input type="file" name="'.$field.'" class="form-control">
                    </div>';
            }
            ?>

        </div>
    </div>

    <button type="submit" name="saveupdateabout" class="btn btn-primary btn-block mt-3">
        Save info
    </button>

    </form>

    <!-- =========================
         IMAGE PREVIEW CARDS AT END
         ========================= -->
    <hr class="my-4">
    <h4 class="mb-3">Current Uploaded Images</h4>
    <div class="row">
        <?php
        foreach($imageFields as $field => $label){
            if(!empty($row[$field])){
                echo '<div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <img src="systemimages/'.$row[$field].'" class="card-img-top" style="height:150px; object-fit:cover;">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted">'.$label.'</small>
                            </div>
                        </div>
                      </div>';
            }
        }
        ?>
    </div>

</div>
</section>
