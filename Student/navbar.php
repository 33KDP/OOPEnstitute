<?php
require_once "../bootstrap.php";

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../Student/index.php">Home</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="../Student/tutorList.php">Tutors</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item">
                <a class="nav-link" href="../Student/profile.php">Profile Settings</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../logout.php">Log out</a>
            </li>
        </ul>
    </div>
</nav>

