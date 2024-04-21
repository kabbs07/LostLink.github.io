<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: login.php");
  exit();
}

// Include your database connection file (e.g., config.php)
include 'config.php';

// Fetch user details from the database based on the logged-in email
$email = $_SESSION['SESSION_EMAIL'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  $welcome_message = "Welcome, " . $row['name'] . "!";
} else {
  // Redirect to login if user data is not found
  header("Location: login.php");
  exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  <h1><?php echo $welcome_message; ?></h1>
  <form method="post">
    <button type="submit" name="logout">Logout</button>
  </form>
</body>

</html>
