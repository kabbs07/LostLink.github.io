<!DOCTYPE html>
<html>
<head>
    <title>QR Code Scanner</title>
</head>
<body>
    <!-- Display the QR code -->
    <img id="qrCode" src="path/to/your/php-script-that-generates-qrcode.php" alt="QR Code">

    <!-- JavaScript to handle scanning and redirect to Google Maps -->
    <script>
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Open Google Maps with the exact location
            var googleMapsUrl = 'https://www.google.com/maps?q=' + latitude + ',' + longitude;
            window.location.href = googleMapsUrl;
        });
    </script>
</body>
</html>
