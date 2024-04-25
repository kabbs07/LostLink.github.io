<?php
// Include your database connection file (e.g., config.php)
include 'config.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present in the POST request
    if (isset($_POST['item_id']) && isset($_POST['item_name']) && isset($_POST['item_description']) && isset($_POST['last_seen'])) {
        // Sanitize and validate input
        $itemId = mysqli_real_escape_string($conn, $_POST['item_id']);
        $itemName = mysqli_real_escape_string($conn, $_POST['item_name']);
        $itemDescription = mysqli_real_escape_string($conn, $_POST['item_description']);
        $lastSeen = mysqli_real_escape_string($conn, $_POST['last_seen']);

        // Update the item details in the database
        $updateSql = "UPDATE registered_items SET item_name='$itemName', item_description='$itemDescription', last_seen='$lastSeen' WHERE item_id='$itemId'";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            // Update successful
            echo "success";
        } else {
            // Update failed
            echo "error";
        }
    } else {
        // Required fields are missing
        echo "error";
    }
} else {
    // Invalid request method
    echo "error";
}
?>
