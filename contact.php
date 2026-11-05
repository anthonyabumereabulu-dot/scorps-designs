<?php

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $service = trim($_POST["service"]);
    $message = trim($_POST["message"]);


    /* Check required fields */

    if (
        empty($name) ||
        empty($email) ||
        empty($service) ||
        empty($message)
    ) {
        die("Please fill in all required fields.");
    }


    /* Save message */

    $stmt = $conn->prepare(
        "INSERT INTO contact_messages
        (name, email, phone, service, message)
        VALUES (?, ?, ?, ?, ?)"
    );


    $stmt->bind_param(
        "sssss",
        $name,
        $email,
        $phone,
        $service,
        $message
    );


    if ($stmt->execute()) {

        echo "Message sent successfully!";

    } else {

        echo "Something went wrong. Please try again.";

    }


    $stmt->close();
    $conn->close();

}

?>