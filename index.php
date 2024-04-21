<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 350px;
      margin: 100px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .login-container form {
      margin-bottom: 0;
    }
    .login-container .form-group {
      margin-bottom: 20px;
    }
    .login-container .btn-primary {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
    }
    .login-container .btn-secondary {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-container">
        
      <h2>Login</h2>
      <form>
        <div class="form-group">
          <input type="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="#" class="btn btn-secondary">Sign up</a>
      </form>
    </div>
  </div>
</body>
</html>
