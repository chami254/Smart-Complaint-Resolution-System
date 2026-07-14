<?php

require_once '../config/db.php';
require_once '../includes/authentication.php';

requireLogin();

$pageTitle = "Submit Complaint";
$activePage = "submit";

$errors = [];
$success = "";

$title = "";
$category = "";
$priority = "";
$description = "";

include '../includes/dashboard_header.php';
include '../includes/dashboard_sidebar.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $title = trim($_POST["title"] ?? "");
  $category = trim($_POST["category"] ?? "");
  $priority = trim($_POST["priority"] ?? "");
  $description = trim($_POST["description"] ?? "");

  /*========================================
    VALIDATION
========================================*/

if (empty($title)) {

  $errors[] = "Complaint title is required.";

}

if (empty($category)) {

  $errors[] = "Please select a category.";

}

if (empty($priority)) {

  $errors[] = "Please select a priority.";

}

if (empty($description)) {

  $errors[] = "Complaint description is required.";

}

}

$ticket_no = "SCRS-" . date("Ymd") . "-" . rand(100,999);

if (empty($errors)) {

  try {

      $ticket_no = "SCRS-" . date("Ymd") . "-" . rand(100,999);

      $stmt = $conn->prepare(

          "INSERT INTO complaints
          (
              user_id,
              ticket_no,
              title,
              category,
              description,
              priority,
              status
          )

          VALUES
          (
              ?,?,?,?,?,?,?
          )"

      );

      $stmt->execute([

          $_SESSION['user_id'],

          $ticket_no,

          $title,

          $category,

          $description,

          $priority,

          "Pending"

      ]);

      $success = "Complaint submitted successfully.";
      $modalTitle = "Complaint Submitted";

$modalMessage =
"Your complaint has been submitted successfully.";

$ticketNo = $ticket_no;

  }

  catch(PDOException $e){

      $errors[] = "Something went wrong.";

      // Development only
      // $errors[] = $e->getMessage();

  }

}

$title = "";
$category = "";
$priority = "";
$description = "";

?>

<div class="dashboard-page">

    <section class="form-card">

        <div class="page-heading">

            <h1>Submit a New Complaint</h1>

            <p>

                Please provide accurate information so our support
                team can resolve your complaint quickly.

            </p>

        </div>


        <?php if(!empty($errors)): ?>

          <div class="alert alert-error">

              <ul>

                  <?php foreach($errors as $error): ?>

                      <li><?= htmlspecialchars($error) ?></li>

                  <?php endforeach; ?>

              </ul>

          </div>

          <?php endif; ?>

          <?php if($success): ?>

          <div class="alert alert-success">

              <?= htmlspecialchars($success) ?>

          </div>

          <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <!-- Complaint Title -->

            <div class="form-group">

                <label>

                    Complaint Title

                </label>

                <input
                    type="text"
                    name="title"
                    placeholder="Enter complaint title"
                    required
                >

            </div>

            <!-- Row -->

            <div class="form-row">

                <div class="form-group">

                    <label>Category</label>

                    <select name="category" required>

                        <option value="">Select Category</option>

                        <option>Network Issue</option>

                        <option>Billing</option>

                        <option>Customer Service</option>

                        <option>Technical Support</option>

                        <option>Account Issue</option>

                        <option>Other</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Priority</label>

                    <select name="priority" required>

                        <option value="">Select Priority</option>

                        <option>Low</option>

                        <option>Medium</option>

                        <option>High</option>

                    </select>

                </div>

            </div>

            <!-- Description -->

            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    rows="8"
                    placeholder="Describe your complaint..."
                    required
                ></textarea>

            </div>

            <!-- Attachment -->

            <div class="attachment-section">

                <label
                    for="attachment"
                    class="attachment-btn">

                    <i class="fa-solid fa-paperclip"></i>

                    Attach File (Optional)

                </label>

                <input
                    type="file"
                    id="attachment"
                    name="attachment"
                    hidden
                >

                <span id="file-name">

                    No file selected

                </span>

            </div>

            <small class="attachment-note">

                Supported:
                JPG • PNG • PDF • DOCX (Max 5MB)

            </small>

            <!-- Submit -->

            <button
                type="submit"
                class="btn-primary submit-btn">

                <i class="fa-solid fa-paper-plane"></i>

                Submit Complaint

            </button>

        </form>

    </section>

</div>
<?php

if(!empty($success)){

    include "../includes/modal_success.php";

}

?>
<?php if(!empty($success)): ?>

<script>

document.addEventListener("DOMContentLoaded",function(){

    document
        .getElementById("successModal")
        .classList
        .add("show");

});

</script>

<?php endif; ?>
<?php include '../includes/dashboard_footer.php'; ?>