<?php

$pageTitle = "My Complaints";

require_once "../config/db.php";
require_once "../includes/authentication.php";

requireCustomer();

include "../includes/dashboard_header.php";
include "../includes/dashboard_sidebar.php";

/*GET LOGGED-IN USER*/

$userId = $_SESSION['user_id'];

/*GET CUSTOMER COMPLAINTS*/

$stmt = $conn->prepare("
    SELECT *
    FROM complaints
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->execute([$userId]);

$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*GET COMPLAINT STATISTICS*/

$stmt = $conn->prepare("
    SELECT
        COUNT(*) AS total,
        SUM(status = 'Pending') AS pending,
        SUM(status = 'In Progress') AS in_progress,
        SUM(status = 'Resolved') AS resolved
    FROM complaints
    WHERE user_id = ?
");

$stmt->execute([$userId]);

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/* PREVENT NULL VALUES*/

$stats['total'] = $stats['total'] ?? 0;
$stats['pending'] = $stats['pending'] ?? 0;
$stats['in_progress'] = $stats['in_progress'] ?? 0;
$stats['resolved'] = $stats['resolved'] ?? 0;

?>

<main class="dashboard-content">

    <!-- PAGE HEADER-->

    <section class="page-header">

        <div>

            <h1>My Complaints</h1>

            <p>
                Track and monitor all complaints you have submitted.
            </p>

        </div>

    </section>


    <!-- SUMMARY CARDS -->

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
         COMPLAINT JOURNEY
    =========================================== -->

    <section class="complaint-journey">

        <h3>Complaint Journey</h3>

        <div class="journey-container">

            <div class="journey-step completed">

                <i class="fa-solid fa-file-circle-plus"></i>

                <span>Submitted</span>

            </div>

            <div class="journey-line"></div>

            <div class="journey-step pending">

                <i class="fa-solid fa-clock"></i>

                <span>Pending</span>

            </div>

            <div class="journey-line"></div>

            <div class="journey-step">

                <i class="fa-solid fa-spinner"></i>

                <span>In Progress</span>

            </div>

            <div class="journey-line"></div>

            <div class="journey-step">

                <i class="fa-solid fa-circle-check"></i>

                <span>Resolved</span>

            </div>

            <div class="journey-line"></div>

            <div class="journey-step">

                <i class="fa-solid fa-star"></i>

                <span>Feedback</span>

            </div>

        </div>

    </section>


    <!-- ==========================================
         SEARCH & FILTER
    =========================================== -->

    <section class="complaint-toolbar">

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                placeholder="Search by Ticket Number or Complaint Title">

        </div>

        <select>

            <option>All Status</option>
            <option>Pending</option>
            <option>In Progress</option>
            <option>Resolved</option>

        </select>

    </section>


    <!-- ==========================================
         COMPLAINT CARDS
    =========================================== -->
    <section class="complaints-grid">

<?php if (!empty($complaints)): ?>

    <?php foreach ($complaints as $complaint): ?>

        <?php

        /*=============================
        STATUS
        =============================*/

        switch ($complaint['status']) {

            case "Pending":
                $statusClass = "pending";
                $cardClass = "";
                $progressClass = "pending-progress";
                $progress = 25;
                break;

            case "In Progress":
                $statusClass = "progress";
                $cardClass = "progress-card";
                $progressClass = "progress-fill-yellow";
                $progress = 60;
                break;

            case "Resolved":
                $statusClass = "resolved";
                $cardClass = "resolved-card";
                $progressClass = "resolved-progress";
                $progress = 100;
                break;

            default:
                $statusClass = "pending";
                $cardClass = "";
                $progressClass = "pending-progress";
                $progress = 0;

        }

        /*=============================
        PRIORITY
        =============================*/

        switch ($complaint['priority']) {

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

        <div class="complaint-card <?= $cardClass ?>">

            <div class="card-top">

                <span class="ticket-number">

                    <?= htmlspecialchars($complaint['ticket_no']) ?>

                </span>

                <span class="status-badge <?= $statusClass ?>">

                    <?= htmlspecialchars($complaint['status']) ?>

                </span>

            </div>

            <h3>

                <?= htmlspecialchars($complaint['title']) ?>

            </h3>

            <p class="complaint-category">

                <i class="fa-solid fa-layer-group"></i>

                <?= htmlspecialchars($complaint['category']) ?>

            </p>

            <div class="card-details">

                <span>

                    Priority

                    <strong class="<?= $priorityClass ?>">

                        <?= $priorityIcon ?>

                        <?= htmlspecialchars($complaint['priority']) ?>

                    </strong>

                </span>

                <span>

                    Submitted

                    <strong>

                        <?= date("d M Y", strtotime($complaint['created_at'])) ?>

                    </strong>

                </span>

            </div>

            <div class="progress-section">

                <div class="progress-info">

                    <span>Complaint Progress</span>

                    <span><?= $progress ?>%</span>

                </div>

                <div class="progress-bar">

                    <div
                        class="progress-fill <?= $progressClass ?>"
                        style="width:<?= $progress ?>%;">

                    </div>

                </div>

            </div>

            <!-----<a
                href="complaint_details.php?id=<?= $complaint['id'] ?>"
                class="btn-primary details-btn">

                View Details

            </a>---->

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <div class="empty-state">

        <i class="fa-solid fa-folder-open"></i>

        <h2>No Complaints Yet</h2>

        <p>

            You haven't submitted any complaints yet.

            Start by submitting your first complaint.

        </p>

        <a
            href="submit_complaint.php"
            class="btn-primary">

            Submit Complaint

        </a>

    </div>

<?php endif; ?>

</section>
    

</main>

<?php include "../includes/dashboard_footer.php"; ?>