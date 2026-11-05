<?php

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("An account with this email already exists.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, phone, password)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssss",
        $name,
        $email,
        $phone,
        $hashed_password
    );

    if ($stmt->execute()) {
        echo "Account created successfully!";
    } else {
        echo "Something went wrong. Please try again.";
    }

    $stmt->close();
    $check->close();
    $conn->close();
}

?>