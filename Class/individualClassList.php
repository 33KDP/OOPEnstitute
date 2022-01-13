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

<?php

    if(isset($_POST['Disenroll'])){
        IndividualClass::disenroll($_POST);
        header('individualClassList.php?id='.$_SESSION['user_id'].'php');
    }

    require_once "../bootstrap.php";
    require_once "head.php";
    require_once "navbar.php";
 ?>

<body>

    <?php
        echo '
            <div class="container">
                <br/><h1>All Individual Classes</h1>
                <br/>
        ';

            echo '<div class="container px-0">';
                foreach ($curStudent->getIndClasses() as $class) {
                    $subject = Subject::getInstance($class->getSubject());
                    $tutor = Tutor::getInstance(Tutor::getUserId($class->getTutor()));

                    echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                            <div class="card-body">
                                <h5 class="card-title">'.htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' Medium</h5>
                                <h5 class="card-title" >Tutor: 
                                    <a href="../Student/viewTutor.php?tid='.$tutor->getTutorId($class->getTutor()).'" style="text-decoration: none">'.htmlentities($tutor->getFName()).' '.htmlentities($tutor->getLName()).'</a>
                                </h5>
                                <div>
                                 <button class="btn btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteEntry'.$class->getClassId().'">Disenroll</button>
                                </div>
                            </div>
                    </div>';
                    echo'<div class="modal fade" id="deleteEntry'.$class->getClassId(). '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="POST">
                          <div class="mb-3">
                            <label for="dayInput" class="form-label">You will not be able to undo this action.</label>
                          </div>     
                          <input type="hidden" name="classid" value="' .$class->getClassId().'">
                          <input type="hidden" name="tutorid" value="' .$class->getTutor().'">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="Disenroll" value="Disenroll" class="btn btn-danger">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>   
                </div>';
                }
            echo '</div><br/>';
                echo '<div><a href="../Student/index.php" class="btn btn-primary"> Back Home</a><div><br/>';
        echo '</div>';
    ?>

    <?php require_once '../Student/footer.php'; ?>
</body>
</html>
