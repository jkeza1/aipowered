<?php
if(isset($_POST['login'])){

    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = $_POST['password'];

    // Must enter phone OR email
    if(empty($phone) && empty($email)){
        echo "<script>
        swal('Missing Information',
             'Please enter phone number or email.',
             'warning');
        </script>";
    }

    // Get user
    if(!empty($phone)){
        $query = mysqli_query($conn, "SELECT * FROM users WHERE phone='$phone' LIMIT 1");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
    }

    if(mysqli_num_rows($query) == 0){
        echo "<script>
        swal('Account Not Found',
             'No account found with provided details.',
             'error');
        </script>";
    }

    $user = mysqli_fetch_assoc($query);

    // Verify password
    if(password_verify($password, $user['password'])){

        // Create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['account_type'] = $user['account_type'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['email'] = $user['email'];

        echo "<script>
        swal('Login Successful',
             'Welcome back!',
             'success')
        .then(() => {
            window.location.href='userdashboard.php';
        });
        </script>";

    } else {

        echo "<script>
        swal('Invalid Password',
             'Incorrect password. Please try again.',
             'error');
        </script>";
    }
}
?>