<?php

$pageTitle = "My Profile";

require_once "../config/db.php";
require_once "../includes/authentication.php";

requireCustomer();

$userId = $_SESSION["user_id"];

/*=========================================
LOAD USER DETAILS
=========================================*/

$stmt = $conn->prepare("

    SELECT

        id,
        full_name,
        username,
        email,
        role,
        created_at

    FROM users

    WHERE id = ?

");

$stmt->execute([$userId]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

/*=========================================
LOAD USER STATISTICS
=========================================*/

$stmt = $conn->prepare("

    SELECT

        COUNT(*) AS total,

        SUM(status='Pending') AS pending,

        SUM(status='In Progress') AS progress,

        SUM(status='Resolved') AS resolved

    FROM complaints

    WHERE user_id = ?

");

$stmt->execute([$userId]);

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/*=========================================
UPDATE PROFILE
=========================================*/

$success = "";
$errors = [];

if (
    isset($_POST["update_profile"])
) {

    $fullName = trim($_POST["full_name"]);

    $username = trim($_POST["username"]);

    $email = trim($_POST["email"]);

    if ($fullName == "") {

        $errors[] = "Full name is required.";

    }

    if ($username == "") {

        $errors[] = "Username is required.";

    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors[] = "Invalid email address.";

    }

    if (empty($errors)) {

        $stmt = $conn->prepare("

            UPDATE users

            SET

                full_name=?,
                username=?,
                email=?

            WHERE id=?

        ");

        $stmt->execute([

            $fullName,
            $username,
            $email,
            $userId

        ]);

        $_SESSION["full_name"] = $fullName;

        header("Location: profile.php?updated=1");

        exit();

    }

}

/*=========================================
CHANGE PASSWORD
=========================================*/

if (
    isset($_POST["change_password"])
) {

    $current = $_POST["current_password"];

    $new = $_POST["new_password"];

    $confirm = $_POST["confirm_password"];

    if (
        !password_verify(
            $current,
            $user["password"] ?? ""
        )
    ) {

        $errors[] = "Current password is incorrect.";

    }

    if ($new !== $confirm) {

        $errors[] = "Passwords do not match.";

    }

    if (empty($errors)) {

        $hash = password_hash(

            $new,

            PASSWORD_DEFAULT

        );

        $stmt = $conn->prepare("

            UPDATE users

            SET password=?

            WHERE id=?

        ");

        $stmt->execute([

            $hash,

            $userId

        ]);

        header("Location: profile.php?password=1");

        exit();

    }

}

include "../includes/dashboard_header.php";
include "../includes/dashboard_sidebar.php";

?>

<main class="dashboard-content">

<section class="page-header">

    <div>

        <h1>My Profile</h1>

        <p>

            Manage your account information and security.

        </p>

    </div>

</section>

<!-- Profile Card -->

<section class="profile-card">

    <div class="profile-avatar">

        <i class="fa-solid fa-user"></i>

    </div>

    <div>

        <h2>

            <?= htmlspecialchars($user["full_name"]); ?>

        </h2>

        <p>

            <?= htmlspecialchars($user["email"]); ?>

        </p>

    </div>

</section>

<!-- Statistics -->

<section class="stats-grid">

    <div class="stat-card">

        <h2><?= $stats["total"] ?? 0 ?></h2>

        <p>Total Complaints</p>

    </div>

    <div class="stat-card">

        <h2><?= $stats["pending"] ?? 0 ?></h2>

        <p>Pending</p>

    </div>

    <div class="stat-card">

        <h2><?= $stats["progress"] ?? 0 ?></h2>

        <p>In Progress</p>

    </div>

    <div class="stat-card">

        <h2><?= $stats["resolved"] ?? 0 ?></h2>

        <p>Resolved</p>

    </div>

</section>

<!-- Update Profile -->

<section class="form-card">

<h2>Profile Information</h2>

<form method="POST">

<div class="form-grid">

<input
type="text"
name="full_name"
value="<?= htmlspecialchars($user["full_name"]); ?>"
placeholder="Full Name">

<input
type="text"
name="username"
value="<?= htmlspecialchars($user["username"]); ?>"
placeholder="Username">

<input
type="email"
name="email"
value="<?= htmlspecialchars($user["email"]); ?>"
placeholder="Email">

</div>

<button
type="submit"
name="update_profile"
class="btn-primary">

<i class="fa-solid fa-floppy-disk"></i>

Save Changes

</button>

</form>

</section>

<!-- Password -->

<section class="form-card">

<h2>Change Password</h2>

<form method="POST">

<div class="form-grid">

<input
type="password"
name="current_password"
placeholder="Current Password">

<input
type="password"
name="new_password"
placeholder="New Password">

<input
type="password"
name="confirm_password"
placeholder="Confirm Password">

</div>

<button
type="submit"
name="change_password"
class="btn-primary">

<i class="fa-solid fa-lock"></i>

Update Password

</button>

</form>

</section>

<!-- Danger Zone -->

<section class="danger-zone">

<h2>

<i class="fa-solid fa-triangle-exclamation"></i>

Danger Zone

</h2>

<p>

Deleting your account will permanently remove all complaints and personal information.

</p>

<button
id="deleteAccountBtn"
class="btn-danger">

<i class="fa-solid fa-trash"></i>

Terminate Account

</button>

</section>

</main>
<?php

$confirmTitle = "Delete Account";

$confirmMessage = "This action is permanent. Your account and every complaint you've submitted will be permanently deleted. Do you wish to continue?";

$confirmAction = "delete_account.php";

include "../includes/modal_confirm.php";

?>

<?php include "../includes/dashboard_footer.php"; ?>