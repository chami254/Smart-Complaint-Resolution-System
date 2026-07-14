<?php

require_once '../includes/authentication.php';

requireLogin();

$pageTitle = "Admin Dashboard";
$activePage = "dashboard";

$hour = date('H');

if ($hour < 12) {

    $greeting = "Good Morning";

} elseif ($hour < 18) {

    $greeting = "Good Afternoon";

} else {

    $greeting = "Good Evening";

}

include '../includes/dashboard_header.php';
include '../includes/dashboard_sidebar.php';

?>

<div class="dashboard-page">

    <!-- Welcome -->

    <section class="welcome-section">

        <h1>

            <?= $greeting ?>,

            <?= htmlspecialchars($_SESSION['full_name']) ?>

            👋

        </h1>

        <p>

            Here's an overview of the Smart Complaint Resolution System.

        </p>

    </section>

    <!-- Statistics -->

    <section class="stats-grid">

        <div class="stat-card">

            <h2>0</h2>

            <p>Registered Users</p>

        </div>

        <div class="stat-card">

            <h2>0</h2>

            <p>Total Complaints</p>

        </div>

        <div class="stat-card">

            <h2>0</h2>

            <p>Pending</p>

        </div>

        <div class="stat-card">

            <h2>0</h2>

            <p>Resolved</p>

        </div>

    </section>

    <!-- Recent Complaints -->

    <section class="recent-complaints">

        <div class="section-header">

            <h2>Latest Complaints</h2>

        </div>

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Customer</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="5">

                        No complaints available.

                    </td>

                </tr>

            </tbody>

        </table>

    </section>

    <!-- Quick Actions -->

    <section class="quick-actions">

        <h2>Quick Actions</h2>

        <div class="action-grid">

            <a href="complaints.php" class="action-card">

                <i class="fa-solid fa-folder-open"></i>

                <span>Manage Complaints</span>

            </a>

            <a href="users.php" class="action-card">

                <i class="fa-solid fa-users"></i>

                <span>Manage Users</span>

            </a>

            <a href="reports.php" class="action-card">

                <i class="fa-solid fa-chart-column"></i>

                <span>Reports</span>

            </a>

        </div>

    </section>

</div>

<?php include '../includes/dashboard_footer.php'; ?>