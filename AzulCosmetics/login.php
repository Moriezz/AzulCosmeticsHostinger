<?php
session_start(); 
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user_id and hashed password
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, fetch the data
        $stmt->bind_result($user_id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, store user_id and email in session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;

            // Redirect based on email domain
            if (strpos($email, '@admin.net') !== false) {
                echo "<script>alert('Login successful! Welcome, Admin.'); window.location.href='admin.php';</script>";
            } else {
                echo "<script>alert('Login successful! Welcome back.'); window.location.href='index.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.location.href='astrogear-login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with that email address.'); window.location.href='astrogear-login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
