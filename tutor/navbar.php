<?php
    require_once "../bootstrap.php";
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../tutor/home.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="../tutor/timeslots.php">Time Slots</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../tutor/requests.php">Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../tutor/profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../tutor/subjects.php">Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../logout.php">Log out</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../tutor/conversations.php">Conversations</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Classes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../tutor/individualClasses.php">Individual</a></li>
                        <li><a class="dropdown-item" href="../tutor/groupClasses.php">Group</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

