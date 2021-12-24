<?php
    session_start();
    require_once "../classes/Timeslot.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/Subject.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
?>

<html>
    <head>
        <?php require_once "../bootstrap.php"; ?>
        <?php require_once "head.php"; ?>
    </head>
    <body>
        <?php require_once "navbar.php"; ?>
        <?php
        echo '<div class="container p-4">';
        echo '<div class="row">';
        foreach ($curTutor->getGrpClasses() as $class) {
            $subject = Subject::getInstance($class->getSubject());

            //$group = Student::getInstance(Student::getUserId($class->getStudentId()));
            $group = null;
            echo '<div class="col-4">';
            echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                                    <div class="card-body">
                                        <h5 class="card-title">'.htmlentities($subject->getName()).': Grade'.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' medium</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <a href="../tutor/viewGroup.php?gid='.$class->getGroupId().'">'.htmlentities($group->getName()).'</a>
                                        </h6>
                                    </div>
                                </div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        ?>
    </body>
</html>

