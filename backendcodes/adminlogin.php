
<?php

if (isset($_POST['login'])) {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email)) {
     echo "<script>
        swal('Enter your email',
             'Enter your email address',
             'info');
        </script>";
    } else {

        // STEP 1: Check if email exists in users table
        $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {


echo "<script>
        swal('Invalid email',
             'This email does not have a normal account.',
             'error');
        </script>";



        } else {

            // STEP 2: Check today's password
            $todayPassword = date("dmY");

            if ($password === $todayPassword) {

                $user = $result->fetch_assoc();

                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_user_email'] = $user['email'];
                 echo "<script>
        swal('Login Successful',
             'Welcome back!',
             'success')
        .then(() => {
            window.location.href='adminsection/dashboard.php';
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
    }
}
?>
