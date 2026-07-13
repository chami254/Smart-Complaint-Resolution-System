<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? "Dashboard";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> | SCRS</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="dashboard">

    <header class="topbar">

        <div class="topbar-left">

            <h2>SCRS</h2>

        </div>

        <div class="topbar-right">

            <span>

                Welcome,

                <strong>

                    <?= htmlspecialchars($_SESSION['full_name']) ?>

                </strong>

            </span>

            <a href="#"
                id="logoutBtn"
                class="logout-btn">

                <i class="fa-solid fa-right-from-bracket"></i>

                    Logout
                </a>

        </div>

    </header>