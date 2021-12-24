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

    $lastURL = array('subId' => $subjectID, 'district' => $district );
    $_SESSION ['lastURL'] = $lastURL;

    $search_query = "SELECT `group`.group_name, `group`.id,`group`.capacity, District.district,  
                     FROM `group` JOIN District
                     ON `group`.district = District.district
                     WHERE `group`.Subject_id = '$subjectID' ";

    if ($district != "") {
        $search_query .= " AND District.district='$district'";
    }


    $search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
    $search_query->execute();


}
?>

<?php require_once "../Student/head.php"; ?>

<body class="sb-nav-fixed">
<?php require_once "../Student/navbar.php";

    while ($row = $search_query->fetch(PDO::FETCH_ASSOC)) {
        $proxy = new StudentGroupProxy($row['id']);

        $qry = "SELECT groupclass.tutor_id FROM groupclass WHERE group_id = '$proxy->getGroupId()' ";
        $search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
        $search_query->execute();

        if (($row_1 = $search_query->fetch(PDO::FETCH_ASSOC)) !== false) {
            $tutor = $row_1['tutor_id'];
        } else {
            $tutor = NULL;
        }

        echo '<div class="card" style="background-color:black;color: #dddddd ">
                  <div class="card-header">
                    ' . $group_name . '
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">District: ' . $district . '</h5>
                    <a href="tutorDetails.php?id=' . $id . '&sid=' . $subjectID . '"><button>View</button></a>
                    <a href="submit.php?id=' . $id . '&sid=' . $subjectID . '" ><button>Enroll</button></a>
                  </div>
                </div>';
}
?>