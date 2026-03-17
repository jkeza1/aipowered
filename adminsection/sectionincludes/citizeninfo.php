<?php
// Suppress PHP errors from displaying
error_reporting(0);
ini_set('display_errors', 0);

// Handle form submission
if(isset($_POST['savecitizen'])) {

    $id = $_POST['id'] ?? '';

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $gender     = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth'] ?? '');
    $place_of_birth = mysqli_real_escape_string($conn, $_POST['place_of_birth'] ?? '');
    $phone      = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $email      = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $address    = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status'] ?? '');
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name'] ?? '');
    $mother_name = mysqli_real_escape_string($conn, $_POST['mother_name'] ?? '');
    
    // Optional fields
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id'] ?? '');
    $passport_number = !empty($_POST['passport_number']) ? mysqli_real_escape_string($conn, $_POST['passport_number']) : null;
    $provisional_driving_number = !empty($_POST['provisional_driving_number']) ? mysqli_real_escape_string($conn, $_POST['provisional_driving_number']) : null;
    $driving_license_number = !empty($_POST['driving_license_number']) ? mysqli_real_escape_string($conn, $_POST['driving_license_number']) : null;

    // Passport image upload
    $passport_image = $update_row['passport_image'] ?? null;
    if(isset($_FILES['passport_image']) && $_FILES['passport_image']['error'] == 0) {
        $target_dir = "passports/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $filename = time() . '_' . basename($_FILES["passport_image"]["name"]);
        $target_file = $target_dir . $filename;
        if(move_uploaded_file($_FILES["passport_image"]["tmp_name"], $target_file)) {
            $passport_image = $filename;
        }
    }

    // Check for duplicate passport_number (only if not null)
    if($passport_number) {
        if($id) {
            $check = @mysqli_query($conn, "SELECT * FROM citizensregistry WHERE passport_number='$passport_number' AND id != '$id'");
        } else {
            $check = @mysqli_query($conn, "SELECT * FROM citizensregistry WHERE passport_number='$passport_number'");
        }

        if($check && mysqli_num_rows($check) > 0) {
            echo "<script>
                swal({
                    title: '" . __('admin_duplicate') . "',
                    text: '" . __('admin_passport_exists') . "',
                    icon: 'warning',
                    button: 'OK'
                }).then(() => { window.location.href = ''; });
            </script>";
            exit;
        }
    }

    // Prepare SQL
    if($id) {
        // Update
        $sql = "UPDATE citizensregistry SET
                    first_name='$first_name',
                    last_name='$last_name',
                    gender='$gender',
                    date_of_birth='$date_of_birth',
                    place_of_birth='$place_of_birth',
                    phone='$phone',
                    email='$email',
                    address='$address',
                    marital_status='$marital_status',
                    father_name='$father_name',
                    mother_name='$mother_name',
                    national_id='$national_id',
                    passport_number=".($passport_number ? "'$passport_number'" : "NULL").",
                    provisional_driving_number=".($provisional_driving_number ? "'$provisional_driving_number'" : "NULL").",
                    driving_license_number=".($driving_license_number ? "'$driving_license_number'" : "NULL").",
                    passport_image=".($passport_image ? "'$passport_image'" : "NULL")."
                 WHERE id='$id'";
    } else {
        // Insert
        $sql = "INSERT INTO citizensregistry
                (first_name, last_name, gender, date_of_birth, place_of_birth, phone, email, address, marital_status, father_name, mother_name, national_id, passport_number, provisional_driving_number, driving_license_number, passport_image)
                VALUES
                ('$first_name','$last_name','$gender','$date_of_birth','$place_of_birth','$phone','$email','$address','$marital_status','$father_name','$mother_name','$national_id',
                ".($passport_number ? "'$passport_number'" : "NULL").",
                ".($provisional_driving_number ? "'$provisional_driving_number'" : "NULL").",
                ".($driving_license_number ? "'$driving_license_number'" : "NULL").",
                ".($passport_image ? "'$passport_image'" : "NULL").")";
    }

    // Execute query safely
    if(@mysqli_query($conn, $sql)) {
        echo "<script>
            swal({
                title: '" . __('admin_saved') . "',
                text: '" . __('admin_citizen_saved') . "',
                icon: 'success',
                button: 'OK'
            }).then(() => { window.location.href = ''; });
        </script>";
    } else {
        echo "<script>
            swal({
                title: '" . __('admin_failed') . "',
                text: '" . __('admin_citizen_not_saved') . "',
                icon: 'warning',
                button: 'OK'
            }).then(() => { window.location.href = ''; });
        </script>";
    }
}

// Load citizen if edit
$update_row = null;
if(isset($_GET['edit_id'])) {
    $edit_id = (int)($_GET['edit_id'] ?? 0);
    $res = @mysqli_query($conn, "SELECT * FROM citizensregistry WHERE id=$edit_id LIMIT 1");
    $update_row = $res ? mysqli_fetch_assoc($res) : null;
}

// Load all citizens
$all_citizens = @mysqli_query($conn, "SELECT * FROM citizensregistry ORDER BY created_at DESC");
?>

<section class="ftco-section services-section">
<div class="container">
    <h3 class="mb-4 text-center"><?php echo __('admin_register_update_citizen'); ?></h3>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $update_row['id'] ?? ''; ?>">

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                          <label><?php echo __('admin_first_name'); ?></label>
                          <input type="text" name="first_name" class="form-control" placeholder="<?php echo __('admin_enter_first_name'); ?>" required
                           value="<?php echo $update_row['first_name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_last_name'); ?></label>
                          <input type="text" name="last_name" class="form-control" placeholder="<?php echo __('admin_enter_last_name'); ?>" required
                           value="<?php echo $update_row['last_name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('gender'); ?></label>
                    <select name="gender" class="form-control" required>
                           <option value=""><?php echo __('select_gender'); ?></option>
                           <option value="Male" <?php if(($update_row['gender'] ?? '')=='Male') echo 'selected'; ?>><?php echo __('male'); ?></option>
                           <option value="Female" <?php if(($update_row['gender'] ?? '')=='Female') echo 'selected'; ?>><?php echo __('female'); ?></option>
                           <option value="Other" <?php if(($update_row['gender'] ?? '')=='Other') echo 'selected'; ?>><?php echo __('admin_other'); ?></option>
                    </select>
                </div>
                <div class="form-group">
                          <label><?php echo __('dob'); ?></label>
                    <input type="date" name="date_of_birth" class="form-control" required
                           value="<?php echo $update_row['date_of_birth'] ?? ''; ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_place_of_birth'); ?></label>
                    <input type="text" name="place_of_birth" class="form-control"
                              value="<?php echo $update_row['place_of_birth'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_birth_place'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_national_id'); ?></label>
                    <input type="text" name="national_id" class="form-control"
                              value="<?php echo $update_row['national_id'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_nid_if_any'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_passport_number'); ?></label>
                    <input type="text" name="passport_number" class="form-control"
                              value="<?php echo $update_row['passport_number'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_passport_if_any'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_driving_license_number'); ?></label>
                    <input type="text" name="driving_license_number" class="form-control"
                              value="<?php echo $update_row['driving_license_number'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_driving_if_any'); ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                          <label><?php echo __('phone'); ?></label>
                    <input type="text" name="phone" class="form-control"
                              value="<?php echo $update_row['phone'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_phone'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('email'); ?></label>
                    <input type="email" name="email" class="form-control"
                              value="<?php echo $update_row['email'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_email'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_address'); ?></label>
                    <input type="text" name="address" class="form-control"
                              value="<?php echo $update_row['address'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_address'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_marital_status'); ?></label>
                    <select name="marital_status" class="form-control">
                           <option value="Single" <?php if(($update_row['marital_status'] ?? '')=='Single') echo 'selected'; ?>><?php echo __('admin_single'); ?></option>
                           <option value="Married" <?php if(($update_row['marital_status'] ?? '')=='Married') echo 'selected'; ?>><?php echo __('admin_married'); ?></option>
                           <option value="Widowed" <?php if(($update_row['marital_status'] ?? '')=='Widowed') echo 'selected'; ?>><?php echo __('admin_widowed'); ?></option>
                           <option value="Divorced" <?php if(($update_row['marital_status'] ?? '')=='Divorced') echo 'selected'; ?>><?php echo __('admin_divorced'); ?></option>
                           <option value="Other" <?php if(($update_row['marital_status'] ?? '')=='Other') echo 'selected'; ?>><?php echo __('admin_other'); ?></option>
                    </select>
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_father_name'); ?></label>
                    <input type="text" name="father_name" class="form-control"
                              value="<?php echo $update_row['father_name'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_father_name'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_mother_name'); ?></label>
                    <input type="text" name="mother_name" class="form-control"
                              value="<?php echo $update_row['mother_name'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_mother_name'); ?>">
                </div>
                <div class="form-group">
                          <label><?php echo __('admin_provisional_driving_number'); ?></label>
                    <input type="text" name="provisional_driving_number" class="form-control"
                              value="<?php echo $update_row['provisional_driving_number'] ?? ''; ?>" placeholder="<?php echo __('admin_enter_provisional_if_any'); ?>">
                </div>
                
                <div class="form-group">
                          <label><?php echo __('admin_passport_image'); ?></label>
                    <input type="file" name="passport_image" class="form-control">
                    <?php if(!empty($update_row['passport_image'])): ?>
                        <img src="passports/<?php echo $update_row['passport_image']; ?>" alt="passport" width="100" class="mt-2">
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <button type="submit" name="savecitizen" class="btn btn-primary btn-block mt-3">
            <?php echo $update_row ? __('admin_update_citizen') : __('admin_register_citizen'); ?>
        </button>
    </form>

    <hr>

    <!-- List of Registered Citizens -->
    <h4 class="mt-4"><?php echo __('admin_registered_citizens'); ?></h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo __('full_name'); ?></th>
                <th><?php echo __('gender'); ?></th>
                <th><?php echo __('dob'); ?></th>
                <th><?php echo __('admin_national_id'); ?></th>
                <th><?php echo __('admin_passport_no'); ?></th>
                <th><?php echo __('admin_driving_no'); ?></th>
                <th><?php echo __('actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while($citizen = mysqli_fetch_assoc($all_citizens)) {
                echo "<tr>
                        <td>{$i}</td>
                        <td>{$citizen['first_name']} {$citizen['last_name']}</td>
                        <td>{$citizen['gender']}</td>
                        <td>{$citizen['date_of_birth']}</td>
                        <td>{$citizen['national_id']}</td>
                        <td>{$citizen['passport_number']}</td>
                        <td>{$citizen['driving_license_number']}</td>
                        <td>
                            <a href='?edit_id={$citizen['id']}' class='btn btn-sm btn-warning'>" . __('admin_edit') . "</a>
                        </td>
                      </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>

</div>
</section>