<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*=========================================
LOGIN CHECK
=========================================*/

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/*=========================================
REQUIRE LOGIN
=========================================*/

function requireLogin()
{
    if (!isLoggedIn()) {

        header("Location: ../login.php");
        exit();
    }
}

/*=========================================
CUSTOMER ACCESS
=========================================*/

function requireCustomer()
{
    requireLogin();

    if ($_SESSION['role'] !== "customer") {

        header("Location: ../login.php");
        exit();
    }
}

/*=========================================
ADMIN ACCESS
=========================================*/

function requireAdmin()
{
    requireLogin();

    if ($_SESSION['role'] !== "admin") {

        header("Location: ../login.php");
        exit();
    }
}