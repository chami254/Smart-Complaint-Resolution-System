<?php

require_once '../includes/authentication.php';
require_once "../config/db.php";

requireAdmin();

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

/*=========================================
ADMIN DASHBOARD STATISTICS
=========================================*/

// Total Users
$stmt = $conn->query("
    SELECT COUNT(*) AS total_users
    FROM users
");

$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

// Complaint Statistics
$stmt = $conn->query("
    SELECT
        COUNT(*) AS total_complaints,
        SUM(status='Pending') AS pending,
        SUM(status='Resolved') AS resolved
    FROM complaints
");

$complaintStats = $stmt->fetch(PDO::FETCH_ASSOC);

// Latest Complaints
$stmt = $conn->query("
    SELECT
        complaints.id,
        complaints.title,
        complaints.status,
        complaints.created_at,
        users.full_name
    FROM complaints
    INNER JOIN users
        ON complaints.user_id = users.id
    ORDER BY complaints.created_at DESC
    LIMIT 5
");

$recentComplaints = $stmt->fetchAll(PDO::FETCH_ASSOC);



$stats = $stmt->fetch(PDO::FETCH_ASSOC);

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

            <h2><?= $totalUsers ?></h2>

            <p>Registered Users</p>

        </div>

        <div class="stat-card">

            <h2><?= $complaintStats['total_complaints'] ?? 0 ?></h2>

            <p>Total Complaints</p>

        </div>

        <div class="stat-card">

            <h2><?= $complaintStats['pending'] ?? 0 ?></h2>

            <p>Pending</p>

        </div>

        <div class="stat-card">

            <h2><?= $complaintStats['resolved'] ?? 0 ?></h2>

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

                <?php if(!empty($recentComplaints)): ?>

                    <?php foreach($recentComplaints as $complaint): ?>

                        <?php

                        switch($complaint['status']){

                            case "Pending":
                                $statusClass="pending";
                                break;

                            case "In Progress":
                                $statusClass="progress";
                                break;

                            case "Resolved":
                                $statusClass="resolved";
                                break;

                            default:
                                $statusClass="closed";

                        }

                        ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars($complaint['id']) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($complaint['full_name']) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($complaint['title']) ?>

                            </td>

                            <td>

                                <span class="status-badge <?= $statusClass ?>">

                                    <?= htmlspecialchars($complaint['status']) ?>

                                </span>

                            </td>

                            <td>

                                <?= date("d M Y", strtotime($complaint['created_at'])) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                <tr>

                    <td colspan="5">

                        No complaints available.

                    </td>

                </tr>

                <?php endif; ?>

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

            <a href="user.php" class="action-card">

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