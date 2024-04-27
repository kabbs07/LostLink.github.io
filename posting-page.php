<?php
use chillerlan\QRCode\{QRCode, QROptions};

require_once 'vendor/autoload.php';

// Start the session
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
    $userId = $row['user_id']; // Get user ID
    $userName = $row['name']; // Get user name
} else {
    // Redirect to login if user data is not found
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <title>Posting Page</title>
</head>
<style>
    body {
        font-family: "Poppins", sans-serif;
    }

    #back-icon {
        margin-top: 10px;
    }

    .container {
        max-width: 400px;
        margin: 50px auto;
        text-align: left;
        padding-left: 20px;
        padding-right: 20px;
        position: relative;
    }

    h1 {
        margin-bottom: 30px;
        font-family: "Poppins", sans-serif;
        font-weight: 500;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-family: "Poppins", sans-serif;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea {
        width: 100%;
        padding: 5px 0;
        border: none;
        border-bottom: 1px solid #8484849C;
        outline: none;
        box-shadow: none;
        font-family: "Poppins", sans-serif;
        transition: border-bottom 100ms ease-in-out;

    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    textarea:focus {
        border-bottom: 2px solid #6200EE;

    }

    input:focus {
        outline: none;
    }

    button {
        font-family: "Poppins", sans-serif;
        padding: 10px 100px;
        font-size: 12px;
        background-color: #6200EE;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 25px;
        transition: 200ms ease-in-out;
        margin-top: 20px;
    }

    button:hover {
        background-color: #001B299C;
    }

    .preview-images {
        margin-bottom: 20px;
    }

    .preview-imgs-container {
        max-height: 95px;
        /* Set a maximum height for the container */
        overflow-y: auto;
        /* Enable vertical scrolling */
        margin-bottom: 0.5em;
    }

    .preview-image {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .preview-image p {
        margin: 0;
    }

    .remove-btn {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .remove-btn i {
        color: red;
    }

    .visually-hidden {
        position: absolute !important;
        clip: rect(1px, 1px, 1px, 1px);
        padding: 0 !important;
        border: 0 !important;
        height: 1px !important;
        width: 1px !important;
        overflow: hidden;
    }

    i {
        margin: 0.5rem;
        color: #6200EE;
    }

    .upload-text {
        color: #6200EE;
        font-weight: 600;
        font-size: 13px;
    }

    span {
        color: red;
        font-weight: 400;
    }

    .form-label {
        font-family: "Poppins", sans-serif;
        font-size: 13px;
    }

    input:focus {
        outline: none !important;
        box-shadow: none !important;
        /* Also try removing any box-shadow */
    }

    textarea:focus {
        outline: none !important;
        box-shadow: none !important;
        /* Also try removing any box-shadow */
    }

    /* Custom styles for textarea */
    textarea.form-control {
        min-height: 150px;
        /* Set minimum height */
        padding: 10px;
        /* Adjust padding */
        border: 1px solid #ced4da;
        /* Custom border color */
        border-radius: 5px;
        /* Custom border radius */
        resize: vertical;
        /* Allow vertical resizing */
        font-family: Arial, sans-serif;
        /* Custom font family */
        font-size: 14px;
        /* Custom font size */
        line-height: 1.5;
        /* Custom line height */
    }

    /* Style for focused textarea */
    textarea.form-control:focus {
        border-color: #6200EE;
        /* Custom border color on focus */
        box-shadow: 0 0 0 0.2rem rgba(98, 0, 238, 0.25);
        /* Custom box shadow on focus */
    }
</style>
</head>

<body>
    <a href="user-page.php"><img src="back.png" alt="" id="back-icon"></a>
    <div class="container mt-5">
        <form method="post" enctype="multipart/form-data">
            <!-- List group for preview images -->

            <div class="mb-3">
                <label for="item_name" class="form-label">Item Name:</label>
                <input type="text" class="form-control" id="item_name" name="item_name" required>
            </div>
            <div class="mb-3">
                <label for="item_description" class="form-label">Item Description:</label>
                <textarea class="form-control" id="item_description" name="item_description" rows="4"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="last_seen" class="form-label">Last Seen:</label>
                <input type="text" class="form-control" id="last_seen" name="last_seen" required>
            </div>
            <div class="mb-3 text-center">
                <label for="item_image" class="form-label upload-text">
                    <i class="fas fa-upload me-2"></i> Add photo from library <br>
                </label>
                <input type="file" class="form-control visually-hidden" id="item_image" name="item_image[]"
                    accept="image/*" onchange="previewImage(event)" required multiple>

            </div>
            <div class="preview-imgs-container">
                <div class="preview-images list-group"></div>
            </div>
            <div class="text-center">
                <button type="submit" name="submit" class="">Generate QR Code</button>
            </div>

        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to preview selected images
        function previewImage(event) {
            var previewContainer = document.querySelector('.preview-images');
            previewContainer.innerHTML = '';

            var files = event.target.files;

            // Check if number of files exceeds 3
            if (files.length > 3) {
                alert("You can only upload a maximum of 3 files.");
                // Clear the file input
                document.getElementById('item_image').value = '';
                return; // Exit the function
            }

            for (var i = 0; i < files.length; i++) {
                var file = files[i]; // Capture the file object here

                var fileName = file.name; // Access the captured file object here
                if (fileName.length > 15) {
                    fileName = fileName.substring(0, 15) + '...';
                }

                var fileNameElement = document.createElement('p');
                fileNameElement.textContent = fileName;

                var removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';

                removeBtn.onclick = function () {
                    var parent = this.parentNode;
                    parent.parentNode.removeChild(parent);
                };

                var previewImage = document.createElement('div');
                previewImage.classList.add('preview-image');
                previewImage.appendChild(fileNameElement);
                previewImage.appendChild(removeBtn);

                previewContainer.appendChild(previewImage);
            }
        }
         // Function to toggle upload label visibility
    function toggleUploadLabel() {
        var uploadLabel = document.getElementById('uploadLabel');
        var fileInput = document.getElementById('item_image');

        if (fileInput.files.length > 3) {
            uploadLabel.style.display = 'block';
        } else {
            uploadLabel.style.display = 'none';
        }
    }

    // Add event listener to file input
    document.getElementById('item_image').addEventListener('change', toggleUploadLabel);

    </script>
</body>
<?php
// Function to resize image
// Function to resize image
function resizeImage($file, $width, $height, $targetFile)
{
    list($originalWidth, $originalHeight) = getimagesize($file);
    $resizeRatio = min($width / $originalWidth, $height / $originalHeight);
    $newWidth = ceil($resizeRatio * $originalWidth);
    $newHeight = ceil($resizeRatio * $originalHeight);
    $tmp = imagecreatetruecolor($newWidth, $newHeight);

    switch (exif_imagetype($file)) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($file);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($file);
            break;
        default:
            return false;
    }

    imagecopyresampled($tmp, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    imagejpeg($tmp, $targetFile, 90);
    imagedestroy($tmp);
    return $targetFile;
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Validate and sanitize inputs
    $itemName = mysqli_real_escape_string($conn, $_POST['item_name']);
    $itemDescription = mysqli_real_escape_string($conn, $_POST['item_description']);
    $lastSeen = mysqli_real_escape_string($conn, $_POST['last_seen']);

    // Check if files were uploaded without errors
    if (!empty(array_filter($_FILES['item_image']['name']))) {
        $uploadDir = "uploads/";

        $uploadedImages = array();

        foreach ($_FILES['item_image']['name'] as $key => $value) {
            $imageFileName = uniqid() . '_' . basename($_FILES['item_image']['name'][$key]);
            $targetFile = $uploadDir . $imageFileName;


            // Check if file size exceeds limit (500KB)
            if ($_FILES['item_image']['size'][$key] > 500000) {
                echo "<script>alert('File size exceeds the limit.');</script>";
                continue; // Skip this file
            }

            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            // Check if file format is allowed
            if (!in_array($imageFileType, $allowedExtensions)) {
                echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
                continue; // Skip this file
            }

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['item_image']['tmp_name'][$key], $targetFile)) {
                $uploadedImages[] = $targetFile; // Store the file path
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        }

        if (!empty($uploadedImages)) {

            // Configure QR code options
            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_L,
                'imageBase64' => false, // Output as binary data
            ]);

            // Initialize QR code instance with options
            $qrcode = new QRCode($options);

            $itemData = "User Name: $userName\nItem Name: $itemName\nItem Description: $itemDescription\nLast Seen: $lastSeen";
            $completeUrl = BASE_URL . "item_data_page.php?itemData=" . urlencode($itemData);

            // Generate QR code using the complete URL
            $imageData = $qrcode->render($completeUrl);

            // Specify the folder to store the QR code image
            $qrcodeDir = 'qrcodes/';
            $qrcodeFileName = $qrcodeDir . 'qrcode_' . uniqid() . '.png';

            // Save the QR code image data to a file
            file_put_contents($qrcodeFileName, $imageData);
            // Concatenate image paths into a comma-separated string
            $imagePaths = implode(",", $uploadedImages);

            // Insert data into registered_items table with concatenated image paths
            $sql = "INSERT INTO registered_items (user_id, user_name, item_name, item_image, item_description, last_seen, qrcode_image)
        VALUES ('$userId', '$userName', '$itemName', '$imagePaths', '$itemDescription', '$lastSeen', '$qrcodeFileName')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Item posted successfully.');</script>";
            } else {
                echo "<script>alert('Error posting item: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
} 


?>

</html>