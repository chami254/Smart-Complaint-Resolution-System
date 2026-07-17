<?php

$pageTitle = "Reports";

require_once "../includes/authentication.php";
require_once "../config/db.php";

requireAdmin();

include "../includes/dashboard_header.php";
include "../includes/dashboard_sidebar.php";

/*=========================================
REPORT STATISTICS
=========================================*/

// Total Users
$stmt = $conn->query("
    SELECT COUNT(*) AS total_users
    FROM users
");

$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

// Complaint Summary
$stmt = $conn->query("
    SELECT
        COUNT(*) AS total_complaints,
        SUM(status='Pending') AS pending,
        SUM(status='Resolved') AS resolved
    FROM complaints
");

$summary = $stmt->fetch(PDO::FETCH_ASSOC);

// Resolution Percentage
$resolutionRate = 0;

if ($summary['total_complaints'] > 0) {

    $resolutionRate = round(
        ($summary['resolved'] / $summary['total_complaints']) * 100
    );

}

/*=========================================
STATUS REPORT
=========================================*/

$stmt = $conn->query("

    SELECT

        status,

        COUNT(*) AS total

    FROM complaints

    GROUP BY status

");

$statusData = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Category Chart

$stmt = $conn->query("

    SELECT

        category,

        COUNT(*) AS total

    FROM complaints

    GROUP BY category

");

$categoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Priority Chart

$stmt = $conn->query("

    SELECT

        priority,

        COUNT(*) AS total

    FROM complaints

    GROUP BY priority

");

$priorityData = $stmt->fetchAll(PDO::FETCH_ASSOC);

//monthly trend

$stmt = $conn->query("

    SELECT

        DATE_FORMAT(created_at,'%b') AS month,

        COUNT(*) AS total

    FROM complaints

    GROUP BY YEAR(created_at), MONTH(created_at)

    ORDER BY YEAR(created_at), MONTH(created_at)

");

$monthlyData = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<script>

const reportData = {

    status: <?= json_encode($statusData); ?>,

    category: <?= json_encode($categoryData); ?>,

    priority: <?= json_encode($priorityData); ?>,

    monthly: <?= json_encode($monthlyData); ?>

};

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="../assets/js/reports.js"></script>

<main class="dashboard-content">

    <!-- ==========================================
         PAGE HEADER
    =========================================== -->

    <section class="page-header">

        <div>

            <h1>System Reports</h1>

            <p>

                View complaint trends and system performance.

            </p>

        </div>

    </section>

    <section class="stats-grid">

<div class="stat-card">

    <i class="fa-solid fa-users"></i>

    <h2><?= $totalUsers ?></h2>

    <p>Total Users</p>

</div>

<div class="stat-card">

    <i class="fa-solid fa-folder-open"></i>

    <h2><?= $summary['total_complaints'] ?></h2>

    <p>Total Complaints</p>

</div>

<div class="stat-card">

    <i class="fa-solid fa-circle-check"></i>

    <h2><?= $resolutionRate ?>%</h2>

    <p>Resolution Rate</p>

</div>

<div class="stat-card">

    <i class="fa-solid fa-clock"></i>

    <h2><?= $summary['pending'] ?></h2>

    <p>Pending Cases</p>

</div>

</section>

<section class="reports-grid">

  <div class="chart-card">

    <h3>Complaint Status</h3>

    <div class="chart-container">

        <canvas id="statusChart"></canvas>

    </div>

  </div>

    <div class="chart-card">

        <h3>Complaints by Category</h3>

        <div class="chart-container">
          <canvas id="categoryChart"></canvas>
        </div>

    </div>

    <div class="chart-card">

        <h3>Priority Distribution</h3>

        <div class="chart-container">
          <canvas id="priorityChart"></canvas>
        </div>

    </div>

    <div class="chart-card">

        <h3>Monthly Complaints</h3>

        <div class="chart-container">
          <canvas id="monthlyChart"></canvas>
        </div>

    </div>

</section>

<section class="info-card">

    <h2>Performance Overview</h2>

    <div class="progress-item">

        <span>Resolved Complaints</span>

        <div class="progress-bar">

            <div class="progress-fill resolved-progress"

                 style="width:72%;">

            </div>

        </div>

    </div>

    <div class="progress-item">

        <span>Pending Complaints</span>

        <div class="progress-bar">

            <div class="progress-fill pending-progress"

                 style="width:18%;">

            </div>

        </div>

    </div>

    <div class="progress-item">

        <span>In Progress</span>

        <div class="progress-bar">

            <div class="progress-fill progress-fill-yellow"

                 style="width:10%;">

            </div>

        </div>

    </div>

</section>

</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="../assets/js/reports.js"></script>

<?php include "../includes/dashboard_footer.php"; ?>