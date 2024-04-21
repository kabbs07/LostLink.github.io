<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: login.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'patrickjeri.garcia@gmail.com';                     //SMTP username
                        $mail->Password   = 'iuokimxkqntgdcuo';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('patrickjeri.garcia@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/LostLink.github.io/verification.php?code='.$code.'">http://localhost/login/verification.php?code='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    }
?>
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
        <?php echo $msg; ?> <!-- Display any messages here -->
        <form method="post">
            <div class="name-input">
                <input type="text" name="name" id="name" placeholder=" "  value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                <label for="name">Name</label>
            </div>
            <div class="email-input">
                <input type="email" name="email" id="email" placeholder=" " value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                <label for="email">Email</label>
            </div>
            <div class="password-input">
                <input type="password" class="password" name="password" id="password" placeholder=" " required />
                <label for="password">Password</label>
            </div>
            <div class="confirm-password-input">
                <input type="password" class="confirm-password" name="confirm-password" id="confirm-password" placeholder=" " required />
                <label for="confirm-password">Confirm Password</label>
            </div>
            <button type="submit" name="submit">Register</button>
        </form>
    </div>
</body>
</html>
