<?php
session_start();

// Include your database connection file (e.g., config.php)
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database based on the logged-in email
$email = $_SESSION['SESSION_EMAIL'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['id']; // Get user ID
    $userName = $row['name']; // Get user name
} else {
    // Redirect to login if user data is not found
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Validate and sanitize inputs
    $itemName = mysqli_real_escape_string($conn, $_POST['item_name']);
    $itemDescription = mysqli_real_escape_string($conn, $_POST['item_description']);
    $lastSeen = mysqli_real_escape_string($conn, $_POST['last_seen']);

    // Check if file was uploaded without errors
    if ($_FILES["item_image"]["error"] == UPLOAD_ERR_OK) {
        // Specify upload directory with unique file name
        $uploadDir = "uploads/";
        $imageFileName = uniqid() . '_' . basename($_FILES["item_image"]["name"]);
        $targetFile = $uploadDir . $imageFileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size (500KB limit)
        if ($_FILES["item_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats (JPG, JPEG, PNG, GIF)
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Attempt to move uploaded file to target directory
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFile)) {
                // Insert data into registered_items table without specifying id
                $sql = "INSERT INTO registered_items (user_id, user_name, item_name, item_image, item_description, last_seen)
                        VALUES ('$userId', '$userName', '$itemName', '$targetFile', '$itemDescription', '$lastSeen')";
                if (mysqli_query($conn, $sql)) {
                    echo "Item posted successfully.";
                } else {
                    echo "Error posting item: " . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Handle specific upload errors
        switch ($_FILES["item_image"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "No file was uploaded.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Missing temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "Failed to write file to disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "A PHP extension stopped the file upload.";
                break;
            default:
                echo "Unknown upload error.";
                break;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting Page</title>
</head>

<body>
    <h2>Post an Item</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" required><br><br>

        <label for="item_description">Item Description:</label><br>
        <textarea id="item_description" name="item_description" rows="4" cols="50" required></textarea><br><br>

        <label for="item_image">Item Image:</label>
        <input type="file" id="item_image" name="item_image" accept="image/*" required><br><br>

        <label for="last_seen">Last Seen:</label>
        <input type="text" id="last_seen" name="last_seen" required><br><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>

</html>
