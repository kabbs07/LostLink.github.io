<?php
// Include your database connection file
include 'config.php';

// Check if item ID is provided in the POST request
if (isset($_POST['item_id'])) {
  // Sanitize the input to prevent SQL injection
  $itemId = mysqli_real_escape_string($conn, $_POST['item_id']);

  // Perform the deletion operation in the database
  $deleteSql = "DELETE FROM registered_items WHERE item_id='$itemId'";
  $deleteResult = mysqli_query($conn, $deleteSql);

  if ($deleteResult) {
    // Deletion successful
    echo "success";
  } else {
    // Deletion failed
    echo "error";
  }
} else {
  // If item ID is not provided, handle the error
  echo "error";
}
?>
