<?php
session_start();
require_once "../classes/Student.class.php";
require_once "../classes/DBConn.class.php";
require_once "../classes/StudentGroupProxy.php";
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();

if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}
$curGroup = new StudentGroupProxy($_GET['gid']);
?>

<?php require_once "../bootstrap.php"; ?>
<?php require_once "head.php"; ?>

<body>
<?php require_once "navbar.php"?>

    <br/><h1 style="text-align: center"> Search and Join Tutors</h1>
    <p style="text-align: center"> You can Search Tutors Using below Search box. You can add additional filters as well ...</p>

    <div class="container p-5">
            <form action='tutorForm.php' method="GET">
                <div>
                    <div><h5> Select Filters </h5><br/>

                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="district">District:</label>
                                <select class="form-control" id="district" name="district" placeholder="district...">
                                    <option>-All-</option>
                                    <?php
                                    $districts = "SELECT * FROM district";
                                    $districts = DBConn::getInstance()->getPDO()->prepare($districts);
                                    $districts->execute();

                                    while ($row = $districts->fetch(PDO::FETCH_ASSOC)) {
                                        $district = $row['district'];
                                        echo '<option>' . $district . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4 mb-3">
                                <label for="rating">Rating:</label>
                                <select class="form-control" id="rating" name="rating" placeholder="Rating...">
                                    <option value="-All-">-All-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="subId" id="subId" value=<?='"'.$curGroup->getSubjectId().'"'?>>
                        <input type="hidden" name="gid" id="groupId" value=<?='"'.$curGroup->getGroupId().'"'?>>
                    </div>
                </div>
                <div>
                    <a href="manage_group.php" class="btn btn-primary">Back</a>
                    <input class="btn btn-primary mx-2" name="Search" value="Search Tutors" type="submit">
                <div>
            </form>
        <br/>

        <br/>
    </div>

<script src="js/subjects.js"></script>
</body>
</html>

