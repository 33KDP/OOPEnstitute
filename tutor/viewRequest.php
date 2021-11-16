<?php
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Subject.class.php";
    require_once "../classes/Student.class.php";
    session_start();
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
            $request = new EnrollRequest($_GET['reqId']);
            $subject = Subject::getInstance($request->getSubjectId());
            $senderId = $request->getSenderId();

            if ($request->getType() == 0){
                $note = 'Individual request';
                $sender = Student::getInstance(Student::getUserId($senderId));
                $getUrl='../viewStudent.php?sid='.$senderId;
            } else {
                $note = 'Group request';
                $getUrl='../viewStudent.php?gid='.$senderId;
            }
            echo '<div class="container p-5">';
            echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                      <div class="card-body">
                        <h5 class="card-title">' . htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' medium</h5>
                        <h6 class="card-subtitle mb-2 text-muted">'.$note.' by <a href="">'.$sender->getFName().' '.$sender->getLName().'</a></h6>
                        <p>';
                            echo htmlentities($request->getMessage());
                            echo
                        '</p>
                        <form action="controllers/requestController.php" method="POST" class="d-flex m-0">
                            <input type="hidden" name="reqId" value="' .$request->getSenderId().'">
                            <input type="hidden" name="tutorId" value="'.$curTutor->getId().'">
                            <input class="btn btn-success btn-sm" name="Accept" value="Accept" type="submit">
                            <input class="btn btn-danger btn-sm mx-3" name="Reject" value="Reject" type="submit">
                        </form>
                      </div>
                </div>';