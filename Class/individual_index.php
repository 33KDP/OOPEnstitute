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
        <table>

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

        </table>
        <br>
        <div>
            <?php

            echo '<a href="submit.php?id=' . $_GET['tid'] . '&type=disenroll " class="btn btn-primary">Disenroll</a>';
            ?>
        </div>

    </div>
    </body>
</html>