<?php
include 'config.php';
$msg = "";

if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE code='{$verificationCode}'");

    if (mysqli_num_rows($query) > 0) {
        $updateQuery = mysqli_query($conn, "UPDATE users SET code='verified' WHERE code='{$verificationCode}'");

        if ($updateQuery) {
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Failed to complete account verification. Please try again later.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid verification code. Please check the link or try again.</div>";
    }
} else {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Account Verification</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Account Verification" />
    <link rel="icon" type="image/png" href="images/BBCLOGO.jpg">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>

<body>
    <section class="w3l-mockup-form">
        <div class="container">
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                           
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Account Verification</h2>
                        <?php echo $msg; ?>
                        <p>Return to <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
