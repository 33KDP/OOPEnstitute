<?php
session_start();
require_once "../classes/DBConn.class.php";

if (empty($_GET['subId'])) {
    header('location: joinClass.php');

} else {
    $subjectID = $_GET['subId'];
    $district = $_GET['district'];
    $rating = $_GET['rating'];
    $lastURL = array('subId' => $subjectID, 'district' => $district, 'rating' => $rating);
    $_SESSION ['lastURL'] = $lastURL;
}


$search_query = "SELECT Tutor.id, `User`.first_name, `User`.last_name, District.district, `User`.rating FROM Tutor 
                    JOIN District Join Tutor_Subject Join `User` ON `User`.id = tutor.user_id and 
                        `User`.district_id = district.id and Tutor.id = Tutor_Subject.tutor_id WHERE 
                            Tutor_Subject.Subject_id = '$subjectID' AND Tutor.availability_flag=0";

if ($district != "-All-") { $search_query .= " AND District.district='$district'"; }
if ($rating != "-All-") { $search_query .= " AND User.rating>='$rating'"; }

$search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
$search_query->execute();

?>

<?php require_once "head.php";
    require_once "navbar.php";?>

<body>
<?php

    echo '<br/>';
    echo '<div class="container " style="padding: 3%">';
        echo '<h1>Search Results for Tutors</h1><br/>';
        echo '<br/>';

        echo '<div>';
            while ($row = $search_query->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">';
                    $id = $row['id'];
                    $name = $row['first_name'] . ' ' . $row['last_name'];
                    $dis = $row['district'];
                    $rate = $row['rating'];

                    if (is_null($id)) {
                    header('location: joinClass.php');
                    }

                    echo '
                        <div class="card-body">
                                <h4 class="card-title"> ' . $name . '</h4>
                                <h5 class="card-title">Rating: ' . $rate . '</h5>
                                <h5 class="card-title">District: ' . $dis . '</h5>
                                <a href="../Student/viewTutor.php?tid=' . $id . '&sid=' . $subjectID . '" class="btn btn-secondary">View</a>
                                <a href="submit.php?id=' . $id . '&sid=' . $subjectID . '&type=enroll" class="btn btn-primary">Enroll</a>
                        </div>
                        
                </div>';
            }
        echo '</div>';
            echo '<a href="joinClass.php" class="btn btn-primary"> Back to Search</a><br/>';
    echo '</div>';
    ?>

</body>
</html>

