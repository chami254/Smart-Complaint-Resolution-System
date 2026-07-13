<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);

function isActive($page)
{
    global $currentPage;
    return ($currentPage === $page) ? "active" : "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Complaint Resolution System</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav class="navbar">

    <a href="index.php" class="logo">

        <img src="images/logo.png" alt="SCRS Logo">

    </a>

    <ul class="nav-links">

<?php if (!isset($_SESSION['user_id'])): ?>

        <li>

            <a class="<?= isActive('index.php'); ?>" href="index.php">

                Home

            </a>

        </li>

        <li>

            <a class="<?= isActive('login.php'); ?>" href="login.php">

                Login

            </a>

        </li>

        <li>

            <a class="nav-btn <?= isActive('register.php'); ?>"

               href="register.php">

                Register

            </a>

        </li>

<?php else: ?>

<?php if($_SESSION['role']=="admin"): ?>

        <li><a href="admin/dashboard.php">Dashboard</a></li>

        <li><a href="#">Complaints</a></li>

        <li><a href="#">Users</a></li>

        <li><a href="logout.php">Logout</a></li>

<?php else: ?>

        <li><a href="customer/dashboard.php">Dashboard</a></li>

        <li><a href="#">Submit Complaint</a></li>

        <li><a href="#">My Complaints</a></li>

        <li><a href="logout.php">Logout</a></li>

<?php endif; ?>

<?php endif; ?>

    </ul>

</nav>