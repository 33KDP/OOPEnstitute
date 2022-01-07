<?php
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Subject.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/StudentGroupProxy.php";
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
        <?php require_once "navbar.php";
            check_session();
            $request = new EnrollRequest($_GET['reqId']);
            $subject = Subject::getInstance($request->getSubjectId());
            $senderId = $request->getSenderId();
            $isGroup = false;

            if ($request->getType() == 0){
                $note = 'Individual request';
                $sender = Student::getInstance(Student::getUserId($senderId));
                $getUrl='../tutor/viewStudent.php?sid='.$senderId;
                $senderName = $sender->getFName().' '.$sender->getLName();
            } else {
                $isGroup = true;
                $note = 'Group request';
                $sender = new StudentGroupProxy($senderId);
                $getUrl='../Group/groupDetails.php?id='.$sender->getGroupId().'&type=view&tid='.$curTutor->getTutorId();
                $senderName = $sender->getName();
            }
            echo '<div class="container p-5">';
            echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                      <div class="card-body">
                        <h5 class="card-title">' . htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' medium</h5>
                        <h6 class="card-subtitle mb-2 text-muted">'.$note.' by <a href='.$getUrl.'>'.$senderName.'</a></h6>
                        <p>';
                            echo htmlentities($request->getMessage());
                            echo
                        '</p>
                        <form action="../tutor/controllers/requestController.php" method="POST" class="d-flex m-0">
                            <input type="hidden" name="reqId" value="' .$request->getId().'">
                            <input type="hidden" name="tutorId" value="'.$curTutor->getTutorId().'">
                            <input type="hidden" name="senderId" value="'.$senderId.'">
                            <input type="hidden" name="type" value="'.$request->getType().'">
                            <input type="hidden" name="subjectId" value="'.$request->getSubjectId().'">
                            <input class="btn btn-success btn-sm" name="Accept" value="Accept" type="submit">
                            <input class="btn btn-danger btn-sm mx-3" name="Reject" value="Reject" type="submit">';
                            if ($isGroup !== false){
                                //send message to group?
                            } else {
                                echo '<a class="btn btn-secondary btn-sm mx-2" href="../User/message.php?receiver_id='.Student::getUserId($senderId).'">Message</a>';
                            }
                        echo'</form>
                      </div>
                </div>';