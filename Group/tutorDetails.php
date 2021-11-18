<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Tutor.class.php";

if (!isset($_GET['id'])) {
    header("location: ../index.php");
}
$curTutor = Tutor::getInstance($_GET['id']);
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "../Student/head.php"; ?>
    <link rel="stylesheet" href="../Student/css/style.css"/>
</head>
<body>
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
            <?php $timeslots = $curTutor->getTimeSlots();
            foreach ($timeslots as $value) {
                echo '<td><?= htmlentities(' . $value . ')?></td><br>';
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
