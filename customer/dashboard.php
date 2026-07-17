<?php

require_once '../includes/authentication.php';
require_once "../config/db.php";

requireCustomer();

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

/*=========================================
CUSTOMER DASHBOARD STATISTICS
=========================================*/

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT
        COUNT(*) AS total,
        SUM(status='Pending') AS pending,
        SUM(status='In Progress') AS in_progress,
        SUM(status='Resolved') AS resolved
    FROM complaints
    WHERE user_id = ?
");

$stmt->execute([$userId]);

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/*=========================================
RECENT COMPLAINTS
=========================================*/

$stmt = $conn->prepare("
    SELECT
        id,
        ticket_no,
        title,
        status,
        created_at
    FROM complaints
    WHERE user_id = ?
    ORDER BY created_at DESC
    LIMIT 5
");

$stmt->execute([$userId]);

$recentComplaints = $stmt->fetchAll(PDO::FETCH_ASSOC);


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

            <h2><?= $stats['total'] ?? 0 ?></h2>

            <p>Total Complaints</p>

        </div>

        <div class="stat-card">

            <h2><?= $stats['pending'] ?? 0 ?></h2>

            <p>Pending</p>

        </div>

        <div class="stat-card">

            <h2><?= $stats['in_progress'] ?? 0 ?></h2>

            <p>In Progress</p>

        </div>

        <div class="stat-card">

            <h2><?= $stats['resolved'] ?? 0 ?></h2>

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

                    <th>Ticket No.</th>

                    <th>Subject</th>

                    <th>Status</th>

                    <th>Date Submitted</th>

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

                                <?= htmlspecialchars($complaint['ticket_no']) ?>

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

                        <td colspan="4">

                            You haven't submitted any complaints yet.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

        </table>

    </section>

</div>

<?php include '../includes/dashboard_footer.php'; ?>