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
echo '
    <div class="container">
        <br>
        <h1>All Groups</h1>
        <br>
        <div class="container px-0">
    ';
        foreach ($curStudent->getGroup() as $class) {
            $subject = Subject::getInstance($class->getSubjectId());

            echo '
                <div class="card mx-auto rounded-3 border-0 shadow my-3">
                    <div class="card-body pb-0">
                        <h5 class="card-title">
                            <a href="groupDetails.php?id='.$class->getGroupID().'&sid='.$subject->getId().'&type=view" class=" stretched-link" style="text-decoration: none">'.htmlentities($class->getName()).'</a>
                            <h5 class="card-title" >'.htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' Medium</h5>
                        </h5>
                    </div>
            ';
             if (($class->isClass()) !== false) {
                 echo '<div class=" my-2"><span class="badge rounded-pill bg-success mx-2">Tutor Assigned</span>';

             } else {
                 echo '<div class="my-2"><span class="badge rounded-pill bg-warning text-dark mx-2">Tutor not Assigned</span>';
             }

            if ($curStudent->getStudentId() == $class->getAdmin()) {
                echo '<span class="badge rounded-pill bg-danger">Admin</span>';
            }
                echo'</div>
                </div>';
        }?>

    </div><br/>

    <div><a href="../Student/index.php" class="btn btn-primary"> Back Home</a><div><br/>
</div>

<?php require_once "../Student/footer.php"; ?>
</body>
</html>
