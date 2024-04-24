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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Navbar styles */
    .navbar {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: #fff;
      color: #fff;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.7); /* Added box-shadow */
    }

    .navbar a {
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
      margin-bottom: 0.5rem;
    }
    .left-icon{
      margin-left:2.5rem;
    }
    .right-icon{
      margin-right:2.5rem;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h1>Welcome, User!</h1>
    <form method="post">
      <button type="submit" name="logout" class="btn btn-primary">Logout</button>
    </form>
  </div>

  <?php
// item.php

// Include your database connection file (e.g., config.php)
include 'config.php';

// Check if the item ID is provided in the URL
if (isset($_GET['item_id'])) {
    // Get the item ID
    $itemId = $_GET['item_id'];

    // Fetch item details from the database based on the item ID
    $sql = "SELECT * FROM registered_items WHERE id = '$itemId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Display item details or perform other actions
        // For example:
        echo "Item Name: " . $row['item_name'];
        echo "<br>";
        echo "Item Description: " . $row['item_description'];
        // Add more details as needed
    } else {
        // Item not found
        echo "Item not found.";
    }
} else {
    // Item ID not provided
    echo "Item ID not provided.";
}
?>





  <!-- Navbar -->
  <div class="navbar">
    <a href="user-page.php" onclick="changeImage('user')" ><img src="fi-rr-user.png" alt="" class="left-icon" id="user-icon"></a>
    <a href="main-page.php" onclick="changeImage('home')" ><img src="fi-rr-home.png" alt="" class="middle-icon" id="home-icon"></a>
    <a href="notif-page.php" onclick="changeImage('bell')" ><img src="fi-rr-bell.png" alt="" class="right-icon" id="bell-icon"></a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script>
    function changeImage(icon) {
      var userIcon = document.getElementById('user-icon');
      var homeIcon = document.getElementById('home-icon');
      var bellIcon = document.getElementById('bell-icon');

      // Reset all icons to their default
      userIcon.src = 'fi-rr-user.png';
      homeIcon.src = 'fi-rr-home.png';
      bellIcon.src = 'fi-rr-bell.png';

      // Change the clicked icon
      switch (icon) {
        case 'user':
          userIcon.src = 'fi-sr-user.png';
          break;
        case 'home':
          homeIcon.src = 'fi-sr-home.png';
          break;
        case 'bell':
          bellIcon.src = 'fi-sr-bell.png';
          break;
        default:
          break;
      }
    }
  </script>
</body>

</html>


