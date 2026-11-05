<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";


/* =========================
   GET ALL PROJECTS
========================= */

$stmt = $conn->prepare(
    "SELECT projects.id,
            projects.project_name,
            projects.service,
            projects.status,
            projects.start_date,
            projects.completion_date,
            projects.cancellation_allowed,
            users.name AS customer_name,
            users.email AS customer_email
     FROM projects
     INNER JOIN users
     ON projects.user_id = users.id
     ORDER BY projects.id DESC"
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

    <title>Projects - Scorps Designs</title>

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

        .status {
            padding: 6px 10px;
            background: #222;
            border-radius: 4px;
            color: #e00000;
        }

        .allowed {
            color: #4caf50;
        }

        .not-allowed {
            color: #e00000;
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
        Projects
    </h1>


    <div class="table-box">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Customer</th>

                    <th>Project</th>

                    <th>Service</th>

                    <th>Status</th>

                    <th>Start Date</th>

                    <th>Completion</th>

                    <th>Cancellation</th>

                </tr>

            </thead>


            <tbody>

                <?php while ($project = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $project["id"]; ?>
                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $project["customer_name"]
                            );
                            ?>

                            <br>

                            <small>
                                <?php
                                echo htmlspecialchars(
                                    $project["customer_email"]
                                );
                                ?>
                            </small>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $project["project_name"]
                            );
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $project["service"]
                            );
                            ?>

                        </td>


                        <td>

                            <span class="status">

                                <?php
                                echo htmlspecialchars(
                                    $project["status"]
                                );
                                ?>

                            </span>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $project["start_date"]
                            );
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $project["completion_date"]
                            );
                            ?>

                        </td>


                        <td>

                            <?php if ($project["cancellation_allowed"]): ?>

                                <span class="allowed">
                                    Allowed
                                </span>

                            <?php else: ?>

                                <span class="not-allowed">
                                    Not Allowed
                                </span>

                            <?php endif; ?>

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