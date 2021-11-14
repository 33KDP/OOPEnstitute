<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Groups</title>
    <?php
    require_once "../bootstrap.php";
    ?>
</head>
<body>
<?php
require_once "navbar.php";
?>
<div class="container">
    <h1>Join a Group</h1>
    <p> you can search groups using below search box and all the groups with highest rating are shown below. Thanks</p>

    <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search for" aria-label="Search">
        <button class="btn btn-outline-success" onclick="" type="submit">Search</button>
    </form>

    <br>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>

        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
    </table>

</div>
</body>
</html>
