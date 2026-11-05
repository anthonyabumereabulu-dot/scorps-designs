<?php

session_start();

require_once "database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT id, name, email, password
         FROM admins
         WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin["password"])) {

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["admin_email"] = $admin["email"];

            header("Location: admin.php");
            exit();

        } else {

            $message = "Incorrect password.";

        }

    } else {

        $message = "No admin account found with that email.";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Scorps Designs</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0b0b0b;
            color: white;

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 90%;
            max-width: 420px;

            background: #151515;

            padding: 35px;

            border-radius: 10px;

            border: 1px solid #252525;
        }

        .logo {
            text-align: center;

            color: #e00000;

            font-size: 25px;

            font-weight: bold;

            margin-bottom: 10px;
        }

        h1 {
            text-align: center;

            font-size: 24px;

            margin-bottom: 30px;
        }

        label {
            display: block;

            margin-bottom: 8px;

            margin-top: 18px;
        }

        input {
            width: 100%;

            padding: 13px;

            background: #0b0b0b;

            color: white;

            border: 1px solid #333;

            border-radius: 5px;
        }

        input:focus {
            outline: none;

            border-color: #e00000;
        }

        button {
            width: 100%;

            margin-top: 25px;

            padding: 14px;

            background: #e00000;

            color: white;

            border: none;

            border-radius: 5px;

            cursor: pointer;

            font-size: 16px;
        }

        button:hover {
            background: #b00000;
        }

        .message {
            margin-bottom: 20px;

            padding: 12px;

            background: #222;

            border-radius: 5px;

            color: #e00000;

            text-align: center;
        }

        .back {
            display: block;

            text-align: center;

            margin-top: 20px;

            color: #aaa;

            text-decoration: none;

            font-size: 14px;
        }

        .back:hover {
            color: white;
        }

    </style>

</head>


<body>


<div class="login-box">


    <div class="logo">
        Scorps Designs
    </div>


    <h1>
        Admin Login
    </h1>


    <?php if (!empty($message)): ?>

        <div class="message">

            <?php echo htmlspecialchars($message); ?>

        </div>

    <?php endif; ?>


    <form method="POST">


        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            placeholder="Admin email"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >


        <button type="submit">
            Login
        </button>


    </form>


    <a href="home.html" class="back">
        ← Back to Website
    </a>


</div>


</body>

</html>

<?php

$conn->close();

?>