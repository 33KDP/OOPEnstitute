<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Tutor.class.php";
require_once "../classes/Student.class.php";

if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}

require_once "../bootstrap.php";
require_once "head.php"; ?>
<style>
    <?php include "../User/css/style.css" ?>
</style>

<body>
<?php require_once "navbar.php";

$curGroup = StudentGroup::getInstance($_GET['id']);
?>

<div class="container p-5 shadow my-5 rounded-3">
    <div >
        <?php echo '<a class="btn btn-primary" href="../User/message.php?receiver_id='.$curGroup->getAdmin().'"> Send Message</a> '?>
    </div><br/>

    <div>
        <h5>Name:</h5>
        <?= htmlentities($curGroup->getName()) ?>
    </div><br/>

    <div>
        <h5>District:</h5>
        <?= htmlentities($curGroup->getDistrict()) ?>
    </div><br/>

    <div>
        <h5>:</h5>
        <?= htmlentities($curGroup->getCapacity()) ?>
    </div><br/>

    <div>
        <h5>Admin:</h5>
        <?= htmlentities($curGroup->getAdmin()) ?>
    </div><br/>

    <div>
        <h5>Admin Email:</h5>
        <?= htmlentities("Not Available") ?>
    </div><br/>

    <div>
        <h5>Admin Contact Number:</h5>
        <?= htmlentities("Not Available") ?>
    </div><br/>

    <div>
        <h5>Created Date:</h5>
        <?= htmlentities($curGroup->getCreatedDate()) ?>
    </div><br/>

    <div>
        <h5>Students List:</h5>
        <?= htmlentities($curGroup->getStudentList()) ?>
    </div><br/>


    <div>
        <h5>Description:</h5>
        <?php
        if (!empty($curGroup->getDescription())) {
            echo htmlentities($curGroup->getDescription());
        } else {
            echo "No Description";
        } ?>
    </div><br/>

    <?php

        $qry = "SELECT groupclass.tutor_id FROM groupclass WHERE group_id = '$curGroup->getGroupID()' ";
        $qry = DBConn::getInstance()->getPDO()->prepare($qry);
        $qry->execute();

        if (($row_1 = $qry->fetch(PDO::FETCH_ASSOC)) !== false) {
            $tutor = $row_1['tutor_id'];
            $curTutor = Tutor::getInstance(Tutor::getUserId($tutor));
            // tutor availability flag - up
            echo '<h5 class="card-title">Tutor: <a href="../Student/viewTutor.php?tid='.$curTutor->getTutorId().'">'.htmlentities($curTutor->getFName()).' '.htmlentities($curTutor->getLName()).'</a> </h5>';
            echo '<h5 class="card-title">TutorDetails'.$curTutor->getEmail().'</h5>';
            echo '<h5 class="card-title">TutorCity'.$curTutor->getCity().'</h5>';

        } else {
            $tutor = NULL;
            echo '<h5 class="card-title">No tutor is assigned to this group</h5>';
        }

    if (isset($_GET['sid'])) {
        echo '<div>';
        $lastURL = $_SESSION['lastURL'];
        echo '<a href="../Group/form.php?subId=' . $lastURL['subId'] .
            '&district=' . $lastURL['district'] . '" class="btn btn-secondary">Cancel</a>';
        echo '<a href="../Group/submit.php?id=' . $_GET['id'] . '&type=enroll" class="btn btn-primary">Join</a>';
        echo '</div>';
    }
    ?>
</div>

</body>
</html>