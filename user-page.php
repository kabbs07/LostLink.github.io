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
      margin-top: 20px; /* Added margin */
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
    .added-items-box{
      background: #FFFFFF;
      margin-top:0.2rem;
      box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3); /* Added box-shadow */
    }
    .registered-items-text{
      color: #00141FCC;
      margin-top:0.6rem;
      font-size: 24px;

    }
    .product-name{
      color:#000;
      font-weight:600;
      font-size:24px;
    }
    small{
      color: #333638CC;
      font-weight:bold;
      font-size:12px;

    }
    .item-posted-date{
      color: #333638CC;
    }
    button {
      font-family: "Poppins", sans-serif;
      padding: 5px 55px 5px 55px;
      border-radius:25px 25px;
      font-size:13px;
      font-weight:600;
      color: #6200EE;
      border: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <!-- First Rounded box with two columns -->
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="rounded-box">
          <div class="row">
            <div class="col-md-6 button-container"> <!-- Modified column -->
              <h1>Add an item</h1>
              <button class="btn "><img src="add_circle.png" alt=""></button>
            </div>
            <div class="col-md-6">
              <p>Register the items <br> you want here</p>
            </div>
          </div>
        </div>
      </div>
    </div>
   
    <!-- Second Rounded box -->
<div class="row justify-content-center">
  <div class="col-md-6">
  <div><h1 class="registered-items-text">Registered Items</h1></div>
    <div class="rounded-box added-items-box">
      <!-- Static Product Detail -->
      <div class="product-detail d-flex align-items-center justify-content-between">
      <div class="product-info">
          <small>25 mins ago</small>
          <h2 class="product-name">Lenovo Laptop</h2>
          <button>View Item</button>
        </div>
        <div class="product-image">
          <img src="frame 2.png" alt="Product Image">
        </div>
      </div>
    </div>
  </div>
</div>


  <div class="navbar">
    <a href="user-page.php" class="active" onclick="changeImage('user')" ><img src="fi-sr-user.png" alt="" class="left-icon" id="user-icon"></a>
    <a href="main-page.php" onclick="changeImage('home')" ><img src="fi-rr-home.png" alt="" class="middle-icon" id="home-icon"></a>
    <a href="notif-page.php" onclick="changeImage('bell')" ><img src="fi-rr-bell.png" alt="" class="right-icon" id="bell-icon"></a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src ="change-img.js"></script>

</body>

</html>



