<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

require_once "database.php";


/* =========================
   GET ALL CUSTOMERS
========================= */

$users_stmt = $conn->prepare(
    "SELECT id, name, email
     FROM users
     ORDER BY name ASC"
);

$users_stmt->execute();

$users_result = $users_stmt->get_result();


/* =========================
   CREATE PROJECT
========================= */

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST["user_id"];
    $project_name = trim($_POST["project_name"]);
    $service = trim($_POST["service"]);
    $description = trim($_POST["description"]);
    $status = trim($_POST["status"]);
    $start_date = $_POST["start_date"];
    $completion_date = $_POST["completion_date"];

    $cancellation_allowed =
        isset($_POST["cancellation_allowed"]) ? 1 : 0;


    /* Check required fields */

    if (
        empty($user_id) ||
        empty($project_name) ||
        empty($service) ||
        empty($start_date) ||
        empty($completion_date)
    ) {

        $message = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO projects
            (
                user_id,
                project_name,
                service,
                description,
                status,
                start_date,
                completion_date,
                cancellation_allowed
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issssssi",
            $user_id,
            $project_name,
            $service,
            $description,
            $status,
            $start_date,
            $completion_date,
            $cancellation_allowed
        );


        if ($stmt->execute()) {

            $message = "Project created successfully!";

        } else {

            $message = "Something went wrong. Please try again.";

        }

        $stmt->close();

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Create Project - Scorps Designs</title>

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
            width: 90%;
            max-width: 700px;
            margin: 50px auto;
        }

        h1 {
            margin-bottom: 30px;
            color: #e00000;
        }

        .form-box {
            background: #151515;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #252525;
        }

        label {
            display: block;
            margin-bottom: 8px;
            margin-top: 18px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            background: #0b0b0b;
            color: white;
            border: 1px solid #333;
            border-radius: 5px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .checkbox input {
            width: auto;
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
        }

    </style>

</head>


<body>


<nav class="navbar">

    <div class="logo">
        Scorps Designs
    </div>

    <div class="nav-links">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</nav>


<div class="container">

    <h1>
        Create Project
    </h1>


    <?php if (!empty($message)): ?>

        <div class="message">

            <?php echo htmlspecialchars($message); ?>

        </div>

    <?php endif; ?>


    <div class="form-box">

        <form method="POST">


            <!-- CUSTOMER -->

            <label>
                Customer
            </label>

            <select name="user_id" required>

                <option value="">
                    Select Customer
                </option>

                <?php while ($customer = $users_result->fetch_assoc()): ?>

                    <option value="<?php echo $customer["id"]; ?>">

                        <?php
                        echo htmlspecialchars(
                            $customer["name"]
                        );
                        ?>

                        -
                        
                        <?php
                        echo htmlspecialchars(
                            $customer["email"]
                        );
                        ?>

                    </option>

                <?php endwhile; ?>

            </select>


            <!-- PROJECT NAME -->

            <label>
                Project Name
            </label>

            <input
                type="text"
                name="project_name"
                placeholder="e.g. Living Room Decoration"
                required
            >


            <!-- SERVICE -->

            <label>
                Service
            </label>

            <select name="service" required>

                <option value="">
                    Select Service
                </option>

                <option value="Painting">
                    Painting
                </option>

                <option value="Event Decoration">
                    Event Decoration
                </option>

                <option value="Digital Decoration">
                    Digital Decoration
                </option>

                <option value="Other">
                    Other
                </option>

            </select>


            <!-- DESCRIPTION -->

            <label>
                Description
            </label>

            <textarea
                name="description"
                placeholder="Describe the project..."
            ></textarea>


            <!-- STATUS -->

            <label>
                Status
            </label>

            <select name="status">

                <option value="Pending">
                    Pending
                </option>

                <option value="In Progress">
                    In Progress
                </option>

                <option value="Completed">
                    Completed
                </option>

            </select>


            <!-- START DATE -->

            <label>
                Start Date
            </label>

            <input
                type="date"
                name="start_date"
                required
            >


            <!-- COMPLETION DATE -->

            <label>
                Expected Completion Date
            </label>

            <input
                type="date"
                name="completion_date"
                required
            >


            <!-- CANCELLATION -->

            <div class="checkbox">

                <input
                    type="checkbox"
                    name="cancellation_allowed"
                    checked
                >

                <label>
                    Allow customer to cancel project
                </label>

            </div>


            <!-- SUBMIT -->

            <button type="submit">

                Create Project

            </button>


        </form>

    </div>

</div>


</body>

</html>

<?php

$users_stmt->close();

$conn->close();

?>