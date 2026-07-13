<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*=====================================
    REDIRECT IF LOGGED IN
=====================================*/

function redirectIfLoggedIn()
{
    if (isset($_SESSION['user_id'])) {

        if ($_SESSION['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: customer/dashboard.php");
        }

        exit();
    }
}

/*=====================================
    REQUIRE LOGIN
=====================================*/

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {

        header("Location: ../login.php");
        exit();

    }
}

/*=====================================
    REQUIRE ROLE
=====================================*/

function requireRole($role)
{
    if ($_SESSION['role'] !== $role) {

        header("Location: ../login.php");
        exit();

    }
}