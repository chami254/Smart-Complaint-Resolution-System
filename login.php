<?php

require_once 'config/db.php';
require_once 'includes/authentication.php';


$errors = [];

$errors = [];
$success = "";
$username = "";
$password = "";

// Display flash success message
if (isset($_SESSION['success'])) {

    $success = $_SESSION['success'];
    unset($_SESSION['success']);

}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  /*====================================
      SANITIZE INPUT
  ====================================*/

  $username = trim($_POST['username'] ?? "");
  $password = $_POST['password'] ?? "";

  /*====================================
      VALIDATION
  ====================================*/

  if (empty($username)) {
      $errors[] = "Username is required.";
  }

  if (empty($password)) {
      $errors[] = "Password is required.";
  }

  /*====================================
      AUTHENTICATION
  ====================================*/

  if (empty($errors)) {

      try {

          $stmt = $conn->prepare(
              "SELECT * FROM users WHERE username = ?"
          );

          $stmt->execute([$username]);

          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$user) {

              $errors[] = "Invalid username or password.";

          } else {

              if (!password_verify($password, $user['password'])) {

                  $errors[] = "Invalid username or password.";

              } else {

                  /*====================================
                      CREATE SESSION
                  ====================================*/

                  session_regenerate_id(true);

                  $_SESSION['user_id'] = $user['id'];

                  $_SESSION['full_name'] = $user['full_name'];

                  $_SESSION['username'] = $user['username'];

                  $_SESSION['role'] = $user['role'];

                  /*====================================
                      REDIRECT
                  ====================================*/

                  if ($user['role'] === "admin") {

                      header("Location: admin/dashboard.php");

                  } else {

                      header("Location: customer/dashboard.php");

                  }

                  exit();

              }

          }

      } catch (PDOException $e) {

          $errors[] = "A database error occurred.";

          // Uncomment while developing
          // $errors[] = $e->getMessage();

      }

  }

}

$username = "";

include 'includes/header.php';

?>

<div class="auth-page">

    <div class="auth-container">

        <?php include 'includes/auth-layout.php'; ?>

        <div class="auth-card">

            <div class="auth-logo">

                <img src="assets/images/logo.png" alt="SCRS Logo">

                <h2>Welcome Back</h2>

                <p style="color:white; margin-top:10px;">

                    Sign in to continue to your dashboard.

                </p>

            </div>

            <!-- Success Message -->

            <?php if(!empty($success)): ?>

                <div class="alert alert-success">

                    <?= htmlspecialchars($success); ?>

                </div>

            <?php endif; ?>

            <!-- Error Messages -->

            <?php if(!empty($errors)): ?>

                <div class="alert alert-error">

                    <?php foreach($errors as $error): ?>

                        <div><?= htmlspecialchars($error); ?></div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

            <form
                class="auth-form"
                method="POST"
                action="">

                <div class="input-group">

                    <input
                        type="text"
                        name="username"
                        placeholder="Username"
                        value="<?= htmlspecialchars($username); ?>"
                        required>

                    <i class="fa-solid fa-user"></i>

                </div>

                <div class="input-group">

                    <input
                        type="password"
                        id="loginPassword"
                        name="password"
                        placeholder="Password"
                        required>

                    <i
                        class="fa-solid fa-eye"
                        id="toggleLoginPassword"
                        style="cursor:pointer;"></i>

                </div>

                <div class="login-options">

                    <label>

                        <input type="checkbox">

                        Remember Me

                    </label>

                    <a href="#" onclick="return false;">

                        Forgot Password?

                    </a>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Login

                </button>

            </form>

            <div class="auth-links">

                Don't have an account?

                <a href="register.php">

                    Register

                </a>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>