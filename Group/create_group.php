<?php
session_start();

require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";
require_once("../includes/utils.php");
if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}

$curStudent = Student::getInstance($_SESSION['user_id']);

if (isset($_POST['Send'])) {
    $name = $_POST['name'];
    $grade = $_POST['grade'];
    $maxsd = $_POST['maxsd'];
    $subj = $_POST['subj'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $description = $_POST['description'];




    /************************************ to be edited*******************************/
    $stmt = 'INSERT INTO Request (tutor_id, subject_id, message, `type`';

    if ($req_type == 0) {
        $stmt .= ', student_id) ';
        $id = $curStudent->getStudentID();

    } else {
        $id = $_POST['group_id'];
        $stmt .= ', group_id) ';
    }

    $stmt .= 'values (:tid, :sid, :message, :ty, :id)';
    $pdo = DBConn::getInstance()->getPDO();
    $query = $pdo->prepare($stmt);
    $query->execute(array(
        ':tid' => $tutorid,
        ':sid' => $subjectid,
        ':message' => $message,
        ':ty' => $req_type,
        ':id' => $id
    ));

    header('location: ../Student/index.php');
}


require_once "../bootstrap.php";
require_once "navbar.php";
include_once 'head.php';
?>

    <div class="container p-5 shadow my-5 rounded-3 st">
        <?php check_session();?>
        <form action="" method="post">

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="name" class="form-label" >Group Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-control" id="grade" name="grade" required>
                            <option selected></option>
                            <?php
                            $pdo = DBConn::getInstance()->getPDO();
                            $qry = $pdo->prepare("SELECT grade FROM Grade WHERE Grade.grade LIKE :prefix");
                            $qry->execute(array(
                                ':prefix' => $_REQUEST['term'] . '%'
                            ));
                            while ($result = $qry->fetch(PDO::FETCH_ASSOC)) {
                                $temp = $result['grade'] ;
                                echo '<option placeholder="NULL">' . $temp . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col"><div class="mb-3">
                        <label for="maxsd" class="form-label">Maximum Students</label>
                        <input type="text" name="maxsd" class="form-control" id="maxsd" required>

                    </div></div>
                <div class="col"><div class="mb-3">
                        <label for="subj" class="form-label">Subject</label>
                        <select class="form-control" id="subj" name="subj" required>
                            <option selected></option>
                            <?php
                            $pdo = DBConn::getInstance()->getPDO();
                            $qry = $pdo->prepare("SELECT name FROM SubjectName WHERE SubjectName.name LIKE :prefix");
                            $qry->execute(array(
                                ':prefix' => $_REQUEST['term'] . '%'
                            ));
                            while ($result = $qry->fetch(PDO::FETCH_ASSOC)) {
                                $temp = $result['name'] ;
                                echo '<option placeholder="NULL">' . $temp . '</option>';
                            }
                            ?>
                        </select>

                    </div></div>
                <div class="col"><div class="mb-3">
                        <label for="medium" class="form-label">Medium</label>
                        <select class="form-control" id="medium" name="medium" required>
                            <option selected></option>
                            <?php
                            $pdo = DBConn::getInstance()->getPDO();
                            $qry = $pdo->prepare("SELECT medium FROM SubjectMedium WHERE SubjectMedium.medium LIKE :prefix");
                            $qry->execute(array(
                                ':prefix' => $_REQUEST['term'] . '%'
                            ));
                            while ($result = $qry->fetch(PDO::FETCH_ASSOC)) {
                                $temp = $result['medium'] ;
                                echo '<option placeholder="NULL">' . $temp . '</option>';
                            }
                            ?>
                        </select>

                    </div></div>

            </div>

            <div class="row">
                <div class="col"><div class="mb-3">
                        <label for="district" class="form-label">District</label>
                        <select class="form-control" id="district" name="district" placeholder="district..." required>
                            <option selected></option>
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
                <div class="col"><div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" class="form-control" id="city">
                    </div></div>
            </div>

            <div class="row">
                <div class="col"><div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" rows="6" name="description" id="description">
                        </textarea>
                    </div></div>
            <a>
                <button type="submit" name="send" value="send" class="btn btn-primary">Create</button>
            </div>
            <input type="hidden" name="student_id" value="<?= $curStudent->getstudentId() ?>">
        </form>
        <a href="../Student/index.php"> <button class="btn btn-secondary">Back Home</button></a>
    </div>
</body>
</html>