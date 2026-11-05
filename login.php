<?php

require_once "database.php";

// Start a session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Find the user by email
    $stmt = $conn->prepare(
        "SELECT id, name, email, password FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if account exists
    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        // Check the password against the stored hash
        if (password_verify($password, $user["password"])) {

            // Store user information in the session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            header("Location: dashboard.php");
            exit();

        } else {

            echo "Incorrect password.";

        }

    } else {

        echo "No account found with that email.";

    }

    $stmt->close();
    $conn->close();
}

?>