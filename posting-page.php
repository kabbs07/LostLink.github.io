<?php
use chillerlan\QRCode\{QRCode, QROptions};

require_once 'vendor/autoload.php';

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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <title>Posting Page</title>
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
            outline: none ;
            box-shadow:none;
            font-family: "Poppins", sans-serif;
            transition: border-bottom 100ms ease-in-out;

        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus {
            border-bottom: 2px solid #6200EE;
          
        }
        input:focus{
            outline:none;
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
            max-height: 95px; /* Set a maximum height for the container */
            overflow-y: auto; /* Enable vertical scrolling */
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
        i{
            margin:0.5rem;
            color: #6200EE;
        }
        .upload-text{
            color: #6200EE;
            font-weight:600;
            font-size:13px;
        }
        span{
            color:red;
            font-weight:400;
        }
        .form-label{
            font-family: "Poppins", sans-serif;
            font-size:13px;
        }
        input:focus {
    outline: none !important;
    box-shadow: none !important; /* Also try removing any box-shadow */
}
textarea:focus{
   outline: none !important;
    box-shadow: none !important; /* Also try removing any box-shadow */
}
     /* Custom styles for textarea */
     textarea.form-control {
            min-height: 150px; /* Set minimum height */
            padding: 10px; /* Adjust padding */
            border: 1px solid #ced4da; /* Custom border color */
            border-radius: 5px; /* Custom border radius */
            resize: vertical; /* Allow vertical resizing */
            font-family: Arial, sans-serif; /* Custom font family */
            font-size: 14px; /* Custom font size */
            line-height: 1.5; /* Custom line height */
        }

        /* Style for focused textarea */
        textarea.form-control:focus {
            border-color: #6200EE; /* Custom border color on focus */
            box-shadow: 0 0 0 0.2rem rgba(98, 0, 238, 0.25); /* Custom box shadow on focus */
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
                <textarea class="form-control" id="item_description" name="item_description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="last_seen" class="form-label">Last Seen:</label>
                <input type="text" class="form-control" id="last_seen" name="last_seen" required>
            </div>
            <div class="mb-3 text-center">
        <label for="item_image" class="form-label upload-text">
             <i class="fas fa-upload me-2"></i> Add photo from library <br> <span>(Max 3 Images)</span>
        </label>
        <input type="file" class="form-control visually-hidden" id="item_image" name="item_image" accept="image/*" onchange="previewImage(event)" required multiple>
    </div>
            <div class="preview-imgs-container">
                <div class="preview-images list-group"></div>
            </div>
            <div class="text-center">
                <button type="submit" name="submit" class="">Generate QR Code</button>
            </div>

        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
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

                removeBtn.onclick = function() {
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
    </script>
</body>
<?php
// Function to resize image
function resizeImage($file, $width, $height, $targetFile) {
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

// Handle file upload
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

        // Check if file size exceeds limit (500KB)
        if ($_FILES["item_image"]["size"] > 500000) {
            // Resize the image
            $resizedFile = resizeImage($_FILES["item_image"]["tmp_name"], 800, 600, $targetFile);
            if ($resizedFile !== false) {
                $targetFile = $resizedFile;
            } else {
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'Failed to resize the image.',
                    position: 'topRight'
                });
                </script>";
                $uploadOk = 0;
            }
        }

        // Continue with upload process
        if ($uploadOk == 1) {
            // Attempt to move uploaded file to target directory
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFile)) {
                             // Configure QR code options
                             $options = new QROptions([
                                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                                'eccLevel' => QRCode::ECC_L,
                                'imageBase64' => false, // Output as binary data
                            ]);
            
                            // Initialize QR code instance with options
                            $qrcode = new QRCode($options);
            
                            $itemData = "User Name: $userName\nItem Name: $itemName\nItem Description: $itemDescription\nLast Seen: $lastSeen";
                            $completeUrl = $baseUrl . "item_data_page.php?itemData=" . urlencode($itemData);
            
                            // Generate QR code using the complete URL
                            $imageData = $qrcode->render($completeUrl);
                            // Specify the folder to store the image
                            $qrcodeDir = 'qrcodes/';
                            $qrcodeFileName = $qrcodeDir . 'qrcode_' . uniqid() . '.png';
            
                            // Save the QR code image data to a file
                            file_put_contents($qrcodeFileName, $imageData);

                // Insert data into registered_items table without specifying id
                $sql = "INSERT INTO registered_items (user_id, user_name, item_name, item_image, item_description, last_seen)
                        VALUES ('$userId', '$userName', '$itemName', '$targetFile', '$itemDescription', '$lastSeen')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>
                    iziToast.success({
                        title: 'Success',
                        message: 'Item posted successfully.',
                        position: 'topRight'
                    });
                    </script>";
                } else {
                    echo "<script>
                    iziToast.error({
                        title: 'Error',
                        message: 'Error posting item: " . mysqli_error($conn) . "',
                        position: 'topRight'
                    });
                    </script>";
                }
            } else {
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'Sorry, there was an error uploading your file.',
                    position: 'topRight'
                });
                </script>";
            }
        }
    } else {
        // Handle specific upload errors
        switch ($_FILES["item_image"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                    position: 'topRight'
                });
                </script>";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'The uploaded file was only partially uploaded.',
                    position: 'topRight'
                });
                </script>";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'No file was uploaded.',
                    position: 'topRight'
                });
                </script>";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'Missing temporary folder.',
                    position: 'topRight'
                });
                </script>";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'Failed to write file to disk.',
                    position: 'topRight'
                });
                </script>";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'A PHP extension stopped the file upload.',
                    position: 'topRight'
                });
                </script>";
                break;
            default:
                echo "<script>
                iziToast.error({
                    title: 'Error',
                    message: 'Unknown upload error.',
                    position: 'topRight'
                });
                </script>";
                break;
        }
    }
}
?>
</html>
