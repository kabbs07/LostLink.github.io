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
    .password-input,
    .name-input,
    .confirm-password-input {
      position: relative;
      margin-bottom: 20px;
    }

    .email-input input,
    .password-input input,
    .name-input input,
    .confirm-password-input input {
      width: 100%;
      padding: 10px 0;
      border: none;
      border-bottom: 1px solid #000;
      outline: none;
      font-family: "Poppins", sans-serif;
      transition: border-bottom 0.3s ease; /* Added transition for smooth effect */
    }

    .email-input input:focus,
    .password-input input:focus,
    .name-input input:focus,
    .confirm-password-input input:focus {
      border-bottom: 2px solid #001B299C; /* Adjusted border-bottom thickness for focus state */
    }

    .email-input label,
    .password-input label,
    .name-input label,
    .confirm-password-input label {
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
    .password-input input:not(:placeholder-shown) + label,
    .name-input input:focus + label,
    .name-input input:not(:placeholder-shown) + label,
    .confirm-password-input input:focus + label,
    .confirm-password-input input:not(:placeholder-shown) + label {
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



    #back-icon {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <a href="welcome.php"><img src="back.png" alt="" id="back-icon"></a>
  <div class="container">
    <h1>Create Account</h1>
    <form>
      <div class="name-input">
        <input type="text" id="name" placeholder=" " />
        <label for="name">Name</label>
      </div>
      <div class="email-input">
        <input type="email" id="email" placeholder=" " />
        <label for="email">Email</label>
      </div>
      <div class="password-input">
        <input type="password" id="password" placeholder=" " />
        <label for="password">Password</label>
      </div>
      <div class="confirm-password-input">
        <input type="password" id="confirm-password" placeholder=" " />
        <label for="confirm-password">Confirm Password</label>
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>
