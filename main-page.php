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
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Poppins", sans-serif;
    }

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

    .left-icon {
      margin-left: 2.5rem;
    }

    .right-icon {
      margin-right: 2.5rem;
    }

    /* Custom rounded box */
    .rounded-box {
      background-color: #6200EA;
      border-radius: 10px;
      padding: 20px;
      color: #fff;
      margin-bottom: 20px;
      margin-top: -1rem;
    }

    h1 {
      font-weight: 600;
    }

    p {
      font-family: "Poppins", sans-serif;
      font-weight: 100;
      font-style: normal;
      color: #e1def9;
    }

    .button-container {
      display: flex;
      align-items: center;
    }
    /* Added margin to the left of the button */
    .button-container button {
      margin-left: auto;
    }
    @media (min-width: 768px) {
      .button-container {
        display: flex;
        justify-content: center;
        margin-top: 1rem; /* Adjust margin for better spacing */
      }
      h1 {
        font-size: 20px;
        margin-right: 1rem;
      }

      .button-container button {
        margin-left: 0;
      }
      p {
        margin-top: 1.5rem;
      }
    }

    /* Minimalist search input styles */
    .search-column {
      background-color: #f2f2f2;
      border-radius: 10px;
      padding: 10px;
    }

    .search-input {
      width: 100%;
      padding: 10px 40px 10px 10px;
      border: none;
      border-radius: 5px;
      outline: none;
      background-color: transparent;
      color: #333;
    }

    .search-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <!-- Minimalist search column -->
    <div class="row justify-content-center mt-4 search-column">
      <div class="col-md-6 position-relative">
        <input type="text" class="search-input" placeholder="Search...">
        <i class="fas fa-search search-icon"></i>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <div class="navbar">
    <a href="user-page.php" onclick="changeImage('user')"><img src="fi-rr-user.png" alt="" class="left-icon" id="user-icon"></a>
    <a href="main-page.php" class="active" onclick="changeImage('home')"><img src="fi-sr-home.png" alt="" class="middle-icon" id="home-icon"></a>
    <a href="notif-page.php" onclick="changeImage('bell')"><img src="fi-rr-bell.png" alt="" class="right-icon" id="bell-icon"></a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>




