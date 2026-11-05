<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

require_once "database.php";

$user_id = $_SESSION["user_id"];


/* =========================
   GET USER INFORMATION
========================= */

$stmt = $conn->prepare(
    "SELECT name, email, phone
     FROM users
     WHERE id = ?"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();


/* =========================
   GET LATEST PROJECT
========================= */

$project_stmt = $conn->prepare(
    "SELECT project_name,
            service,
            description,
            status,
            start_date,
            completion_date,
            cancellation_allowed
     FROM projects
     WHERE user_id = ?
     ORDER BY id DESC
     LIMIT 1"
);

$project_stmt->bind_param("i", $user_id);
$project_stmt->execute();

$project_result = $project_stmt->get_result();

$project = $project_result->fetch_assoc();

$project_stmt->close();


/* =========================
   PREPARE COUNTDOWN
========================= */

$completion_timestamp = null;

if ($project && !empty($project["completion_date"])) {

    $completion_timestamp = strtotime(
        $project["completion_date"] . " 23:59:59"
    );

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Scorps Designs</title>

    <link rel="stylesheet" href="dashboard.css">

</head>


<body>


<!-- =========================
     NAVIGATION
========================= -->

<nav class="navbar">

    <div class="logo">
        Scorps Designs
    </div>

    <div class="nav-links">

        <a href="home.html">Home</a>

        <a href="services.html">Services</a>

        <a href="projects.html">Projects</a>

        <a href="about.html">About</a>

        <a href="contact.html">Contact</a>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </div>

</nav>


<!-- =========================
     DASHBOARD
========================= -->

<main class="dashboard">


    <!-- WELCOME -->

    <section class="welcome">

        <h1>
            Welcome,
            <?php echo htmlspecialchars($user["name"]); ?>
        </h1>

        <p>
            Welcome to your Scorps Designs customer dashboard.
        </p>

    </section>



    <!-- =========================
         ACCOUNT INFORMATION
    ========================= -->

    <section class="account-card">

        <h2>
            My Account
        </h2>

        <p>

            <strong>Name:</strong>

            <?php echo htmlspecialchars($user["name"]); ?>

        </p>


        <p>

            <strong>Email:</strong>

            <?php echo htmlspecialchars($user["email"]); ?>

        </p>


        <p>

            <strong>Phone:</strong>

            <?php echo htmlspecialchars($user["phone"]); ?>

        </p>

    </section>



    <!-- =========================
         PROJECT INFORMATION
    ========================= -->

    <section class="project-card">

        <h2>
            My Project
        </h2>


        <?php if ($project): ?>


            <h3>

                <?php
                echo htmlspecialchars(
                    $project["project_name"]
                );
                ?>

            </h3>


            <p>

                <strong>Service:</strong>

                <?php
                echo htmlspecialchars(
                    $project["service"]
                );
                ?>

            </p>


            <p>

                <strong>Status:</strong>

                <?php
                echo htmlspecialchars(
                    $project["status"]
                );
                ?>

            </p>


            <p>

                <strong>Start Date:</strong>

                <?php
                echo htmlspecialchars(
                    $project["start_date"]
                );
                ?>

            </p>


            <p>

                <strong>Expected Completion:</strong>

                <?php
                echo htmlspecialchars(
                    $project["completion_date"]
                );
                ?>

            </p>


            <!-- COUNTDOWN -->

            <p>

                <strong>Time Remaining:</strong>

                <?php if ($completion_timestamp): ?>

                    <span
                        id="countdown"
                        data-completion="<?php
                            echo $completion_timestamp * 1000;
                        ?>"
                    >
                        Calculating...
                    </span>

                <?php else: ?>

                    No completion date set.

                <?php endif; ?>

            </p>


            <!-- CANCELLATION -->

            <p>

                <strong>Cancellation:</strong>


                <?php if ($project["cancellation_allowed"]): ?>

                    <span class="allowed">
                        Allowed
                    </span>

                <?php else: ?>

                    <span class="not-allowed">
                        Not Allowed
                    </span>

                <?php endif; ?>

            </p>


            <!-- DESCRIPTION -->

            <p>

                <?php
                echo htmlspecialchars(
                    $project["description"]
                );
                ?>

            </p>


        <?php else: ?>


            <p class="status">
                No active project yet
            </p>


            <p>
                Once you request a project,
                your project information will appear here.
            </p>


        <?php endif; ?>


    </section>


</main>



<!-- =========================
     LIVE COUNTDOWN
========================= -->

<?php if ($completion_timestamp): ?>

<script>

function updateCountdown() {

    const countdown =
        document.getElementById("countdown");


    if (!countdown) {
        return;
    }


    const completionTime =
        Number(countdown.dataset.completion);


    const now =
        new Date().getTime();


    const difference =
        completionTime - now;


    if (difference <= 0) {

        countdown.textContent =
            "Completed";

        return;

    }


    const days =
        Math.floor(
            difference /
            (1000 * 60 * 60 * 24)
        );


    const hours =
        Math.floor(
            (difference /
            (1000 * 60 * 60)) % 24
        );


    const minutes =
        Math.floor(
            (difference /
            (1000 * 60)) % 60
        );


    const seconds =
        Math.floor(
            (difference /
            1000) % 60
        );


    countdown.textContent =
        days + " days, " +
        hours + " hours, " +
        minutes + " minutes, " +
        seconds + " seconds";

}


/* Run immediately */

updateCountdown();


/* Update every second */

setInterval(
    updateCountdown,
    1000
);

</script>

<?php endif; ?>


</body>

</html>


<?php

$conn->close();

?>