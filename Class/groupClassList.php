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

<?php require_once "../bootstrap.php"; ?>
<?php require_once "head.php"; ?>
<?php require_once "navbar.php"; ?>

<body>

<?php
echo '<div class="container">';
echo '<br/><h1>All Group Classes</h1><br/>';
echo '<br/>';

echo '<div class="container">';
foreach ($curStudent->getIndClasses() as $class) {
    $subject = Subject::getInstance($class->getSubject());
    $tutor = Tutor::getInstance(Tutor::getUserId($class->getTutor()));

    echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                            <div class="card-body">
                                <h5 class="card-title">'.htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' Medium</h5>
                                <h5 class="card-title" >Tutor: 
                                    <a href="individual_index.php?tid='.$tutor->getUserId($class->getTutor()).'">'.htmlentities($tutor->getFName()).' '.htmlentities($tutor->getLName()).'</a>
                                </h5>
                            </div>
                    </div>';
}
echo '</div>';
echo '<div><a href="../Student/index.php" class="btn btn-primary"> Back Home</a><div><br/>';
echo '</div>';
?>
</body>
</html>
