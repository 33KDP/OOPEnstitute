<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/StudentGroupProxy.php";
$dbCon = DBConn::getInstance();
$pdo = $dbCon->getPDO();

if (empty($_GET['subId'])) {
    header('location: join_group.php');

} else {
    $subjectID = $_GET['subId'];
    $district = $_GET['district'];

    $lastURL = array('subId' => $subjectID, 'district' => $district);
    $_SESSION ['lastURL'] = $lastURL;

    $search_query = "SELECT `group`.group_name, `group`.id,`group`.capacity, District.district
                     FROM `group` JOIN District
                     ON `group`.district_id = District.id
                     WHERE `group`.Subject_id = '$subjectID' ";

    if ($district != "-All-") {
        $search_query .= " AND District.district='$district'";
    }

    $search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
    $search_query->execute();

    require_once "head.php";
    require_once "navbar.php";

    echo '<body>';
    echo '<br/>';
    echo '<div class=container>';

        while ($row = $search_query->fetch(PDO::FETCH_ASSOC)) {
            $proxy = new StudentGroupProxy($row['id']);

            $groupID = $proxy->getGroupId();

            $qry = "SELECT groupclass.tutor_id FROM groupclass WHERE group_id = '$groupID' ";
            $qry = DBConn::getInstance()->getPDO()->prepare($qry);
            $qry->execute();

            $count = "SELECT COUNT(*) FROM Group_Student WHERE group_id = '$groupID'";
            $count = DBConn::getInstance()->getPDO()->prepare($count);
            $count->execute();
            $countofstd = $count->fetchColumn();

            echo '<div class="card shadow border-0">
                      <div class="card-body">
                      <h5 class="card-title">' . $proxy->getName() . '</h5>
                      <p><strong>District: </strong>' . $proxy->getDistrict() . '<br>';

            if ($proxy->getCapacity() > 10000) {
                echo '<strong>Available</strong>: Unlimited Slots Available<br>';
            } else {
                echo '<strong>Available: </strong>' . ($proxy->getCapacity() - $countofstd) . ' /' . $proxy->getCapacity() . '<br>';
            }
            echo ' <strong>Created Date: </strong>' . $proxy->getCreatedDate() . '<br>';

            if (($row_1 = $qry->fetch(PDO::FETCH_ASSOC)) !== false) {
                $tutor = $row_1['tutor_id'];
                $curTutor = Tutor::getInstance(Tutor::getUserId($tutor));
                // tutor availability flag - up
                echo '<strong>Tutor:</strong> <a href="../Student/viewTutor.php?tid=' . $curTutor->getTutorId() . '">' . htmlentities($curTutor->getFName()) . ' ' . htmlentities($curTutor->getLName()) . '</a> </p>';
            } else {
                $tutor = NULL;
                echo '<strong>No tutor is assigned to this group</strong></p>';
            }

            echo '<a href="groupDetails.php?id=' . $proxy->getGroupId() . '&sid=' . $proxy->getSubjectId() . '&type=enroll"><button class="btn btn-primary">View</button></a>
    
                    <!--iff group availability flag - up-->
                    <a href="submit.php?id=' . $proxy->getGroupId() . '" ><button class="btn btn-primary">Join</button></a>
                  </div>
                </div>';
        }

    echo '<br/><div><a href="join_group.php" class="btn btn-primary"> Back to Search</a></div>';
    echo '</div>';
}
?>

<?php require_once '../Student/footer.php'; ?>
</body>
</html>

