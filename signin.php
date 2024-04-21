
<?php
    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';
    $msg = "";


    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['SESSION_EMAIL'] = $email;
            if ($row['is_admin']) {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            } else {
                $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images\BBCLOGO.jpg">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Login</title>
</head>
<body>
<div class="container">
        <img class="logo" src="images\299584772_435117378634124_6677388645313997495_n.png" alt="Logo">
        <h2>Login</h2>
        <form action="" method="post">
            <div class="form-group">
                <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
            </div>
            <p><a href="forgot-password.php">Forgot Password?</a></p>
            <button name="submit" class="btn" type="submit">Login</button>
        </form>
        <p>
    Don't have an account? <a href="register.php">Register Now</a>
    </p>
    </div>
    
</body>
</html>
