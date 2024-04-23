
<?php
// item_data_page.php

// Check if the itemData parameter is present in the URL
if (isset($_GET['itemData'])) {
    // Get the item data from the URL
    $itemData = urldecode($_GET['itemData']);

    // Display the item data
    echo "<h1>Item Data</h1>";
    echo "<pre>$itemData</pre>";
} else {
    // If itemData parameter is not present, redirect to another page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Data</title>
</head>

<body>
    <script>
        // Check if the page was opened from a QR code scan
        if (!document.referrer || document.referrer.indexOf(window.location.origin) !== 0) {
            // Redirect to another page if not opened from QR code
            // window.location.replace('index.php');
        }
    </script>
</body>

</html>