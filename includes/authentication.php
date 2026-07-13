<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if a user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Redirect if user is not logged in
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}

/**
 * Redirect logged-in users away from login/register pages
 */
function redirectIfLoggedIn()
{
    if (isLoggedIn()) {

        if ($_SESSION['role'] == 'admin') {

            header("Location: admin/dashboard.php");

        } else {

            header("Location: customer/dashboard.php");

        }

        exit();
    }
}