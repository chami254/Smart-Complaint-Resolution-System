<?php

require_once 'config/db.php';
require_once 'includes/authentication.php';

// Redirect logged-in users away

/*=====================================
    VARIABLES
=====================================*/

$errors = [];
$success = "";

$full_name = "";
$username = "";
$email = "";
$password = "";
$confirm_password = "";

/*=====================================
    FORM SUBMISSION
=====================================*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /*----------------------------
        SANITIZE INPUT
    -----------------------------*/

    $full_name = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    /*----------------------------
        VALIDATION
    -----------------------------*/

    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    /*----------------------------
        DATABASE CHECKS
    -----------------------------*/

    if (empty($errors)) {

        try {

            // Check Username
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                $errors[] = "Username already exists.";
            }

            // Check Email
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $errors[] = "Email already exists.";
            }

            /*----------------------------
                CREATE ACCOUNT
            -----------------------------*/

            if (empty($errors)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $defaultRole = "customer";

                $stmt = $conn->prepare("
                    INSERT INTO users
                    (full_name, username, email, password, role)
                    VALUES (?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $full_name,
                    $username,
                    $email,
                    $hashedPassword,
                    $defaultRole
                ]);

                $_SESSION['success'] = "Registration successful! Please login.";

                header("Location: login.php");
                exit();
            }

        } catch (PDOException $e) {

            $errors[] = "A database error occurred. Please try again.";

            // Uncomment during development only
            // $errors[] = $e->getMessage();

        }

    }

}

include 'includes/header.php';

?>
<div class="auth-page">

    <div class="auth-container">

        <?php include 'includes/auth-layout.php'; ?>

        <div class="auth-card">

            <div class="auth-logo">

                <img src="assets/images/logo.png" alt="SCRS Logo">

                <h2>Create Your Account</h2>

                <p style="color:white; margin-top:10px;">
                    Join SCRS and start managing complaints efficiently.
                </p>

            </div>

            <!-- Success/Error Messages -->
            <?php if(!empty($errors)): ?>

              <div class="alert alert-error">

              <?php foreach($errors as $error): ?>

              <div><?= htmlspecialchars($error) ?></div>

              <?php endforeach; ?>

              </div>

              <?php endif; ?>

              <?php if($success): ?>

              <div class="alert alert-success">

              <?= htmlspecialchars($success) ?>

              </div>

            <?php endif; ?>

            <form class="auth-form" action="#" method="POST">

                <div class="input-group">

                    <input
                        type="text"
                        name="fullname"
                        placeholder="Full Name"
                        required>

                    <i class="fa-solid fa-user"></i>

                </div>

                <div class="input-group">

                    <input
                        type="text"
                        name="username"
                        placeholder="Username"
                        required>

                    <i class="fa-solid fa-user-tag"></i>

                </div>

                <div class="input-group">

                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        required>

                    <i class="fa-solid fa-envelope"></i>

                </div>

                <div class="input-group">

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        required>

                    <i
                        id="togglePassword"
                        class="fa-solid fa-eye"
                        style="cursor:pointer;">
                    </i>

                </div>

                <div class="input-group">

                    <input
                        id="confirmPassword"
                        type="password"
                        name="confirm_password"
                        placeholder="Confirm Password"
                        required>

                    <i
                        id="toggleConfirmPassword"
                        class="fa-solid fa-eye"
                        style="cursor:pointer;">
                    </i>

                </div>

                <!-- Password Strength -->

                <div id="strength-container">

                    <small style="color:white;">
                        Password Strength
                    </small>

                    <div class="strength-bar">

                        <div id="strength-fill"></div>

                    </div>

                    <small id="strength-text"></small>

                </div>

                <!-- Password Match -->

                <small id="password-match"></small>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Create Account

                </button>

            </form>

            <div class="auth-links">

                Already have an account?

                <a href="login.php">

                    Login

                </a>

            </div>

        </div>

    </div>

</div>

<?php
include 'includes/footer.php';
?>