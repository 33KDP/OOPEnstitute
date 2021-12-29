<?php
session_start();
require_once "../bootstrap.php";
require_once "head.php";
require_once "navbar.php";

require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
require_once("../includes/utils.php");
if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}

$curStudent = Student::getInstance($_SESSION['user_id']);

if (isset($_POST["create"])) {
    $studentID=$_POST['student_id'];
    $name = $_POST['name'];
    $subj = $_POST['subId'];
    $description = $_POST['description'];
    $limit = $_POST['limit'];

    if($limit=="yes"){
        $maxsd = $_POST['maxsd'];
        $district = $_POST['district'];
    }else{
        $maxsd = 1000000;
        $district = $curStudent->getDistrict();
    }

    $conn1 = DBConn::getInstance()->getPDO();
    $sql0=$conn1->prepare("SELECT * FROM District WHERE district=:dis");
    $sql0->execute(array(':dis'=>$district));
    $row = $sql0->fetch(pdo::FETCH_ASSOC);

    $conn = DBConn::getInstance()->getPDO();
    $sql1="INSERT INTO `group`(group_admin,group_name,subject_id,capacity,description,district_id) VALUES(:gadmin,:gname,:subid,:cap,:descrip,:dis)";
    $stmt1  = $conn->prepare($sql1);           

    $stmt1->execute(array(
        ':gadmin' => $studentID,      
        ':gname' => $name,
        ':subid' => $subj,
        ':cap' => $maxsd,
        ':descrip' => $description,
        ':dis' => $row['id'])
        );
    
    $group_id = $conn->lastInsertId();

    $sql2="INSERT INTO `group_student`(student_id,group_id) VALUES(:stid,:gid)";
    $stmt2  = $conn->prepare($sql2); 
    $stmt2->execute(array(
        ':stid' => $studentID,
        ':gid' => $group_id)
        );

    header('location: manage_group.php');
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
                <label for="search" class="form-label">Subject</label>
                <input class="form-control me-2 subject" type="search" placeholder="Search subjects" id="search" name="search" aria-label="Search">
                <input type="hidden" name="subId" id="subId">
            </div></div>
        </div>

        <div class="row">
        <div class="col"><div class="mb-3">
            <h5>Do you want to limit your group?</h5>
        <input type="radio"  id="limitY" name="limit" value="yes" onclick="show();">
        <label for="limitY">Yes</label>
        <input type="radio" id="limitN" name="limit" value="no" onclick="hide();">
        <label for="limitN">No</label>
        </div></div>
        </div>

        <div class="row" id="grpLimit">

            <div class="col"><div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select class="form-control"  name="district" id="district" placeholder="district..." >
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

            <div class="col"><div class="mb-3" >
                <label class="form-label" >Maximum Students</label>
                <input type="number" name="maxsd" class="form-control" min="2" >
            </div></div>

            <div class="col"><div class="mb-3"></div></div>

        </div>

        <div class="row">

            <div class="col"><div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" rows="6" name="description" id="description">
                </textarea>
            </div></div>
            <a><button type="submit" name="create" value="send" class="btn btn-primary">Create</button></a>
        </div>

        <input type="hidden" name="student_id" value="<?= $curStudent->getstudentId() ?>">
        
    </form>
    <a href="../Student/index.php"> <button class="btn btn-secondary">Back Home</button></a>
</div>

<?php 
    include_once 'foot.php';
?>   