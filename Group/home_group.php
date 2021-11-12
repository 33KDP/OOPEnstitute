<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Groups</title>
</head>
<body>

<div class="container">
    <h1>All the groups you are in</h1>
    <?php
    #$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM users JOIN Profile ON users.user_id = Profile.user_id;");
    if (!isset($_SESSION['name'])){
        echo '<p><a href="login.php">Please log in</a></p>';
        echo'<p><table style="width:100%" border="1" ><tr><th>Name</th><th>Headline</th>';

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo'<tr><td><a href="view.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['first_name']).' '.htmlentities($row['last_name'])."</a></td>";
            echo"<td>".htmlentities($row['headline'])."</td><tr>";
        }
        echo"<table>";
    } else {
        echo'<a href="logout.php">Logout</a>';
        echo'<table style="width:100%" border="1" ><tr><th>Name</th><th>Headline</th><th>Action</th>';

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo'<tr><td><a href="view.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['first_name']).' '.htmlentities($row['last_name'])."</a></td>";
            echo"<td>".htmlentities($row['headline'])."</td>";
            echo'<td><a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a></td><tr>';
        }
        echo"<table>";
        echo'<p><a value="Add" href="add.php">Add New Entry</a></p><br>';
    }
    ?>
</div>
</body>
</html>
