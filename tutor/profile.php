<?php
    include_once 'head.php' ;
    require_once "../classes/Session.class.php";
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);

    require_once "../bootstrap.php";
    require_once "navbar.php";
?>


    <div class="container p-5 shadow my-5 rounded-3">
        <form action="controllers/profileController.php" method="POST">

            
            <div class="mb-3">
                <label for="fname" class="form-label">Profile Photo</label><br>
                <?php
                    //$propic = $curTutor->getProfilePic();
                    $propic = false ;
                    
                    if($propic=!false){
                        
                        echo "<image id='profileImage' src='https://i.stack.imgur.com/YQu5k.png' style='width:110px; height:130px; object-fit:cover;' />" ;
                    }else{
                        echo "<image id='profileImage' src='{$propic}' class='img-thumbnail' style='width:110px; height:130px; object-fit:cover;'/>" ;
                    }
                ?>
                <input  id="imageUpload" type="file"  name="profile_photo" class="form-control" placeholder="Photo"  onchange="loadFile(event)" required="" capture>
            </div>

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
            <?php

            ?>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="flag" name="cbox" value="1"
                    <?php
                        if ($curTutor->isNotAvailable()){
                            echo'checked';
                        }
                    ?>
                >
                <label class="form-check-label" for="flag">Set as unavailable</label>
            </div>
            <div>
                <button type="submit" name="set" class="btn btn-primary">Edit</button>
            </div>
            <input type="hidden" name="tutorid" value="<?= $curTutor->getTutorId()?>">
        </form>
        
        <br>
        <div class="mb-3">
            <h4>Do you want to reset your password ?</h4>
        </div>
        <form action="controllers/profileController.php" method="POST">
            <div class="mb-3">
                <label for="city" class="form-label">Old Password</label>
                <input type="password"  name="old_pwd" class="form-control" id="pwd" >
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">New Password</label>
                <input type="password"  name="new_pwd" class="form-control" id="pwd" >
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Confirm Password</label>
                <input type="password"  name="confirm_pwd" class="form-control" id="pwd" >
            </div>
            <div class="mb-3"> 
                <button type="submit" name="reset" class="btn btn-danger">Reset password</button>
            </div>
            <div class="mb-3">
                <button class="btn btn-dark" name="Cancel" value="Cancel" href="home.php">Cancel</button>
            </div>
        </form>
        

    </div>


<?php 
    include_once 'foot.php';
?>   