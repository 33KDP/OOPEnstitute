<?php
require_once "../classes/DBConn.class.php";
require_once "../bootstrap.php";
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();
session_start();
unset($_SESSION['receiver_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tutors</title>
</head>

<body>
<?php require_once "navbar.php"; ?>
<div class="container">
    <h1>All Tutors</h1>
    <?php
    $stmt = $pdo->query("SELECT id, first_name, last_name FROM `User` WHERE usertype_id=2;");
    if (isset($_SESSION['name'])) { // should be not set
        echo '<p><a href="login.php">Please log in</a></p>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo('<a href="../tutor/viewDetails.php?tutor_id=' . $row['id'] . '" style="color: black; text-decoration: none;">' . htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']) . '</a> &emsp;');
            echo '<hr>';
        }

    } else {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo('<a href="../tutor/viewDetails.php?tutor_id=' . $row['id'] . '" style="color: black; text-decoration: none;">' . htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']) . '</a> &emsp;');
            echo '<div class="text-end" >';
            echo('<a href="../User/message.php?receiver_id=' . $row['id'] . '">Message</a> &emsp;');
            echo('<a href="sendRequest.php?tutor_id=' . $row['id'] . '">Send enrolment request</a>');
            echo '</div>';
            echo '<hr>';
        }

    }

    ?>
</div>
</body>
</html>
