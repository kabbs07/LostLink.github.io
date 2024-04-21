<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lost Link</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Actor&display=swap" rel="stylesheet">
  
</head>
<body>
  <!-- tite -->
  <div class="welcome-screen">
    <h1>Lost Link</h1>
    <p>Find what's lost, reunite what's found:<br> 
Your compass in a world of lost things.</p>
    <button onclick="redirectToLoginForm()">Welcome</button>
  </div>

</body>
</html>

<script>
    function redirectToLoginForm() {
  window.location.href = "welcome.php";
}
</script>
