<?php
session_start();
require_once "../classes/Timeslot.class.php";
require_once "../classes/Tutor.class.php";
require_once "../classes/Student.class.php";
require_once "../classes/Subject.class.php";

if (!isset($_SESSION['user_id'])){
    header("location: ../index.php");
}
$curStudent=  Student::getInstance($_SESSION['user_id']);
?>

<html>
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "../Student/head.php"; ?>
    <?php require_once "navbar.php"; ?>
</head>
<body>

<?php
echo '<div class="container p-4">';
echo '<div class="row">';
foreach ($curStudent->getIndClasses() as $class) {
    $subject = Subject::getInstance($class->getSubject());

    $tutor = Tutor::getInstance(Tutor::getUserId($class->getTutor()));
    echo '<div class="col-4">';
    echo '<div class="card mx-auto rounded-3 border-0 shadow my-3 bg-dark">
                            <div class="card-body" style="color: #dddddd">
                                <h5 class="card-title">'.htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' Medium</h5>
                                <h5 class="card-title" >Tutor: 
                                    <a href="individual_index.php?tid='.$tutor->getUserId($class->getTutor()).'">'.htmlentities($tutor->getFName()).': '.htmlentities($tutor->getLName()).'</a>
                                </h5>
                            </div>
                        </div>';
    echo '</div>';
}
echo '</div>';
echo '</div>';
?>
</body>
</html>
