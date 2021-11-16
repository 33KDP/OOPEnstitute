<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";

    if (!isset($_GET['id'])){
        header("location: ../index.php");
    }
    $curTutor= Tutor::getInstance($_GET['id']);
    ?>

<html xmlns="http://www.w3.org/1999/html">
    <head>
        <?php require_once "../bootstrap.php"; ?>
        <?php require_once "../Student/head.php"; ?>
    </head>
    <body>
        <?php require_once "../Student/navbar.php"; ?>
        <div class="container p-5 shadow my-5 rounded-3">
            <table>
                <th>First name: <th>
                <td><?= htmlentities($curTutor->getFName())?></td>

                <th>Last name: </th>
                <td><?= htmlentities($curTutor->getLName())?></td>

                <th>District: </th>
                <td><?= htmlentities($curTutor->getDistrict())?></td>

                <th>City: </th>
                <td> <?= htmlentities($curTutor->getCity())?></td>
                <th>Description:</th>
                <td><?= htmlentities($curTutor->getDescription())?></td>

                <th>Available Time Slots:</th>
                <?php $timeslots = $curTutor->getTimeSlots();
                        foreach ($timeslots as $value) {
                            echo '<td><?= htmlentities('. $value .')?></td><br>';
                        }
                ?>

            </table>
                <br>
                <div>
                    <?php
                    $lastURL = $_SESSION['lastURL'];
                    echo '<a href="joinClass.php/?subID='.$lastURL['subId'].
                        '&district='.$lastURL['district'].'&rating='.$lastURL['rating'].'" class="btn btn-secondary">Cancel</a>';
                    echo '<a href="submit.php?id='.$_GET['id'].'&sid='.$_GET['sid'].'" class="btn btn-primary">Enroll</a>';
                    ?>
                </div>
        </div>
    </body>
</html>
