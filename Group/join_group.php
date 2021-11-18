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

<html lang="en">
<head>
    <?php require_once "../bootstrap.php"; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
    <script src="https://kit.fontawesome.com/afd6aa68df.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Student/css/style.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <title>join group</title>
</head>

<?php require_once "navbar.php"; ?>
<body class="sb-nav-fixed">

<div class="container p-5">
    <div>
        <form action='form.php' method="GET">
            <div>
                <div><h3 style="color: #dddddd; font-family: 'Bebas Neue', cursive;"> Filters </h3>
                    <div>
                        <label for="district"
                               style="color: #dddddd; font-family: 'Bebas Neue', cursive;">District:</label>
                        <select class="form-control" id="district" name="district" placeholder="district...">
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

                        <label for="rating" style="color: #dddddd; font-family: 'Bebas Neue', cursive;">Tutor's
                            Rating:</label>
                        <select class="form-control" id="rating" name="rating" placeholder="Rating...">
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
                               name="search" aria-label="Search">
                        <input class="btn btn-outline-success" name="Search" value="Search" type="submit">
                    </div>

                    <div><input type="hidden" name="subId" id="subId"></div>
        </form>
    </div>
</div>


<script src="js/subjects.js"></script>
</body>
</html>

