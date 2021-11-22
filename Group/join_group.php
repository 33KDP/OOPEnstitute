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

<div class="container">
    <div style="padding: 10%">
        <form action='form.php' method="GET">
            <div>
                <div><h3> Filters </h3>

                    <label for="district">District:</label>
                    <select class="form-control" id="district" name="district" placeholder="district...">
                        <option>-All-</option>
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

                    <label for="rating">Rating:</label>
                    <select class="form-control" id="rating" name="rating" placeholder="Rating...">
                        <option value="0">-All-</option>
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
                    </select>
                </div>
                <br>
                <br>

                <div>
                    <input class="form-control me-2 subject" type="search" placeholder="Search subjects" id="search"
                           name="search" aria-label="Search" required>
                    <input class="btn btn-outline-success" name="Search" value="Search" type="submit">
                </div>

                <div><input type="hidden" name="subId" id="subId"></div>
            </div>
        </form>
    </div>
    <div><a href="../Student/index.php" class="btn btn-primary"> Back Home</a><div><br/>
        </div>


        <script src="js/subjects.js"></script>
</body>
</html>

