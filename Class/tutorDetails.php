<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Tutor.class.php";

if (!isset($_GET['id'])) {
    header("location: ../index.php");
}
$curTutor = Tutor::getInstance($_GET['id']);
?>

<?php require_once "../Student/head.php"; ?>
<?php require_once "navbar.php"; ?>
<div class="container p-5 shadow my-5 rounded-3" style="color: #dddddd">
    <table style="color: #dddddd">
        <tr>
            <th>First name:</th>
            <td><?= htmlentities($curTutor->getFName()) ?></td>
        </tr>

        <tr>
            <th>Last name:</th>
            <td><?= htmlentities($curTutor->getLName()) ?></td>
        </tr>

        <tr>
            <th>District:</th>
            <td><?= htmlentities($curTutor->getDistrict()) ?></td>
        </tr>

        <tr>
            <th>City:</th>
            <td> <?= htmlentities($curTutor->getCity()) ?></td>
        </tr>
        <th>Description:</th>

        <tr>
            <td>
                <?php

                if (!empty($curTutor->getDescription())) {
                    echo htmlentities($curTutor->getDescription());
                } else {
                    echo "NULL";
                } ?>
            </td>
        </tr>


        <tr>
            <th>Available Time Slots:</th>
            <?php
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
                    echo '<span class="badge rounded-pill bg-warning text-dark">Occupied</span>';
                }
            }
            ?></tr>

    </table>
    <br>
    <div>
        <?php
        $lastURL = $_SESSION['lastURL'];
        echo '<a href="form.php?subId=' . $lastURL['subId'] .
            '&district=' . $lastURL['district'] . '&rating=' . $lastURL['rating'] . '"><button>Cancel</button></a>';
        echo '<a href="submit.php?id=' . $_GET['id'] . '&sid=' . $_GET['sid'] . ' "><button>Enroll</button></a>';
        ?>
    </div>
</div>
</body>
</html>
