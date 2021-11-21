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

$search_query = "SELECT `User`.id, `User`.first_name, `User`.last_name, District.district, `User`.rating FROM Tutor 
                    JOIN District Join Tutor_Subject Join `User` ON `User`.id = tutor.user_id and 
                        `User`.district_id = district.id and Tutor.id = Tutor_Subject.tutor_id WHERE 
                            Tutor_Subject.Subject_id = '$subjectID' AND Tutor.availability_flag=0";

if ($district != "") { $search_query .= " AND District.district='$district'";
} else {
    echo '
        <p>Click on the "x" symbol to close the alert message.</p>
        <div class="alert">
            <span class="closebtn">&times;</span>
            <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
        </div>
';
    header('location: joinClass.php');
}

if ($rating != "") { $search_query .= " AND User.rating>='$rating'";}

$search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
$search_query->execute();

while ($row = $search_query->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $name = $row['first_name'] . ' ' . $row['last_name'];
    $dis = $row['district'];
    $rate = $row['rating'];

    if (is_null($id)) {
        header('location: joinClass.php');
    }
}
?>

<?php require_once "head.php";
    require_once "navbar.php";?>

<style>
    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
    }

    .alert.warning {background-color: #ff9800;}

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>



<body style="background-color: #111111; color: #dddddd">
<?php

    echo '<br/>';
    echo '<div class="container " style="padding: 3%">';
    echo '<h1>Search Results for Tutors</h1><br/>';
    echo '<br/>';
        echo '<div class="card mx-auto rounded-3 border-0 shadow my-3 bg-dark">
                    <div class="card-body" style="color: #dddddd">
                            <h5 class="card-title"> ' . $name . '</h5>
                            <h5 class="card-title">Rating: ' . $rate . '</h5>
                            <h5 class="card-title">District: ' . $district . '</h5>
                            <a href="tutorDetails.php?id=' . $id . '&sid=' . $subjectID . '"><button>View</button></a>
                            <a href="submit.php?id=' . $id . '&sid=' . $subjectID . '&type=enroll" ><button>Enroll</button></a>
                    </div>
                </div>';
    echo '</div>';
    ?>


<script>
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
</script>
</body>
</html>

