<?php

require_once "../classes/Tutor.class.php";
require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
session_start();

if (!isset($_GET['id'])) {
    header("location: ../index.php");
}
$curTutor = Tutor::getInstance(Tutor::getUserId($_GET['id']));
$curStudent = Student::getInstance($_SESSION['user_id']);

if (isset($_POST['Send'])) {
    $tutorid = $_POST['tutorid'];
    $subjectid = $_POST['subjectid'];
    $req_type = $_POST['req_type'];
    $message = $_POST['message'];

    $stmt = 'INSERT INTO Request (tutor_id, subject_id, message, `type`';
    if ($req_type == 0) {
        $stmt .= ', student_id) ';
        $id = $curStudent->getStudentID();

    } else {
        $id = $_POST['group_id'];
        $stmt .= ', group_id) ';
    }

    $stmt .= 'values (:tid, :sid, :message, :ty, :id)';
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

<?php require_once "../bootstrap.php"; ?>
<?php require_once "../Student/head.php"; ?>

<?php
    require_once "navbar.php";
    if($_GET['type'] == 'enroll') {
        echo '
    <form method="POST" style="padding: 3%">
        <input type="hidden" name="tutorid" value=" '.$curTutor->getTutorId().'">
        <input type="hidden" name="subjectid" value=" '.$_GET['sid'].'">';

        if (isset($_GET['gid'])){
            echo '<input type="hidden" name="req_type" value=1>';
            echo '<input type="hidden" name="group_id" value='.$_GET['gid'].'>';
        } else {
            echo '<input type="hidden" name="req_type" value=0>';
        }

        echo '<div class="mb-3">
            <label for="message" class="form-label">Message:</label>
            <textarea class="form-control" name="message" id="message" placeholder="Type your message here..."></textarea>
        </div>
    
        <div style="text-align: center"> ';

            $lastURL = $_SESSION['lastURL'];

                echo '
            <a href = "form.php?subId=' . $lastURL['subId'] . '&district=' . $lastURL['district'] . '&rating=' . $lastURL['rating'] . '" class="btn btn-danger"> Cancel</a>
            <input type="submit" name="Send" value="Send" class="btn btn-primary">
        </div>
    
    </form>';
    } else if($_GET['type'] == 'disenroll') {
        //code here!
    }

?>

    <?php require_once '../Student/footer.php'; ?>
</body>
</html>
