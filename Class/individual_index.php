<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
require_once "../classes/Tutor.class.php";
require_once("../includes/utils.php");

if (!isset($_SESSION['user_id'])) {
    header("location:  ../individualClassList.php");
}

$curTutor = Tutor::getInstance($_GET['tid']);

require_once "../bootstrap.php";
require_once "navbar.php";
?>

<?php require_once "../Student/head.php"; ?>

    <body>

    <div class="container p-5 shadow my-5 rounded-3">
        <div><a href="individualClassList.php" class="btn btn-primary"> Back to the list </a><div><br/>
        <div>
            <h5>Name:</h5>
            <?= htmlentities($curTutor->getFName()) ?> <?= htmlentities($curTutor->getLName()) ?>
        </div><br/>

        <div>
            <h5>District:</h5>
            <?= htmlentities($curTutor->getDistrict()) ?>
        </div><br/>

        <div>
            <h5>City:</h5>
            <?= htmlentities($curTutor->getCity()) ?>
        </div><br/>

        <div>
            <h5>Email:</h5>
            <?= htmlentities($curTutor->getEmail()) ?>
        </div><br/>

        <div>
            <h5>Mobile:</h5>
            Mobile Number Not Available
        </div><br/>

        <div>
            <h5>Description:</h5>
            <?php

            if (!empty($curTutor->getDescription())) {
                echo htmlentities($curTutor->getDescription());
            } else {
                echo "NULL";
            } ?>
            </h5>
        </div><br/>

        <div>
            <h5>Available Time Slots: </h5>
            <?php
            echo '<div class="container p-4">';
            echo '<div class="row">';
            foreach ($curTutor->getTimeSlots() as $timeSlot) {
                echo '<div class="col-3">';
                echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                                          <div class="card-body">
                                            <h5 class="card-title">' . htmlentities($timeSlot->getDay()) . '</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">' . htmlentities(Timeslot::getTime12($timeSlot->getStartTime())) . ' - ' . htmlentities(Timeslot::getTime12($timeSlot->getEndTime())) . '</h6>
                                            <div class="my-3">';
                if (!$timeSlot->getNotAvailable()) {
                    echo '<span class="badge rounded-pill bg-success">Vacant</span>';
                } else {
                    echo '<span class="badge rounded-pill bg-warning text-dark">Occupied</span></td>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            ?>
        </div>
        <br>
        <div>
            <?php

            echo '<a href="submit.php?id=' . $_GET['tid'] . '&type=disenroll " class="btn btn-primary"> Disenroll </a>';
            echo '<a href="#" class="btn btn-secondary"> Send a Message </a>';
            ?>
        </div>

    </div>
    </body>
</html>