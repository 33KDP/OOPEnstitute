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
                     ON `group`.district_id = District.id
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
        $qry = DBConn::getInstance()->getPDO()->prepare($qry);
        $qry->execute();


        echo '<div class="card" style="background-color:black;color: #dddddd ">
                  <div class="card-header">
                    ' . $proxy->getName() . '
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">District: ' . $proxy->getDistrict() . '</h5>
                    <h5 class="card-title">:Available: Filled /' . $proxy->getCapacity() . '</h5>
                    // group availability flag - up or down
                    <h5 class="card-title">Created Date: ' . $proxy->getCreatedDate() . '</h5>';

        if (($row_1 = $qry->fetch(PDO::FETCH_ASSOC)) !== false) {
            $tutor = $row_1['tutor_id'];
            $curTutor = Tutor::getInstance(Tutor::getUserId($tutor));
            // tutor availability flag - up
            echo '<h5 class="card-title">Tutor: <a href="../Student/viewTutor.php?tid='.$curTutor->getTutorId().'">'.htmlentities($curTutor->getFName()).' '.htmlentities($curTutor->getLName()).'</a> </h5>';
        } else {
            $tutor = NULL;
            echo '<h5 class="card-title">No tutor is assigned to this group</h5>';
        }

        echo '<a href="groupDetails.php?id=' . $proxy->getGroupId() . '&sid=' . $proxy->getSubjectId() . '"><button>View</button></a>

                // iff group availability flag - up
                <a href="submit.php?id=' . $proxy->getGroupId() . '" ><button>Join</button></a>
              </div>
            </div>';
    }
?>