<?php

$pageTitle = "Update Complaint";

require_once "../config/db.php";
require_once "../includes/authentication.php";

requireAdmin();

/*=========================================
VALIDATE COMPLAINT ID
=========================================*/

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    header("Location: complaints.php");
    exit();

}

$complaintId = (int) $_GET["id"];

/*=========================================
LOAD COMPLAINT DETAILS
=========================================*/

$stmt = $conn->prepare("

    SELECT

        complaints.*,

        customer.full_name AS customer_name

    FROM complaints

    INNER JOIN users AS customer

        ON complaints.user_id = customer.id

    WHERE complaints.id = ?

");

$stmt->execute([$complaintId]);

$complaint = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$complaint) {

    header("Location: complaints.php");
    exit();

}

/*=========================================
LOAD ADMINISTRATORS
=========================================*/

$stmt = $conn->prepare("

    SELECT

        id,

        full_name

    FROM users

    WHERE role = 'admin'

    ORDER BY full_name

");

$stmt->execute();

$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*=========================================
UPDATE COMPLAINT
=========================================*/

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $status = trim($_POST["status"] ?? "");

    $priority = trim($_POST["priority"] ?? "");

    $resolution_notes = trim($_POST["resolution_notes"] ?? "");

    $assigned_to = $_POST["assigned_to"] ?? "";

    /*-----------------------------
    Validation
    -----------------------------*/

    if (empty($status)) {

        $errors[] = "Status is required.";

    }

    if (empty($priority)) {

        $errors[] = "Priority is required.";

    }

    /*-----------------------------
    Validate Administrator
    -----------------------------*/

    if ($assigned_to === "") {

        $assigned_to = null;

    } else {

        $check = $conn->prepare("

            SELECT id

            FROM users

            WHERE id = ?

            AND role = 'admin'

        ");

        $check->execute([$assigned_to]);

        if (!$check->fetch()) {

            $errors[] = "Invalid administrator selected.";

        }

    }

    /*-----------------------------
    Update Complaint
    -----------------------------*/

    if (empty($errors)) {

        $stmt = $conn->prepare("

            UPDATE complaints

            SET

                assigned_to = ?,

                status = ?,

                priority = ?,

                resolution_notes = ?

            WHERE id = ?

        ");

        $stmt->execute([

            $assigned_to,

            $status,

            $priority,

            $resolution_notes,

            $complaintId

        ]);

        header("Location: complaints.php?updated=1");

        exit();

    }

}

include "../includes/dashboard_header.php";
include "../includes/dashboard_sidebar.php";

?>

<main class="dashboard-content">

    <!-- ==========================================
         PAGE HEADER
    =========================================== -->

    <section class="page-header">

        <div>

            <h1>Update Complaint</h1>

            <p>

                Review complaint details and update its progress.

            </p>

        </div>

    </section>

    <form action="#" method="POST">

        <!-- ==========================================
             COMPLAINT INFORMATION
        =========================================== -->

        <section class="info-card">

            <h2>Complaint Information</h2>

            <div class="update-grid">

                <div class="form-group">

                    <label>Ticket Number</label>

                    "<?= htmlspecialchars($complaint['ticket_no']) ?>"

                </div>

                <div class="form-group">

                    <label>Customer</label>

                   "<?= htmlspecialchars($complaint['customer_name']) ?>"

                </div>

                <div class="form-group">

                    <label>Category</label>

                  "<?= htmlspecialchars($complaint['category']) ?>"

                </div>

                <div class="form-group">

                    <label>Submitted</label>

                   "<?= date('d M Y', strtotime($complaint['created_at'])) ?>"

                </div>

            </div>

        </section>


        <!-- ==========================================
             COMPLAINT DETAILS
        =========================================== -->

        <section class="info-card">

            <h2>Complaint Details</h2>

            <div class="form-group">

                <label>Complaint Title</label>

                <input
                value="<?= htmlspecialchars($complaint['title']) ?>">

            </div>

            <div class="form-group">

                <label>Description</label>

                <textarea
                    rows="6"
                    readonly>Internet has been unavailable since Monday morning...</textarea>

            </div>

            <div class="form-group">

                <label>Attachment</label>

                <div class="attachment-preview">

                    <i class="fa-solid fa-paperclip"></i>

                    No attachment uploaded.

                </div>

            </div>

        </section>


        <!-- ==========================================
             ADMIN ACTIONS
        =========================================== -->

        <section class="info-card">

            <h2>Administration</h2>

            <div class="update-grid">

                <div class="form-group">

                    <label>Assign Administrator</label>

                    <select name="assigned_to">

    <option value="">

        Unassigned

    </option>

    <?php foreach ($admins as $admin): ?>

        <option

            value="<?= $admin['id']; ?>"

            <?= ($complaint['assigned_to'] == $admin['id']) ? "selected" : ""; ?>

        >

            <?= htmlspecialchars($admin['full_name']); ?>

        </option>

    <?php endforeach; ?>

</select>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select name="status">

                        <option>Pending</option>

                        <option selected>In Progress</option>

                        <option>Resolved</option>

                        <option>Closed</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Priority</label>

                    <select name="priority">

                        <option>Critical</option>

                        <option selected>High</option>

                        <option>Medium</option>

                        <option>Low</option>

                    </select>

                </div>

            </div>

        </section>


        <!-- ==========================================
             RESOLUTION NOTES
        =========================================== -->

        <section class="info-card">

            <h2>Resolution Notes</h2>

            <div class="form-group">

                <textarea
                    name="resolution_notes"
                    rows="8"
                    placeholder="Enter resolution notes..."></textarea>

            </div>

        </section>


        <!-- ==========================================
             ACTION BUTTONS
        =========================================== -->

        <section class="form-actions">

            <button
                type="submit"
                class="btn-primary">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Changes

            </button>

            <a
                href="complaints.php"
                class="btn-secondary">

                Cancel

            </a>

        </section>

    </form>

</main>

<?php include "../includes/dashboard_footer.php"; ?>