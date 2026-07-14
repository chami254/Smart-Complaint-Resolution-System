<?php
require_once "../config/db.php";
$pageTitle = "Complaint Management";

require_once "../includes/authentication.php";
requireLogin();

include "../includes/dashboard_header.php";
include "../includes/dashboard_sidebar.php";

/*=========================================
GET COMPLAINT STATISTICS
=========================================*/

$stmt = $conn->query("
    SELECT
        COUNT(*) AS total,
        SUM(status='Pending') AS pending,
        SUM(status='In Progress') AS in_progress,
        SUM(status='Resolved') AS resolved
    FROM complaints
");

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$stats['total'] = $stats['total'] ?? 0;
$stats['pending'] = $stats['pending'] ?? 0;
$stats['in_progress'] = $stats['in_progress'] ?? 0;
$stats['resolved'] = $stats['resolved'] ?? 0;

/*=========================================
GET ALL COMPLAINTS
=========================================*/

$stmt = $conn->query("

    SELECT

        complaints.*,

        customer.full_name AS customer_name,

        admin.full_name AS admin_name

    FROM complaints

    INNER JOIN users AS customer

        ON complaints.user_id = customer.id

    LEFT JOIN users AS admin

        ON complaints.assigned_to = admin.id

    ORDER BY complaints.created_at DESC

");

$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="dashboard-content">

    <!-- ==========================================
         PAGE HEADER
    =========================================== -->

    <section class="page-header">

        <div>

            <h1>Complaint Management</h1>

            <p>

                View, monitor and manage all customer complaints.

            </p>

        </div>

    </section>


    <!-- ==========================================
         SUMMARY CARDS
    =========================================== -->

    <section class="complaint-summary">

        <div class="summary-card">

            <i class="fa-solid fa-folder-open"></i>

            <h2><?= $stats['total']; ?></h2>

            <span>Total Complaints</span>

        </div>

        <div class="summary-card pending">

            <i class="fa-solid fa-clock"></i>

            <h2><?= $stats['pending']; ?></h2>

            <span>Pending</span>

        </div>

        <div class="summary-card progress">

            <i class="fa-solid fa-spinner"></i>

            <h2><?= $stats['in_progress']; ?></h2>

            <span>In Progress</span>

        </div>

        <div class="summary-card resolved">

            <i class="fa-solid fa-circle-check"></i>

            <h2><?= $stats['resolved']; ?></h2>

            <span>Resolved</span>

        </div>

    </section>


    <!-- ==========================================
         SEARCH & FILTERS
    =========================================== -->

    <section class="complaint-toolbar">

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                placeholder="Search Ticket, Customer or Complaint">

        </div>

        <select>

            <option>All Status</option>

            <option>Pending</option>

            <option>In Progress</option>

            <option>Resolved</option>

            <option>Closed</option>

        </select>

        <select>

            <option>All Priority</option>

            <option>Critical</option>

            <option>High</option>

            <option>Medium</option>

            <option>Low</option>

        </select>

    </section>


    <!-- ==========================================
         COMPLAINT TABLE
    =========================================== -->

    <section class="table-container">

        <table class="complaints-table">

        <tbody>

<?php if (!empty($complaints)): ?>

    <?php foreach ($complaints as $complaint): ?>

    <?php

    switch ($complaint['status']) {

        case "Pending":
            $statusClass = "pending";
            break;

        case "In Progress":
            $statusClass = "progress";
            break;

        case "Resolved":
            $statusClass = "resolved";
            break;

        default:
            $statusClass = "closed";

    }

    switch ($complaint['priority']) {

        case "Critical":
            $priorityClass = "priority-critical";
            $priorityIcon = "🚨";
            break;

        case "High":
            $priorityClass = "priority-high";
            $priorityIcon = "🔴";
            break;

        case "Medium":
            $priorityClass = "priority-medium";
            $priorityIcon = "🟡";
            break;

        default:
            $priorityClass = "priority-low";
            $priorityIcon = "🔵";

    }

    ?>

    <tr>

        <td>

            <?= htmlspecialchars($complaint['ticket_no']) ?>

        </td>

        <td>

            <?= htmlspecialchars($complaint['customer_name']) ?>

        </td>

        <td>

            <?= htmlspecialchars($complaint['category']) ?>

        </td>

        <td>

            <span class="<?= $priorityClass ?>">

                <?= $priorityIcon ?>

                <?= htmlspecialchars($complaint['priority']) ?>

            </span>

        </td>

        <td>

            <span class="status-badge <?= $statusClass ?>">

                <?= htmlspecialchars($complaint['status']) ?>

            </span>

        </td>

        <td>

          <?php if (!empty($complaint['admin_name'])): ?>

            <?= htmlspecialchars($complaint['admin_name']) ?>

            <?php else: ?>

              <span class="unassigned">

                  Unassigned

              </span>

          <?php endif; ?>

        </td>

        <td>

            <?= date("d M Y", strtotime($complaint['created_at'])) ?>

        </td>

        <td>

            <a
                href="update_complaint.php?id=<?= $complaint['id'] ?>"
                class="btn-primary table-btn">

                Update

            </a>

        </td>

    </tr>

    <?php endforeach; ?>

<?php else: ?>

<tr>

    <td colspan="8" style="text-align:center;padding:40px;">

        No complaints found.

    </td>

</tr>

<?php endif; ?>

</tbody>

        </table>

    </section>

</main>

<?php include "../includes/dashboard_footer.php"; ?>