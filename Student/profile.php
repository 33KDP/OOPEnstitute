<?php
session_start();

require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
require_once("../includes/utils.php");
if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}
$curStudent = Student::getInstance($_SESSION['user_id']);

require_once "../bootstrap.php";
require_once "navbar.php";
include_once 'head.php';
?>

    <div class="container p-5 shadow my-5 rounded-3 st">
        <?php check_session();?>
        <form action="controllers/profileController.php" enctype="multipart/form-data" method="post">

            <div class="mb-3">
                <label for="propic" class="form-label">Profile Photo</label><br>
                <?php
                $propic = $curStudent->getProfilePic();
                if (!$propic) {
                    echo "<image id='profileImage' src='https://i.stack.imgur.com/YQu5k.png' class='img-thumbnail' style='width:110px; height:130px; object-fit:cover;' />";
                } else {
                    $imageURL = '../uploads/'.$propic;
                    echo "<image id='profileImage' src=".$imageURL." class='img-thumbnail' style='width:110px; height:130px; object-fit:cover;'/>";
                }
                ?>
                <input id="imageUpload" accept="image/jpeg" type="file" name="profile_photo" class="form-control" placeholder="Photo" onchange="loadFile(event)">
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First name</label>
                        <input type="text" name="fname" class="form-control" id="fname"
                            value="<?= htmlentities($curStudent->getFName()) ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last name</label>
                        <input type="text" name="lname" class="form-control" id="lname"
                            value="<?= htmlentities($curStudent->getLName()) ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="lname" class="form-label">Grade</label>
                        <select class="form-select" name="grade" class="form-control" id="grd">
                            <option selected> <?php echo($curStudent->getgrade()); ?> </option>
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
                </div>
                <div class="col"><div class="mb-3"></div></div>
                <div class="col"><div class="mb-3"></div></div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="district" class="form-label">District</label>
                        <select class="form-select" name="district" class="form-control" id="district">
                            <option selected> <?php echo($curStudent->getDistrict()); ?> </option>
                            <option value="Ampara">Ampara</option>
                            <option value="Anuradhapura">Anuradhapura</option>
                            <option value="Badulla">Badulla</option>
                            <option value="Batticaloa">Batticaloa</option>
                            <option value="Colombo">Colombo</option>
                            <option value="Galle">Galle</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Hambantota">Hambantota</option>
                            <option value="Jaffna">Jaffna</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Kegalle">Kegalle</option>
                            <option value="Kilinochchi">Kilinochchi</option>
                            <option value="Kurunegala">Kurunegala</option>
                            <option value="Mannar">Mannar</option>
                            <option value="Matale">Matale</option>
                            <option value="Matara">Matara</option>
                            <option value="Monaragala">Monaragala</option>
                            <option value="Mullaitivu">Mullaitivu</option>
                            <option value="Nuwara Eliya">Nuwara Eliya</option>
                            <option value="Polonnaruwa">Polonnaruwa</option>
                            <option value="Puttalam">Puttalam</option>
                            <option value="Ratnapura">Ratnapura</option>
                            <option value="Trincomalee">Trincomalee</option>
                            <option value="Vavuniya">Vavuniya</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" class="form-control" id="city"
                            value="<?= htmlentities($curStudent->getCity()) ?>">
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" name="set" class="btn btn-primary">Edit</button>
            </div>
            <input type="hidden" name="studentid" value="<?= $curStudent->getstudentId() ?>">
        </form>

        <hr class="my-5">
        <div class="mb-3">
            <h4>Do you want to change your password ?</h4>
        </div>

        <form class="my-5" action="controllers/profileController.php" method="POST">

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="city" class="form-label">Old Password</label>
                        <input type="password"  name="old_pwd" class="form-control" id="pwd" >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="city" class="form-label">New Password</label>
                        <input type="password"  name="new_pwd" class="form-control" id="pwd" >
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="city" class="form-label">Confirm Password</label>
                        <input type="password"  name="confirm_pwd" class="form-control" id="pwd" >
                    </div>
                </div>
            </div>

            
            <div class="mb-3 py-3"> 
                <button class="btn btn-danger " type="submit" name="reset" >Change password</button>
                <button class="btn btn-dark mx-2" name="Cancel" value="Cancel" href="home.php">Cancel</button>
            </div>   
        </form>
    </div>
    

<?php
require_once "foot.php";
?>