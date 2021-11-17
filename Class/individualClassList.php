<?php
require_once "../classes/DBConn.class.php";
require_once "../bootstrap.php";
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Enrolled Classes</title>
    </head>

    <body>
        <?php require_once "navbar.php"; ?>
        <div class="container">
            <h1>All Enrolled Classes</h1>
            <?php
                $stmt = $pdo->query("SELECT id FROM `User` WHERE usertype_id=2;");

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo(htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']));
                    echo '<div class="text-end" >';
                    echo('<a href="../Class/index.php?class_id=' . $row['id'] . '">View details</a> &emsp;');
                    echo '</div>';
                    echo '<hr>';
                }
            ?>
        </div>
    </body>
</html>
