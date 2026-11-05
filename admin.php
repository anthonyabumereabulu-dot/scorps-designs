<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";


/* =========================
   COUNT CUSTOMERS
========================= */

$users_result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM users"
);

$total_users = $users_result->fetch_assoc()["total"];


/* =========================
   COUNT PROJECTS
========================= */

$projects_result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM projects"
);

$total_projects = $projects_result->fetch_assoc()["total"];


/* =========================
   COUNT MESSAGES
========================= */

$messages_result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM contact_messages"
);

$total_messages = $messages_result->fetch_assoc()["total"];

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Scorps Designs</title>

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

        .logout {
            background: #e00000;
            padding: 10px 16px;
            border-radius: 5px;
        }

        .container {
            width: 86%;
            max-width: 1200px;
            margin: 50px auto;
        }

        .welcome {
            margin-bottom: 35px;
        }

        .welcome h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #aaa;
        }

        .cards {
            display: grid;
            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            margin-bottom: 40px;
        }

        .card {
            background: #151515;
            border: 1px solid #252525;
            border-radius: 10px;
            padding: 30px;
        }

        .card h2 {
            color: #aaa;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .number {
            color: #e00000;
            font-size: 40px;
            font-weight: bold;
        }

        .actions {
            background: #151515;
            border: 1px solid #252525;
            border-radius: 10px;
            padding: 30px;
        }

        .actions h2 {
            color: #e00000;
            margin-bottom: 25px;
        }

        .buttons {
            display: grid;
            grid-template-columns:
                repeat(2, 1fr);

            gap: 15px;
        }

        .buttons a {
            text-decoration: none;
            background: #222;
            color: white;
            padding: 18px;
            border-radius: 6px;
            text-align: center;
            transition: 0.3s;
        }

        .buttons a:hover {
            background: #e00000;
        }

        @media (max-width: 768px) {

            .navbar {
                flex-direction: column;
                gap: 20px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .buttons {
                grid-template-columns: 1fr;
            }

            .welcome h1 {
                font-size: 28px;
            }

        }

    </style>

</head>


<body>


<nav class="navbar">

    <div class="logo">
        Scorps Designs Admin
    </div>

    <div class="nav-links">

        <a href="home.html">
            Website
        </a>

     <a href="admin_logout.php" class="logout">
        Logout
     </a>

    </div>

</nav>


<main class="container">


    <section class="welcome">

        <h1>
            Welcome, <?php
            echo htmlspecialchars($_SESSION["admin_name"]);
            ?>
        </h1>

        <p>
            Manage your Scorps Designs website from here.
        </p>

    </section>


    <section class="cards">


        <div class="card">

            <h2>
                Customers
            </h2>

            <div class="number">
                <?php echo $total_users; ?>
            </div>

        </div>


        <div class="card">

            <h2>
                Projects
            </h2>

            <div class="number">
                <?php echo $total_projects; ?>
            </div>

        </div>


        <div class="card">

            <h2>
                Contact Messages
            </h2>

            <div class="number">
                <?php echo $total_messages; ?>
            </div>

        </div>


    </section>


    <section class="actions">

        <h2>
            Quick Actions
        </h2>


        <div class="buttons">

            <a href="create_project.php">
                Create Project
            </a>

            <a href="view_customers.php">
                View Customers
            </a>

            <a href="view_projects.php">
                View Projects
            </a>

            <a href="view_messages.php">
                View Messages
            </a>

        </div>

    </section>


</main>


</body>

</html>

<?php

$conn->close();

?>