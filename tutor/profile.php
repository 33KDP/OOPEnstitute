<?php
    require_once "../classes/Tutor.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
?>

<html>
    <head>
        <?php require_once "../bootstrap.php"; ?>
        <?php require_once "head.php"; ?>
    </head>
    <body>
        <?php require_once "navbar.php"; ?>
        <div class="container p-5 shadow my-5 rounded-3">
            <form action="controllers/profileController.php" method="POST">
                <div class="mb-3">
                    <label for="fname" class="form-label">First name</label>
                    <input type="text"  name="fname" class="form-control" id="fname" value="<?= htmlentities($curTutor->getFName())?>">
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name</label>
                    <input type="text"  name="lname" class="form-control" id="lname" value="<?= htmlentities($curTutor->getLName())?>">
                </div>
                <div class="mb-3">
                    <label for="district" class="form-label">District</label>
                    <input type="text"  name="district" class="form-control" id="district" value="<?= htmlentities($curTutor->getDistrict())?>">
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text"  name="city" class="form-control" id="city" value="<?= htmlentities($curTutor->getCity())?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control"  name="description" id="description" ><?= htmlentities($curTutor->getDescription())?></textarea>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="flag"
                        <?php
                            if ($curTutor->isNotAvailable()){
                                echo'checked';
                            }
                        ?>
                    >
                    <label class="form-check-label" for="flag">Set as unavailable</label>
                </div>
                <div>
                    <button class="btn btn-secondary" name="Cancel" value="Cancel" href="home.php">Cancel</button>
                    <input type="submit" name="Add" value="Add" class="btn btn-primary">
                </div>
                <input type="hidden" name="tutorid" value="<?= $curTutor->getTutorId()?>">
            </form>
        </div>
    </body>
</html>
