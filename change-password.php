<?php
$msg = "";

include 'config.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

            if ($password === $confirm_password) {
                $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    // Update code to 'verified'
                    $updateCodeQuery = mysqli_query($conn, "UPDATE users SET code='verified' WHERE code='{$_GET['reset']}'");
                    $msg = "<div class='alert alert-success'>Password reset successful'.</div>";
                    
                    if ($updateCodeQuery) {
                        header("Location: index.php");
                    } else {
                        $msg = "<div class='alert alert-error'>Error updating code to 'verified'.</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-error'>Error updating password.</div>";
                }
            } else {
                $msg = "<div class='alert alert-error'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-error'>Reset Link does not match.</div>";
    }
} else {
    header("Location: forgot-password.php");
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="icon" type="image/png" href="images\BBCLOGO.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image3.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Change Password</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script>
<?php
if (!empty($msg)) {
  echo "var message = '" . addslashes($msg) . "';";
  if (strpos($msg, 'error') !== false) {
    // Display error message in red
    echo "iziToast.show({
      title: '',
      message: message,
      color: 'red',
      position: 'topCenter',
      timeout: 5000,
      transitionIn: 'fadeInDown',
      close: false, // Include the close button inside the box
      closeOnClick: true,
      progressBarColor: 'rgb(0, 255, 184)' // Custom progress bar color
    });";
  } else {
    // Display success message in green
    echo "iziToast.show({
      title: '',
      message: message,
      color: 'green',
      position: 'topCenter',
      timeout: 5000,
      transitionIn: 'fadeInDown',
      close: false, // Include the close button inside the box
      closeOnClick: true,
      progressBarColor: 'rgb(0, 255, 184)' // Custom progress bar color
    });";
  }
}
?>





</script>
</html>