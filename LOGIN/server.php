<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// initializing variables
$username = "";
$email = "";
$errors = [];

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'test_sample');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // ... (unchanged)

    // Finally, register user if there are no errors in the form
    if (empty($errors)) {
        $hashed_password = password_hash($password_1, PASSWORD_BCRYPT); // use bcrypt for password hashing

        $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$hashed_password')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
        exit; // Add exit to prevent further execution
    }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    // ... (unchanged)

    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $results = mysqli_query($db, $query);

        if ($results && mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('location: index.php');
                exit; // Add exit to prevent further execution
            } else {
                $errors[] = "Wrong password";
            }
        } else {
            $errors[] = "Username not found";
        }
    }
}

// Other parts of your script...
?>
