<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/StudentGroupProxy.php";

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
        <?php
            require_once "navbar.php";
            check_session();
        ?>
        <div class="container p-5">
            <?php
                $requests = $curTutor->getRequests();
                if (!isset($requests)){
                    echo 'No Requests';
                } else {
                    foreach ($requests as $request) {
                        $subject = Subject::getInstance($request->getSubjectId());
                        $senderId = $request->getSenderId();
                        if ($request->getType() == 0){
                            $note = 'Individual request';
                            $sender = Student::getInstance(Student::getUserId($senderId));
                            $name = $sender->getFname().' '.$sender->getLname();
                        } else {
                            $note = 'Group request';
                            $sender = new StudentGroupProxy($senderId);
                            $name = $sender->getName();
                        }
                        echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                                      <div class="card-body">
                                        <h5 class="card-title">' . htmlentities($subject->getName()).': Grade '.htmlentities($subject->getGrade()).', '.htmlentities($subject->getMedium()).' medium</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'.$note.' by '.$name.'</h6>
                                            <a href="viewRequest.php?reqId='.$request->getId().'"><button class="btn btn-primary btn-sm" >View</button></a>
                                      </div>
                                </div>';
                    }
                }
            ?>
        </div>
    </body>
</html>