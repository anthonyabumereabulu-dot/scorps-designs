<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";


/* =========================
   GET ALL MESSAGES
========================= */

$stmt = $conn->prepare(
    "SELECT id, name, email, phone, service, message, created_at
     FROM contact_messages
     ORDER BY id DESC"
);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Messages - Scorps Designs</title>

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
        }

        .navbar {
            padding: 20px 7%;
            background: #050505;
            border-bottom: 1px solid #222;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #e00000;
            font-size: 22px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #e00000;
        }

        .container {
            width: 94%;
            max-width: 1400px;
            margin: 50px auto;
        }

        h1 {
            color: #e00000;
            margin-bottom: 30px;
        }

        .table-box {
            background: #151515;
            border: 1px solid #252525;
            border-radius: 10px;
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #292929;
            vertical-align: top;
        }

        th {
            color: #e00000;
            background: #101010;
        }

        td {
            color: #ccc;
        }

        tr:hover {
            background: #1d1d1d;
        }

        .message {
            max-width: 350px;
            line-height: 1.5;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #aaa;
            text-decoration: none;
        }

        .back:hover {
            color: white;
        }

    </style>

</head>


<body>


<nav class="navbar">

    <div class="logo">
        Scorps Designs Admin
    </div>

    <div class="nav-links">

        <a href="admin.php">
            Dashboard
        </a>

        <a href="admin_logout.php">
            Logout
        </a>

    </div>

</nav>


<main class="container">


    <a href="admin.php" class="back">
        ← Back to Dashboard
    </a>


    <h1>
        Contact Messages
    </h1>


    <div class="table-box">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Service</th>

                    <th>Message</th>

                    <th>Date</th>

                </tr>

            </thead>


            <tbody>

                <?php while ($message = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $message["id"]; ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $message["name"]
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $message["email"]
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $message["phone"]
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $message["service"]
                            );
                            ?>
                        </td>


                        <td class="message">
                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $message["message"]
                                )
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $message["created_at"]
                            );
                            ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>


</main>


</body>

</html>


<?php

$stmt->close();
$conn->close();

?>