<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
  http_response_code(401); // Unauthorized
  exit();
}

// Include your database connection file (e.g., config.php)
include 'config.php';

// Get the item ID from the POST request
$itemId = isset($_POST['item_id']) ? $_POST['item_id'] : null;

// Check if item ID is provided and fetch item details from the database
if ($itemId) {
  $itemSql = "SELECT * FROM registered_items WHERE item_id='$itemId'";
  $itemResult = mysqli_query($conn, $itemSql);
  if ($itemResult && mysqli_num_rows($itemResult) == 1) {
    $item = mysqli_fetch_assoc($itemResult);

    // Insert the item data into the reported_missing table
    $insertSql = "INSERT INTO reported_missing (user_id, user_name, item_name, item_image, item_description, last_seen, qrcode_image)
                  VALUES ('{$item['user_id']}', '{$item['user_name']}', '{$item['item_name']}', '{$item['item_image']}', '{$item['item_description']}', '{$item['last_seen']}', '{$item['qrcode_image']}')";
    $insertResult = mysqli_query($conn, $insertSql);

    if ($insertResult) {
      http_response_code(200); // Success
      exit();
    } else {
      http_response_code(500); // Internal Server Error
      exit();
    }
  } else {
    http_response_code(404); // Item not found
    exit();
  }
} else {
  http_response_code(400); // Bad Request
  exit();
}

