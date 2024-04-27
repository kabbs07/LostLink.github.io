<?php  
session_start();

# check if username & password submitted
if (isset($_POST['username']) && isset($_POST['password'])) {

    # database connection file
    include '../db.conn.php';

    # get data from POST request and store them in variables
    $password = $_POST['password'];
    $username = $_POST['username'];

    # simple form validation
    if (empty($username)) {
        # error message
        $em = "Username is required";

        # redirect to 'index.php' and pass error message
        header("Location: ../../index.php?error=$em");
        exit;
    } elseif (empty($password)) {
        # error message
        $em = "Password is required";

        # redirect to 'index.php' and pass error message
        header("Location: ../../index.php?error=$em");
        exit;
    } else {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        # if the username exists
        if ($result->num_rows === 1) {
            # fetching user data
            $user = $result->fetch_assoc();

            # verifying the encrypted password
            if (password_verify($password, $user['password'])) {
                # successfully logged in
                # creating the SESSION
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['user_id'] = $user['user_id'];

                # redirect to 'home.php'
                header("Location: ../../home.php");
                exit;
            } else {
                # error message
                $em = "Incorrect Username or password";

                # redirect to 'index.php' and pass error message
                header("Location: ../../index.php?error=$em");
                exit;
            }
        } else {
            # error message
            $em = "Incorrect Username or password";

            # redirect to 'index.php' and pass error message
            header("Location: ../../index.php?error=$em");
            exit;
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}
?>
