<?php
    session_start();
    include_once 'head.php' ;
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";
    require_once("../includes/utils.php");
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curStudent=  Student::getInstance($_SESSION['user_id']);

    require_once "../bootstrap.php";
    require_once "navbar.php";
?>

<body>
    <div class="container p-5 shadow my-5 rounded-3 st" >

        <form action="controllers/profileController.php" method="post">

            <div class="mb-3" >
                <label for="propic" class="form-label">Profile Photo</label><br>
                <?php
                    //$propic = $curTutor->getProfilePic();
                    $propic = false ;

                    if($propic=!false){

                        echo "<image id='profileImage' src='https://i.stack.imgur.com/YQu5k.png' style='width:110px; height:130px; object-fit:cover;' />" ;
                    }else{
                        echo "<image id='profileImage' src='{$propic}' class='img-thumbnail' style='width:110px; height:130px; object-fit:cover;'/>" ;
                    }
                ?>
                <input  id="imageUpload" type="file"  name="profile_photo" class="form-control" placeholder="Photo"  onchange="loadFile(event)" >
            </div>

            <div class="mb-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text"  name="fname" class="form-control" id="fname" value="<?= htmlentities($curStudent->getFName())?>">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text"  name="lname" class="form-control" id="lname" value="<?= htmlentities($curStudent->getLName())?>">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Grade</label>
                <select name="grade" class="form-control" id="grd" >
                    <option value="<?= htmlentities($curStudent->getgrade())?>"> <?php echo ($curStudent->getgrade()); ?> </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <input type="text"  name="district" class="form-control" id="district" value="<?= htmlentities($curStudent->getDistrict())?>">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text"  name="city" class="form-control" id="city" value="<?= htmlentities($curStudent->getCity())?>">
            </div>
            <div>
                <button type="submit" name="set" class="btn btn-primary">Edit</button>
            </div>
            <input type="hidden" name="studentid" value="<?= $curStudent->getstudentId()?>">
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

        <div class="mb-3">
            <?php
                check_session();
            ?>
        </div>

    </div>
</body>

<?php
require_once "foot.php";
?>