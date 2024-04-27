<?php
# check if username, password, name submitted
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name'])) {

    # database connection file
    include '../db.conn.php';

    # get data from POST request and store them in variables
    $name = $_POST['name'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    # making URL data format
    $data = 'name=' . $name . '&username=' . $username;

    # simple form validation
    if (empty($name)) {
        # error message
        $em = "Name is required";

        # redirect to 'signup.php' and pass error message
        header("Location: ../../signup.php?error=$em");
        exit;
    } elseif (empty($username)) {
        # error message
        $em = "Username is required";

        # redirect to 'signup.php' and pass error message and data
        header("Location: ../../signup.php?error=$em&$data");
        exit;
    } elseif (empty($password)) {
        # error message
        $em = "Password is required";

        # redirect to 'signup.php' and pass error message and data
        header("Location: ../../signup.php?error=$em&$data");
        exit;
    } else {
        # checking the database if the username is taken
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $em = "The username ($username) is taken";
            header("Location: ../../signup.php?error=$em&$data");
            exit;
        } else {
            # Profile Picture Uploading
            if (isset($_FILES['pp'])) {
                # get data and store them in variables
                $img_name = $_FILES['pp']['name'];
                $tmp_name = $_FILES['pp']['tmp_name'];
                $error = $_FILES['pp']['error'];

                # if there is no error occurred while uploading
                if ($error === 0) {
                    # get image extension and store it in a variable
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);

                    # convert the image extension into lower case and store it in a variable
                    $img_ex_lc = strtolower($img_ex);

                    # creating an array that stores allowed image extensions
                    $allowed_exs = array("jpg", "jpeg", "png");

                    # check if the image extension is present in the allowed extensions array
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        # renaming the image with user's username like: username.$img_ex_lc
                        $new_img_name = $username . '.' . $img_ex_lc;

                        # create upload path on the root directory
                        $img_upload_path = '../../uploads/' . $new_img_name;

                        # move uploaded image to ./uploads folder
                        move_uploaded_file($tmp_name, $img_upload_path);
                    } else {
                        $em = "You can't upload files of this type";
                        header("Location: ../../signup.php?error=$em&$data");
                        exit;
                    }
                }
            }

            // password hashing
            $password = password_hash($password, PASSWORD_DEFAULT);

            # if the user uploads Profile Picture
            if (isset($new_img_name)) {

                # inserting data into the database
                $sql = "INSERT INTO users (name, username, password, p_p) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $name, $username, $password, $new_img_name);
                $stmt->execute();
            } else {
                # inserting data into the database
                $sql = "INSERT INTO users (name, username, password) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $name, $username, $password);
                $stmt->execute();
            }

            # success message
            $sm = "Account created successfully";

            # redirect to 'index.php' and pass success message
            header("Location: ../../index.php?success=$sm");
            exit;
        }
    }
} else {
    header("Location: ../../signup.php");
    exit;
}
?>
