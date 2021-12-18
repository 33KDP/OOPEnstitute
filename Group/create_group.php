<?php
session_start();
require_once "../bootstrap.php";
require_once "navbar.php";
include_once 'head.php';

require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
require_once("../includes/utils.php");
if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}

$curStudent = Student::getInstance($_SESSION['user_id']);

if (isset($_POST['create'])) {
    $studentID=$_POST['student_id'];
    $name = $_POST['name'];
    $maxsd = $_POST['maxsd'];
    $subj = $_POST['subId'];
    $district = $_POST['district'];
    $description = $_POST['description'];

    $conn = DBConn::getInstance()->getPDO();
    $sql1="INSERT INTO `group`(group_admin,group_name,subject_id,capacity,description) VALUES(:gadmin,:gname,:subid,:cap,:descrip)";
    $stmt1  = $conn->prepare($sql1);           

    $stmt1->execute(array(
        ':gadmin' => $studentID,      
        ':gname' => $name,
        ':subid' => $subj,
        ':cap' => $maxsd,
        ':descrip' => $description)
        );


    header('location: ../Student/index.php');
}



?>

<div class="container p-5 shadow my-5 rounded-3 st">
    <?php check_session();?>
    <form action="create_group.php" method="post">

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="name" class="form-label" >Group Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col"><div class="mb-3">
                <label for="maxsd" class="form-label">Maximum Students</label>
                <input type="number" name="maxsd" class="form-control" id="maxsd" min="2" required>
            </div></div>
        </div>

        <div class="row">
            <div class="col"><div class="mb-3">
                <label for="maxsd" class="form-label">Subject</label>
                <input class="form-control me-2 subject" type="search" placeholder="Search subjects" id="search" name="search" aria-label="Search">
                <input type="hidden" name="subId" id="subId">
            </div></div>
        </div>

        <div class="row">

            <div class="col"><div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select class="form-control" id="district" name="district" placeholder="district..." required>
                    <option selected><?php echo($curStudent->getDistrict()); ?></option>
                    <?php
                    $districts = "SELECT * FROM district";
                    $districts = DBConn::getInstance()->getPDO()->prepare($districts);
                    $districts->execute();

                    while ($row = $districts->fetch(PDO::FETCH_ASSOC)) {
                        $district = $row['district'];
                        echo '<option placeholder="NULL">' . $district . '</option>';
                    }
                    ?>
                </select>
            </div></div>

            <div class="col"><div class="mb-3"></div></div>

        </div>

        <div class="row">

            <div class="col"><div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" rows="6" name="description" id="description">
                </textarea>
            </div></div>
            <a><button type="submit" name="create" value="send" class="btn btn-primary">Create</button>
        </div>

        <input type="hidden" name="student_id" value="<?= $curStudent->getstudentId() ?>">
        
    </form>
    <a href="../Student/index.php"> <button class="btn btn-secondary">Back Home</button></a>
</div>

<?php 
    include_once 'foot.php';
?>   