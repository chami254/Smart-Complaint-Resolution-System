<?php

require_once '../includes/authentication.php';

requireLogin();
requireRole('customer');

$pageTitle = "Customer Dashboard";
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

    <!-- Greeting -->

    <section class="welcome-section">

        <h1>

            <?= $greeting ?>,

            <?= htmlspecialchars($_SESSION['full_name']); ?>

            👋

        </h1>

        <p>

            Welcome back to the Smart Complaint Resolution System.

        </p>

    </section>

    <!-- Statistics -->

    <section class="stats-grid">

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

            <p>In Progress</p>

        </div>

        <div class="stat-card">

            <h2>0</h2>

            <p>Resolved</p>

        </div>

    </section>

    <!-- Recent Complaints -->

    <section class="recent-complaints">

        <div class="section-header">

            <h2>Recent Complaints</h2>

            <a href="submit_complaint.php" class="btn btn-primary">

                + Submit Complaint

            </a>

        </div>

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Subject</th>

                    <th>Status</th>

                    <th>Date Submitted</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="4">

                        You haven't submitted any complaints yet.

                    </td>

                </tr>

            </tbody>

        </table>

    </section>

</div>

<?php include '../includes/dashboard_footer.php'; ?>