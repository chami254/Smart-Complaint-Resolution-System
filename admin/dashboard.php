<?php

require_once '../includes/authentication.php';

requireLogin();

requireRole('Admin');

?>
<a href="../logout.php" class="logout-btn">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
</a>