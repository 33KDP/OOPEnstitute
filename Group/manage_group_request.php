<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
require_once "../classes/StudentGroupProxy.php";


if (!isset($_SESSION['user_id'])){
    header("location: ../index.php");
}
$curStudent=  Student::getInstance($_SESSION['user_id']);
?>

<html>
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "head.php"; ?>
</head>
<body>
<?php require_once "navbar.php"; ?>
<div class="container p-5">
    <?php
    $requests = $curStudent->getRequests();
    if (!isset($requests)){
        echo 'No Requests';
    } else {
        foreach ($requests as $request) {
            $senderId = $request->getSenderId();
            $sender = Student::getInstance(Student::getUserId($senderId));
            $group = new StudentGroupProxy($request->getReceiverId());

            echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                                      <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">for '.$group->getName().' from '.$sender->getFName().' '.$sender->getLName().'</h6>
                                            <a href="viewRequest.php?reqId='.$request->getId().'"><button class="btn btn-primary btn-sm" >View</button></a>
                                      </div>
                                </div>';
        }
    }
    ?>
</div>
</body>
</html>