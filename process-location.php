<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // Check if the data is valid
    if ($data && isset($data->latitude) && isset($data->longitude)) {
        // Process the latitude and longitude data as needed
        $latitude = $data->latitude;
        $longitude = $data->longitude;

        // For example, you can save the location data to a database
        // Replace this with your actual database handling code
        // $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
        // $stmt = $pdo->prepare('INSERT INTO locations (latitude, longitude) VALUES (:latitude, :longitude)');
        // $stmt->execute(['latitude' => $latitude, 'longitude' => $longitude]);

        // Send a response back to the client
        http_response_code(200);
        echo json_encode(['message' => 'Location processed successfully']);
    } else {
        // Invalid data, send an error response
        http_response_code(400);
        echo json_encode(['error' => 'Invalid data']);
    }
} else {
    // Invalid request method, send an error response
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
