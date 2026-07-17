<?php

$pageTitle = "User Management";

require_once "../includes/authentication.php";
require_once "../config/db.php";

requireAdmin();

include "../includes/dashboard_header.php";
include "../includes/dashboard_sidebar.php";

/*=========================================
USER STATISTICS
=========================================*/

$stmt = $conn->query("

    SELECT

        COUNT(*) AS total,

        SUM(role='customer') AS customers,

        SUM(role='admin') AS admins

    FROM users

");

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/*=========================================
GET USERS
=========================================*/

$stmt = $conn->query("

    SELECT

        full_name,

        username,

        email,

        role,

        created_at

    FROM users

    ORDER BY created_at DESC

");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="dashboard-content">

    <!-- ==========================================
         PAGE HEADER
    =========================================== -->

    <section class="page-header">

        <div>

            <h1>User Management</h1>

            <p>

                View all registered users in the system.

            </p>

        </div>

    </section>

    <!-- ==========================================
         SUMMARY CARDS
    =========================================== -->

    <section class="complaint-summary">

        <div class="summary-card">

            <i class="fa-solid fa-users"></i>

            <h2><?= $stats['total']; ?></h2>

            <span>Total Users</span>

        </div>

        <div class="summary-card">

            <i class="fa-solid fa-user"></i>

            <h2><?= $stats['customers']; ?></h2>

            <span>Customers</span>

        </div>

        <div class="summary-card">

            <i class="fa-solid fa-user-shield"></i>

            <h2><?= $stats['admins']; ?></h2>

            <span>Administrators</span>

        </div>

    </section>

    <!-- ==========================================
         SEARCH
    =========================================== -->

    <section class="complaint-toolbar">

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                placeholder="Search by name, username or email">

        </div>

    </section>

    <!-- ==========================================
         USERS TABLE
    =========================================== -->

    <section class="table-container">

        <table class="complaints-table">

            <thead>

                <tr>

                    <th>Name</th>

                    <th>Username</th>

                    <th>Email</th>

                    <th>Role</th>

                    <th>Registered</th>

                </tr>

            </thead>

            <tbody>

              <?php if (!empty($users)): ?>

              <?php foreach ($users as $user): ?>

              <tr>

                  <td>

                      <?= htmlspecialchars($user['full_name']) ?>

                  </td>

                  <td>

                      <?= htmlspecialchars($user['username']) ?>

                  </td>

                  <td>

                      <?= htmlspecialchars($user['email']) ?>

                  </td>

                  <td>

                      <span class="role <?= strtolower($user['role']) ?>">

                          <?= ucfirst($user['role']) ?>

                      </span>

                  </td>

                  <td>

                      <?= date("d M Y", strtotime($user['created_at'])) ?>

                  </td>

              </tr>

              <?php endforeach; ?>

              <?php else: ?>

              <tr>

                  <td colspan="5" style="text-align:center; padding:30px;">

                      No users found.

                  </td>

              </tr>

              <?php endif; ?>

              </tbody>

        </table>

    </section>

</main>

<?php include "../includes/dashboard_footer.php"; ?>