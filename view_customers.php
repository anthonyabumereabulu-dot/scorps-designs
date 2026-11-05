<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";


/* =========================
   GET CUSTOMERS
========================= */

$stmt = $conn->prepare(
    "SELECT id, name, email, phone, created_at
     FROM users
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

    <title>Customers - Scorps Designs</title>

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
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #e00000;
        }

        .container {
            width: 90%;
            max-width: 1200px;
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
            min-width: 700px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #292929;
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
        Customers
    </h1>


    <div class="table-box">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Joined</th>

                </tr>

            </thead>


            <tbody>

                <?php while ($customer = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $customer["id"]; ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $customer["name"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $customer["email"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $customer["phone"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $customer["created_at"]
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