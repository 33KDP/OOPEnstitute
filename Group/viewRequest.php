<?php

require_once "../classes/Subject.class.php";
require_once "../classes/Student.class.php";
require_once "../classes/StudentGroupProxy.php";
session_start();
if (!isset($_SESSION['user_id'])){
    header("location: ../index.php");
}
?>

<html>
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "head.php"; ?>
</head>
<body>
<?php require_once "navbar.php";

$request = new JoinGroupRequest($_GET['reqId']);
$curGroup = new StudentGroupProxy($request->getReceiverId());
$senderId = $request->getSenderId();
$sender = Student::getInstance(Student::getUserId($senderId));
$getUrl='viewStudent.php?sid='.$senderId;
$senderName = $sender->getFName().' '.$sender->getLName();


echo '<div class="container p-5">';
echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                      <div class="card-body">
                        <h5 class="card-title"> <a href="groupDetails.php?id= '.$curGroup->getGroupID().' &type=view">'.htmlentities($curGroup->getName()).'</a></h5>
                        <h6 class="card-subtitle mb-2 text-muted">by <a href='.$getUrl.'>'.$senderName.'</a></h6>
                        <p>';
echo htmlentities($request->getMessage());
echo
    '</p>
                        <form action="controllers/requestController.php" method="POST" class="d-flex m-0">
                            <input type="hidden" name="reqId" value="' .$request->getId().'">
                            <input type="hidden" name="groupId" value="'.$curGroup->getGroupId().'">
                            <input type="hidden" name="senderId" value="'.$senderId.'">
                            <input class="btn btn-success btn-sm" name="Accept" value="Accept" type="submit">
                            <input class="btn btn-danger btn-sm mx-3" name="Reject" value="Reject" type="submit">
                        </form>
                      </div>
                </div>';
