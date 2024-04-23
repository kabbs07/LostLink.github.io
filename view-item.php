<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: login.php");
  exit();
}

// Include your database connection file (e.g., config.php)
include 'config.php';

// Check if item ID is provided in the URL
if (isset($_GET['item_id'])) {
  $itemId = $_GET['item_id'];

  // Fetch item details from the database based on the item ID
  $itemSql = "SELECT * FROM registered_items WHERE item_id='$itemId'";
  $itemResult = mysqli_query($conn, $itemSql);
  if ($itemResult && mysqli_num_rows($itemResult) == 1) {
    $item = mysqli_fetch_assoc($itemResult);
  } else {
    // Redirect if item not found
    header("Location: user-page.php");
    exit();
  }
} else {
  // Redirect if item ID is not provided in the URL
  header("Location: user-page.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.0/css/iziModal.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <style>
    body {
      font-family: "Poppins", sans-serif;
    }

    /* Hide scrollbar for webkit browsers (Chrome, Safari) */
    ::-webkit-scrollbar {
      display: none;
    }

    /* Hide scrollbar for Firefox */
    html {
      scrollbar-width: none;
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
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.7);
      /* Added box-shadow */
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
        margin-top: 1rem;
        /* Adjust margin for better spacing */
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

    #back-icon {
      margin-top: 10px;
    }

/* CSS to control the aspect ratio of the image */
.image-wrapper {
  position: relative;
  width: 100%;
  height: 0;
  padding-top: 56.25%; /* 16:9 aspect ratio (height:width) */
  overflow: hidden;
}

.image-wrapper img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: contain; /* Maintain aspect ratio without cropping */
  object-position: center; /* Center the image within the container */
}



    /* Edit button */
    .edit-btn {
      position: absolute;
      bottom: 10px;
      right: 10px;
      z-index: 1; /* Ensure it's above the image */
    }

        /* CSS for the modal */
    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }


    #close {
      color: white;
      position: absolute;
      top: 15px;
      right: 35px;
      font-size: 40px;
      font-weight: bold;
      transition: 0.3s;
    }

    #close:hover,
    #close:focus {
      color: #bbb;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <a href="user-page.php"><img src="back.png" alt="" id="back-icon"></a>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <h1>Item Details</h1>
        <div class="card">
          <div class="image-wrapper">
            <!-- Image wrapped in a container with fixed aspect ratio -->
            <img src="<?php echo $item['item_image']; ?>" class="card-img-top" alt="Item Image">
            <!-- Edit button -->
            <button class="btn btn-primary edit-btn">Edit</button>
          </div>
          <div class="card-body">
            <h5 class="card-title"><?php echo $item['item_name']; ?></h5>
            <p class="card-text"><?php echo $item['item_description']; ?></p>
            <p class="card-text"><small class="text-muted">Last seen: <?php echo $item['last_seen']; ?></small></p>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Modal for editing image position and scale -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span id="close">&times;</span>
    <h2>Edit Image</h2>
    <!-- Controls for adjusting image position -->
    <div class="form-group">
      <label for="horizontalRange">Horizontal Position:</label>
      <input type="range" id="horizontalRange" class="form-range" min="0" max="100" value="0">
    </div>
    <div class="form-group">
      <label for="verticalRange">Vertical Position:</label>
      <input type="range" id="verticalRange" class="form-range" min="0" max="100" value="0">
    </div>
    <!-- Controls for adjusting image scale -->
    <div class="form-group">
      <label for="zoomRange">Zoom:</label>
      <input type="range" id="zoomRange" class="form-range" min="50" max="200" value="100">
    </div>
    <!-- Save Changes button -->
    <button id="saveChangesBtn" class="btn btn-primary">Save Changes</button>
  </div>
</div>



  <div class="navbar">
    <a href="user-page.php" class="active" onclick="changeImage('user')"><img src="fi-sr-user.png" alt=""
        class="left-icon" id="user-icon"></a>
    <a href="main-page.php" onclick="changeImage('home')"><img src="fi-rr-home.png" alt="" class="middle-icon"
        id="home-icon"></a>
    <a href="notif-page.php" onclick="changeImage('bell')"><img src="fi-rr-bell.png" alt="" class="right-icon"
        id="bell-icon"></a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.0/js/iziModal.min.js"></script>
  <script>
  // Get the modal
  var modal = document.getElementById("myModal");
  // Get the image wrapper and the image element
  var imageWrapper = document.querySelector(".image-wrapper");
  var image = document.querySelector(".image-wrapper img");

  // Get the button that opens the modal
  var btn = document.getElementsByClassName("edit-btn")[0];

  // Get the <span> element that closes the modal
  var span = document.getElementById("close");

  // When the user clicks the button, open the modal 
  btn.onclick = function () {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

// Function to update image position and scale based on range inputs
function updateImage() {
  var horizontalValue = document.getElementById("horizontalRange").value;
  var verticalValue = document.getElementById("verticalRange").value;
  var zoomValue = document.getElementById("zoomRange").value;

  // Update image position
  image.style.left = horizontalValue + "%";
  image.style.top = verticalValue + "%";
  
  // Update image scale
  image.style.transform = "scale(" + (zoomValue / 100) + ")";
}

// Add event listeners to range inputs to update image position and scale
document.getElementById("horizontalRange").addEventListener("input", updateImage);
document.getElementById("verticalRange").addEventListener("input", updateImage);
document.getElementById("zoomRange").addEventListener("input", updateImage);
// Function to save changes
function saveChanges() {
  // Close the modal
  modal.style.display = "none";
  
  // Optionally, you can perform additional actions here, such as sending the updated image details to the server.
}

// Add event listener to the "Save Changes" button
document.getElementById("saveChangesBtn").addEventListener("click", saveChanges);


</script>


</body>

</html>

