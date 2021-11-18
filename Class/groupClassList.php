<?php
session_start();

require_once "../classes/Tutor.class.php";
require_once "../classes/Student.class.php";
require_once "../classes/DBConn.class.php";


if (!isset($_GET['id'])) {
    header("location: ../group_index.php");
}

$curStudent = Student::getInstance($_GET['id']);
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enrolled Classes</title>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "../Student/head.php"; ?>
    <link rel="stylesheet" href="../Student/css/style.css"/>
</head>

<body>
<?php require_once "navbar.php"; ?>
<div class="container">
    <h1>All Enrolled Group Classes</h1>
    <?php
    $stmt = $pdo->query("SELECT id FROM `User` WHERE usertype_id=2;");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo(htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']));
        echo '<div class="text-end" >';
        echo('<a href="../Class/group_index.php?class_id=' . $row['id'] . '">View details</a> &emsp;');
        echo '</div>';
        echo '<hr>';
    }
    ?>
</div>
</body>
</html>
