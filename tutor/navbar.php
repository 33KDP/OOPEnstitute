<?php
    require_once "../bootstrap.php";
    $userid = $_SESSION['user_id'];
    $curTutor = Tutor::getInstance($_SESSION['user_id']);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand"  href="../tutor/home.php"><img src="../assets/img/logo2.PNG" alt="E-nstitute logo" style="width:200px;height:40px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?=htmlentities($curTutor->getFName()." ".$curTutor->getLName())?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../tutor/home.php">Home</a></li>
                        <li><a class="dropdown-item" href="../tutor/subjects.php">Subjects</a></li>
                        <li><a class="dropdown-item" href="../tutor/profile.php">Profile settings</a></li>
                        <li><a class="dropdown-item" href="../User/reviews.php">Reviews</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../logout.php">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

