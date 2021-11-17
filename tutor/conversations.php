<?php
    require_once "../classes/DBConn.class.php";
    require_once "../bootstrap.php";
    $dbCon = DBConn::getInstance();
    $pdo = $dbCon->getPDO();
    session_start();
    unset($_SESSION['receiver_id']);

    $user_id = $_SESSION['user_id'];
    $usersWithConversations = array();
    $qry = $pdo->prepare("SELECT * FROM `Message` WHERE (user_id = :userId OR receiver = :userId)");
    $qry->execute(array(':userId'=>$user_id));
    while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
        if ($row['user_id'] == $user_id and !in_array($row['receiver'], $usersWithConversations))
            array_push($usersWithConversations, $row['receiver']);
        elseif($row['receiver'] == $user_id and !in_array($row['user_id'], $usersWithConversations))
            array_push($usersWithConversations, $row['user_id']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Conversations</title>
    </head>

    <body>
        <?php require_once "navbar.php"; ?>
        <div class="container">
            <h1>Conversations</h1>
            <?php
                if (isset($_SESSION['name'])) // should be not
                {
                    echo '<p><a href="login.php">Please log in</a></p>';

                } else {
                    foreach ($usersWithConversations as $user) {
                        $qry = $pdo->prepare("SELECT id, first_name, last_name FROM `User` WHERE id=:userId");
                        $qry->execute(array(':userId'=>$user));
                        $row = $qry->fetch(PDO::FETCH_ASSOC);
                        echo ('<a href="../Student/viewDetails.php?student_id='.$row['id'].'" style="color: black; text-decoration: none;">'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'</a> &emsp;');
                        echo '<div class="text-end" >';
                        echo ('<a href="../User/message.php?receiver_id='.$row['id'].'">Message</a> &emsp;');
                        echo '</div>';
                        echo '<hr>';
                    }

                }

            ?>
        </div>
    </body>
</html>
