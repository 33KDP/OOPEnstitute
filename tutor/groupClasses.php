<?php
    session_start();
    require_once "../classes/Timeslot.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/Subject.class.php";
    require_once  "../classes/GroupClass.class.php";

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
        echo '
            <div class="container p-4">
                <div class="row">
            ';
        foreach ($curTutor->getGrpClasses() as $class) {
            $subject = Subject::getInstance($class->getSubject());

            $groupClass = new GroupClass($class->getGroupId());
            $studentGroup = $groupClass->getStudentGroup();
            echo '
                <div class="col-4">
                    <div class="card mx-auto rounded-3 border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">'.htmlentities($subject->getName()).': Grade'.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' medium</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <a href="../Group/groupDetails.php?id='.$class->getGroupId().'&sid='.$subject->getId().'&type=view">'.htmlentities($studentGroup->getName()).'</a>
                            </h6>
                        </div>
                    </div>
                </div>
            ';
            // echo '
            //     <div class="card mx-auto rounded-3 border-0 shadow my-3">
            //         <div class="card-body">
            //             <h5 class="card-title">
            //                 <a href="groupDetails.php?id='.$class->getGroupID().'&sid='.$subject->getId().'&type=view" class=" stretched-link" style="text-decoration: none">'.htmlentities($class->getName()).'</a>
            //             </h5>
            //             <h5 class="card-title" >'.htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' Medium</h5>
            //         </div>
            //     </div>
            // ';
        }
        echo '
                </div>
            </div>
        ';
        ?>
    </body>
</html>

