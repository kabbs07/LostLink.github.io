<?php
session_start();

if (isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: index.php"); // Redirect if already logged in
  exit();
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
        header("Location: admin.php"); // Redirect to admin page if user is admin
      } else {
        header("Location: index.php"); // Redirect to homepage if user is not admin
      }
      exit(); // Exit after redirection
    } else {
      $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
    }
  } else {
    $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
  }
}

// If the script reaches here, it means there was an error or invalid login
echo $msg;
?>
