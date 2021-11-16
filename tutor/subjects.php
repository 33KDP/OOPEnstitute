<?php
    require_once "head.php";
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";


    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);


    require_once "../bootstrap.php";
    require_once "navbar.php";
?>


    <div class="container p-5">
        <div>
            <form action="controllers/subjectController.php" method="POST" class="d-flex">
                <input class="form-control me-2 subject" type="search" placeholder="Search subjects" id="search" name="search" aria-label="Search">
                <input type="hidden" name="subId" id="subId">
                <input class="btn btn-outline-success" name="Add" value="Add" type="submit">
            </form>
        </div>

        <?php
        $subjects = $curTutor->getSubjects();
        if (!isset($subjects)){
            echo 'No subjects';
        } else {
            foreach ($subjects as $subject) {
                echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                            <div class="card-body">
                            <h5 class="card-title">' . htmlentities($subject->getName()) . '</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Grade ' . htmlentities($subject->getGrade()) . ' - ' . htmlentities($subject->getMedium()) . ' medium</h6>
                            <form action="controllers/subjectController.php" method="POST" class="d-flex m-0">
                                <input type="hidden" name="subId" value="' .$subject->getId().'">
                                <input type="hidden" name="tutorId" value="'.$curTutor->getId().'">
                                <input class="btn btn-secondary btn-sm" name="Remove" value="Remove" type="submit">
                            </form>
                            </div>
                    </div>';
            }
        }
        ?>
    </div>
        

<?php 
    include_once 'foot.php';
?>   