<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Actor&display=swap" rel="stylesheet">
  <title>Lost Link</title>
  <style>

    .container {
      max-width: 400px;
      margin: 50px auto;
      text-align: left; /* Align header to the left */
      padding-left: 20px; /* Add padding to the left for better alignment */
      padding-right: 20px;
      position: relative; /* Make container position relative */
    }

    h1 {
      margin-bottom: 30px;
      font-family: "Poppins", sans-serif;
      font-weight: 500;
    }

    .email-input,
    .password-input {
      position: relative;
      margin-bottom: 20px;
    }

    .email-input input,
    .password-input input {
      width: 100%;
      padding: 10px 0;
      border: none;
      border-bottom: 1px solid #000;
      outline: none;
      font-family: "Poppins", sans-serif;
      transition: border-bottom 0.3s ease; /* Added transition for smooth effect */
    }

    .email-input input:focus,
    .password-input input:focus {
      border-bottom: 2px solid #001B299C; /* Adjusted border-bottom thickness for focus state */
    }

    .email-input label,
    .password-input label {
      position: absolute;
      top: 0;
      left: 0;
      padding: 10px 0; /* Shorter placeholder length */
      color: #001B299C;
      pointer-events: none;
      transition: .3s;
      font-family: "Poppins", sans-serif;
      font-size: 12px; /* Adjusted font size for shorter placeholders */
    }

    .email-input input:focus + label,
    .email-input input:not(:placeholder-shown) + label,
    .password-input input:focus + label,
    .password-input input:not(:placeholder-shown) + label {
      transform: translateY(-20px);
      font-size: 14px;
      color: #001B299C;
    }

    button {
      font-family: "Poppins", sans-serif;
      padding: 10px 100px 10px 100px;
      font-size: 16px;
      background-color:  #6200EE;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 25px 25px;
      transition: 200ms ease-in-out;
      margin: 4rem auto 0; /* Center the button horizontally */
      display: block; /* Ensure the button occupies full width */
    }

    button:hover {
      background-color:#001B299C;
    }

    .forgot-password {
      position: absolute;
      top: 100%;
      right: 0;
      font-family: "Poppins", sans-serif;
      font-size: 12px;
      color: #4252E5;
      text-decoration: none;
      margin-top: 5px;
    }

    #back-icon {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <a href="welcome.php"><img src="back.png" alt="" id="back-icon"></a>
  <div class="container">
    <h1>Sign In</h1>
    <form>
      <div class="email-input">
        <input type="email" id="email" placeholder=" " />
        <label for="email">Email</label>
      </div>
      <div class="password-input">
        <input type="password" id="password" placeholder=" " />
        <label for="password">Password</label>
        <a href="#" class="forgot-password">Forgot Password?</a>
      </div>
      <button type="submit">Sign In</button>
    </form>
  </div>
</body>
</html>
