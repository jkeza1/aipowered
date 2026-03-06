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
                    title: 'Duplicate!',
                    text: 'Passport number already exists!',
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
                title: 'Saved!',
                text: 'Citizen record saved successfully!',
                icon: 'success',
                button: 'OK'
            }).then(() => { window.location.href = ''; });
        </script>";
    } else {
        echo "<script>
            swal({
                title: 'Failed!',
                text: 'Citizen record not saved.',
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
    <h3 class="mb-4 text-center">Register / Update Citizen</h3>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $update_row['id'] ?? ''; ?>">

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="Enter first-name" required
                           value="<?php echo $update_row['first_name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="Enter last-name" required
                           value="<?php echo $update_row['last_name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male" <?php if(($update_row['gender'] ?? '')=='Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if(($update_row['gender'] ?? '')=='Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if(($update_row['gender'] ?? '')=='Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" required
                           value="<?php echo $update_row['date_of_birth'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Place of Birth</label>
                    <input type="text" name="place_of_birth" class="form-control"
                           value="<?php echo $update_row['place_of_birth'] ?? ''; ?>" placeholder="Enter birth-place">
                </div>
                <div class="form-group">
                    <label>National ID</label>
                    <input type="text" name="national_id" class="form-control"
                           value="<?php echo $update_row['national_id'] ?? ''; ?>" placeholder="Enter National ID if any">
                </div>
                <div class="form-group">
                    <label>Passport Number</label>
                    <input type="text" name="passport_number" class="form-control"
                           value="<?php echo $update_row['passport_number'] ?? ''; ?>" placeholder="Enter Passport No if any">
                </div>
                <div class="form-group">
                    <label>Driving License Number</label>
                    <input type="text" name="driving_license_number" class="form-control"
                           value="<?php echo $update_row['driving_license_number'] ?? ''; ?>" placeholder="Enter Driving License No if any">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control"
                           value="<?php echo $update_row['phone'] ?? ''; ?>" placeholder="Enter phone">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?php echo $update_row['email'] ?? ''; ?>" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control"
                           value="<?php echo $update_row['address'] ?? ''; ?>" placeholder="Enter address">
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status" class="form-control">
                        <option value="Single" <?php if(($update_row['marital_status'] ?? '')=='Single') echo 'selected'; ?>>Single</option>
                        <option value="Married" <?php if(($update_row['marital_status'] ?? '')=='Married') echo 'selected'; ?>>Married</option>
                        <option value="Widowed" <?php if(($update_row['marital_status'] ?? '')=='Widowed') echo 'selected'; ?>>Widowed</option>
                        <option value="Divorced" <?php if(($update_row['marital_status'] ?? '')=='Divorced') echo 'selected'; ?>>Divorced</option>
                        <option value="Other" <?php if(($update_row['marital_status'] ?? '')=='Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Father's Name</label>
                    <input type="text" name="father_name" class="form-control"
                           value="<?php echo $update_row['father_name'] ?? ''; ?>" placeholder="Enter father-names">
                </div>
                <div class="form-group">
                    <label>Mother's Name</label>
                    <input type="text" name="mother_name" class="form-control"
                           value="<?php echo $update_row['mother_name'] ?? ''; ?>" placeholder="Enter mother-names">
                </div>
                <div class="form-group">
                    <label>Provisional Driving Number</label>
                    <input type="text" name="provisional_driving_number" class="form-control"
                           value="<?php echo $update_row['provisional_driving_number'] ?? ''; ?>" placeholder="Enter Provisional Driving No if any">
                </div>
                
                <div class="form-group">
                    <label>Passport Image</label>
                    <input type="file" name="passport_image" class="form-control">
                    <?php if(!empty($update_row['passport_image'])): ?>
                        <img src="passports/<?php echo $update_row['passport_image']; ?>" alt="passport" width="100" class="mt-2">
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <button type="submit" name="savecitizen" class="btn btn-primary btn-block mt-3">
            <?php echo $update_row ? 'Update Citizen' : 'Register Citizen'; ?>
        </button>
    </form>

    <hr>

    <!-- List of Registered Citizens -->
    <h4 class="mt-4">Registered Citizens</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>National ID</th>
                <th>Passport No</th>
                <th>Driving No</th>
                <th>Actions</th>
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
                            <a href='?edit_id={$citizen['id']}' class='btn btn-sm btn-warning'>Edit</a>
                        </td>
                      </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>

</div>
</section>