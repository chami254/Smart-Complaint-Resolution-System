<?php

$isAdmin = ($_SESSION['role'] === "admin");

?>

<aside class="sidebar">

    <div class="sidebar-logo">

        <img src="../assets/images/logo.png" alt="SCRS Logo">

        

    </div>

    <nav>

        <ul>

            <li>

              <a href="dashboard.php"
              class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>">

                    <i class="fa-solid fa-house"></i>

                    Dashboard

                </a>

            </li>

            <?php if($isAdmin): ?>

                <li>

                <a href="complaints.php"
                class="<?= ($activePage === 'complaints.php') ? 'active' : '' ?>">

                        <i class="fa-solid fa-folder-open"></i>

                        Manage Complaints

                    </a>

                </li>

                <li>

                <a href="user.php"
                class="<?= ($activePage === 'user') ? 'active' : '' ?>">

                        <i class="fa-solid fa-users"></i>

                        Users

                    </a>

                </li>

                <li>

                <a href="reports.php"
                class="<?= ($activePage === 'reports') ? 'active' : '' ?>">

                        <i class="fa-solid fa-chart-column"></i>

                        Reports

                    </a>

                </li>

            <?php else: ?>

                <li>

                <a href="submit_complaint.php"
                class="<?= ($activePage === 'submit_complaints') ? 'active' : '' ?>">

                        <i class="fa-solid fa-pen-to-square"></i>

                        Submit Complaint

                    </a>

                </li>

                <li>

                <a href="my_complaints.php"
                class="<?= ($activePage === 'my_complaints') ? 'active' : '' ?>">

                        <i class="fa-solid fa-folder"></i>

                        My Complaints

                    </a>

                </li>

                <li>

                    <a href="profile.php">

                        <i class="fa-solid fa-user"></i>

                        Profile

                    </a>

                </li>

            <?php endif; ?>

        </ul>

    </nav>

</aside>

<main class="dashboard-content">