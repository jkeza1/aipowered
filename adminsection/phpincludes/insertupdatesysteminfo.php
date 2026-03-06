<?php
if(isset($_POST['saveupdateabout']))
{
    $id = $_POST['id'] ?? '';

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $termsofuse = mysqli_real_escape_string($conn, $_POST['termsofuse']);
    $privacypolicy = mysqli_real_escape_string($conn, $_POST['privacypolicy']);
    $aboutsystem = mysqli_real_escape_string($conn, $_POST['aboutsystem']);

    function uploadImage($field)
    {
        if(!empty($_FILES[$field]['name']))
        {
            $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];

            if(!in_array($ext, $allowed))
            {
                return null;
            }

            $filename = "system_" . uniqid() . "." . $ext;

            if(!is_dir("systemimages"))
            {
                mkdir("systemimages", 0777, true);
            }

            move_uploaded_file($_FILES[$field]['tmp_name'], "systemimages/" . $filename);

            return $filename;
        }

        return null;
    }

    // Upload only images that exist in form
    $icon = uploadImage("icon");
    $logo = uploadImage("logo");
    $nationalid = uploadImage("nationalid");
    $drivinglicense = uploadImage("drivinglicense");
    $passport = uploadImage("passport");
    $marriagecertificate = uploadImage("marriagecertificate");
    $goodconduct = uploadImage("goodconduct");
    $provisionaldriving = uploadImage("provisionaldriving");

    if($id)
    {
        $sql = "UPDATE systeminfo SET 
                name='$name',
                termsofuse='$termsofuse',
                privacypolicy='$privacypolicy',
                aboutsystem='$aboutsystem'";

        if($icon) $sql .= ", icon='$icon'";
        if($logo) $sql .= ", logo='$logo'";
        if($nationalid) $sql .= ", nationalid='$nationalid'";
        if($drivinglicense) $sql .= ", drivinglicense='$drivinglicense'";
        if($passport) $sql .= ", passport='$passport'";
        if($marriagecertificate) $sql .= ", marriagecertificate='$marriagecertificate'";
        if($goodconduct) $sql .= ", goodconduct='$goodconduct'";
        if($provisionaldriving) $sql .= ", provisionaldriving='$provisionaldriving'";

        $sql .= " WHERE id='$id'";
    }
    else
    {
        $sql = "INSERT INTO systeminfo 
        (name, termsofuse, privacypolicy, aboutsystem,
        icon, logo, nationalid, drivinglicense, passport,
        marriagecertificate, goodconduct, provisionaldriving)
        VALUES
        ('$name','$termsofuse','$privacypolicy','$aboutsystem',
        '$icon','$logo','$nationalid','$drivinglicense','$passport',
        '$marriagecertificate','$goodconduct','$provisionaldriving')";
    }

    if(mysqli_query($conn,$sql))
    {
        echo "
        <script>
        swal({
          title: 'Success!',
          text: 'Info saved successfully.',
          icon: 'success',
          button: 'OK'
        }).then(() => {
          window.location.href = '';
        });
        </script>
        ";
    }
    else
    {
        echo "
        <script>
        swal({
          title: 'Error!',
          text: 'Something went wrong.',
          icon: 'error',
          button: 'OK'
        });
        </script>
        ";
    }
}
?>