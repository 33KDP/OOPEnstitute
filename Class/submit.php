<?php

    require_once "../classes/Tutor.class.php";
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_GET['id'])){
        header("location: ../index.php");
    }
    $curTutor= Tutor::getInstance($_GET['id']);
    $curStudent= Student::getInstance($_SESSION['user_id']);


    if (isset($_POST['Send'])) {
        $tutorid = $_POST['tutorid'];
        $subjectid = $_POST['subjectid'];
        $req_type = $_POST['req_type'];
        $message = $_POST['message'];

        //var_dump($_POST);

        $stmt = 'INSERT INTO Request (tutor_id, subject_id, message, `type`';
        if ($req_type == 0) {
            $stmt .= ', student_id) ';
            $id = $curStudent->getStudentID();

        } else {
            $id = $_POST['group_id'];
            $stmt .= ', group_id) ';
        }

        $stmt.= 'values (:tid, :sid, :message, :ty, :id)';
        $pdo = DBConn::getInstance()->getPDO();
        $query = $pdo->prepare($stmt);

        $query->execute(array(
                ':tid' => $tutorid,
            ':sid' => $subjectid,
            ':message' => $message,
            ':ty' => $req_type,
            ':id' => $id
        ));

        header('location: ../Student/index.php');
    }
?>



<html>
    <head>
        <?php require_once "../bootstrap.php"; ?>
        <?php require_once "../Student/head.php"; ?>
    </head>
<body>


<form method="POST">
    <input type="hidden" name="tutorid" value="<?= $curTutor->getTutorId()?>">
    <input type="hidden" name="subjectid" value="<?= $_GET['sid']?>">
    <input type="hidden" name="req_type" value=0>
    <div class="mb-3">
        <label for="message" class="form-label">message</label>
        <textarea class="form-control"  name="message" id="message" >Type your message here...</textarea>
    </div>

    <div>
        <?php

        $lastURL = $_SESSION['lastURL'];
        echo '<button class="btn btn-secondary" name="Cancel" value="Cancel" href="joinClass.php/?subID='.$lastURL['subId'].
            '&district='.$lastURL['district'].'&rating='.$lastURL['rating'].'">Cancel</button>'?>
        <input type="submit" name="Send" value="Send" class="btn btn-primary">
    </div>

</form>

