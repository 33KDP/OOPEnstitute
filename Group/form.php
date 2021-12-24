<?php
session_start();
require_once "../classes/DBConn.class.php";
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();

if (empty($_GET['subId'])) {
    header('location: joinGroup.php');

} else {
    $subjectID = $_GET['subId'];
    $district = $_GET['district'];
    //$rating = $_GET['rating'];
    $lastURL = array('subId' => $subjectID, 'district' => $district /*, 'rating' => $rating*/);
    $_SESSION ['lastURL'] = $lastURL;

    $search_query = "SELECT `group`.group_name, `group`.id,`group`.capacity, District.district, groupclass.tutor_id,  
                     FROM `group` JOIN District Join groupclass 
                     ON `group`.district = District.district AND groupclass.group_id =`group`.id 
                     WHERE `group`.Subject_id = '$subjectID' ";

    if ($district != "") {
        $search_query .= " AND District.district='$district'";
    }

    /*if ($rating != "") {
        $search_query .= " AND User.rating='$rating'";
    }*/

    $search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
    $search_query->execute();

    while ($row = $search_query->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $dis = $row['district'];
        //$rate = $row['rating'];
    }

    if (is_null($id)) {
        header('location: joinClass.php');
    }
}
?>

<?php require_once "../Student/head.php"; ?>

<body class="sb-nav-fixed">
<?php require_once "../Student/navbar.php";

echo '<div class="card" style="background-color:black;color: #dddddd ">
                      <div class="card-header">
                        ' . $name . '
                      </div>
                      <div class="card-body">
                        <!--h5 class="card-title">Rating: $rate </h5-->
                        <h5 class="card-title">District: ' . $district . '</h5>
                        <a href="tutorDetails.php?id=' . $id . '&sid=' . $subjectID . '"><button>View</button></a>
                        <a href="submit.php?id=' . $id . '&sid=' . $subjectID . '" ><button>Enroll</button></a>
                      </div>
                    </div>';
?>
