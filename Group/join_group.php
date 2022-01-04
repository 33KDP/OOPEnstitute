<?php
session_start();
require_once "../classes/Student.class.php";
require_once "../classes/DBConn.class.php";
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();

if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}
$curStudent = Student::getInstance($_SESSION['user_id']);
?>

<?php require_once "../bootstrap.php"; ?>
<?php require_once "../Student/head.php"; ?>

<body>
<?php require_once "navbar.php"?>

<br/><h1 style="text-align: center"> Search and Join Groups</h1>
<p style="text-align: center"> You can search groups using below Search box. You can add additional filters as well ...</p>


<div class="container p-5">
    <form action='form.php' method="GET">
        <div class="row mb-5">
            <div class="col-2 "></div>
            <div class="col-6 ">
                <input class="form-control me-2 subject" type="search" placeholder="Search subjects" id="search" name="search" aria-label="Search" required>
                <input type="hidden" name="subId" id="subId">
            </div>
            <div class="col-2 mx-0">
                <input class="btn btn-outline-primary mx-0" name="Search" value="Search Groups" type="submit">
            </div>
            <div class="col-2 "></div>
        </div>

        <div>
            <div><h5> Additional Filters </h5><br/>
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
                </div>
            </div>
        </div>
    </form>
    <br/>
    <div><a href="../Student/index.php" class="btn btn-primary">Back Home</a></div><br/>
</div>
<script src="js/subjects.js"></script>


<?php require_once '../Student/footer.php'; ?>
</body>
</html>
