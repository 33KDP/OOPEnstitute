<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/GroupClass.class.php";

    if (!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    if (isset($_POST['Delete'])) {
        StudentGroup::deletegroup($_POST['groupid']);
        header("location: ../Student/index.php");
    }

    require_once "../bootstrap.php";
    require_once "head.php";

?>

<style>
    <?php include "../User/css/style.css" ?>
</style>

<body>
<?php
    $user_id = $_SESSION['user_id'];
    $usertype_id = User::getUserType($user_id);     
        
    if ($usertype_id == 1) {
        $curUser = Student::getInstance($user_id);
        require_once "../Student/navbar.php";
    }
    else {
        $curUser = Tutor::getInstance($user_id);
        require_once "../tutor/navbar.php";
    }     

    $groupID = $_GET['id'];
    $qry = "SELECT groupclass.tutor_id FROM groupclass WHERE group_id = '$groupID' ";
    $qry = DBConn::getInstance()->getPDO()->prepare($qry);
    $qry->execute();

    if (($row = $qry->fetch(PDO::FETCH_ASSOC)) !== false) {
        $curClass = new GroupClass($groupID);
        $curGroup = $curClass->getStudentGroup();
    }
    else
        $curGroup = new StudentGroup($groupID);

?>

<br/><div><h2>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Group Details</h2></div>
<div class="container w-50">

    <div class="container p-5 shadow my-5 rounded-3">

        <div style="text-align: center">
            <h2>
            <?= htmlentities($curGroup->getName()) ?>
            </h2>
        </div><br/>

        <div class="row">

            <div class="col-6">
                <p><strong>District:   </strong>
                <?= htmlentities($curGroup->getDistrict()) ?></p>
            </div><br/>

            <div class="col-6">
                <p><strong>Available Slots:   </strong>
                <?php
                    $groupID = $_GET['id'];
                    $count = "SELECT COUNT(*) FROM Group_Student WHERE group_id = '$groupID'";
                    $count = DBConn::getInstance()->getPDO()->prepare($count);
                    $count->execute();
                    $countofstd = $count->fetchColumn();
                    $cap = $curGroup->getCapacity();

                    if ($cap > 10000) {
                        echo 'Unlimited Slots Available';
                    } else {
                        echo '' . ($cap - $countofstd) . ' / ' . $cap;
                    }
                ?>
                </p>
            </div><br/>

            <div class="col-6">
                <p><strong>Admin:   </strong>
                <?php
                    $admin = Student::getInstance(Student::getUserId($curGroup->getAdmin()));
                    echo '<a href="viewStudent.php?sid='.$admin->getStudentId().'" style="text-decoration: none;">'.htmlentities($admin->getFName()).' '.htmlentities($admin->getLName()).'</a>';
                ?>
                </p>
            </div><br/>

            <div class="col-4">
                <p><strong>Admin Email:   </strong>
                <?= htmlentities($admin->getEmail()) ?>
                </p>
            </div><br/>

            <div class="col-6">
                <p><strong>Admin Contact:   </strong>
                <?= htmlentities("Not Available") ?>
                </p>
            </div><br/>

            <div class="col-6">
                <p><strong>Created Date:   </strong>
                <?= htmlentities($curGroup->getCreatedDate()) ?>
                </p>
            </div><br/>

            <div>
                <strong>Students List:</strong>
                <?php
                    foreach($curGroup->getStudentList() as $student)
                        echo '<br><a href="viewStudent.php?sid='.$student->getStudentId().'" style="text-decoration: none;">&ensp; &ensp; &ensp; '.htmlentities($student->getFName()).' '.htmlentities($student->getLName()).'</a> ';
                ?>
            </div><br/>

            <div><br>
                <p><strong>Description:</strong>
                <?php
                    if (!empty($curGroup->getDescription()))
                        echo htmlentities($curGroup->getDescription());
                    else
                        echo "No Description";
                ?>
                </p>
            </div><br/>

        </div>
        <?php
            $groupid = $curGroup->getGroupID();

            $qry = "SELECT groupclass.tutor_id FROM groupclass WHERE group_id = '$groupid' ";
            $qry = DBConn::getInstance()->getPDO()->prepare($qry);
            $qry->execute();

            if (($row_1 = $qry->fetch(PDO::FETCH_ASSOC)) !== false) {
                $tutor = $row_1['tutor_id'];
                $curTutor = Tutor::getInstance(Tutor::getUserId($tutor));
                // tutor availability flag - up
                if ($usertype_id == 1)
                    echo '<h5 class="card-title">Tutor: <a href="../Student/viewTutor.php?tid='.$curTutor->getTutorId().'">'.htmlentities($curTutor->getFName()).' '.htmlentities($curTutor->getLName()).'</a> </h5>';
                else
                    echo '<h5 class="card-title">Tutor: '.htmlentities($curTutor->getFName()).' '.htmlentities($curTutor->getLName()).'</h5>';
                
                echo '
                    <h5 class="card-title">TutorDetails'.$curTutor->getEmail().'</h5>
                    <h5 class="card-title">TutorCity'.$curTutor->getCity().'</h5>
                ';

            } else {
                $tutor = NULL;
                echo '<br><p class="card-title">No tutor is assigned to this group</p><br/>';
            }

            echo ' <div style="text-align: center">';
                if (isset($_GET['sid']) && (!($_GET['type'] == 'view'))) {
                    $lastURL = $_SESSION['lastURL'];
                    echo '
                        <div>
                            <a href="../Group/form.php?subId=' . $lastURL['subId'] . '&district=' . $lastURL['district'] . '" class="btn btn-secondary">Cancel</a>
                            <a href="../Group/submit.php?id=' . $_GET['id'] . '&type=enroll" class="btn btn-primary mx-2">Join</a>
                        </div>
                    ';
                }

                if ($_GET['type'] == 'view') {
                    if (($curUser instanceof Student) && $curGroup->getAdmin() == $curUser->getstudentId()) {
                        echo '
                            <div>';
                        if ($tutor === NULL ) {
                            echo '<button class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteEntry">Delete</button>';
                        }

                    echo'
                        <a href="joinClass.php?gid='.$curGroup->getGroupId().'" class="btn btn-primary mx-2">Enroll to a Tutor</a>';
                    }

                }
                echo '
                    <a href="forum.php?id='.$curGroup->getGroupId().'" class="btn btn-dark">Forum</a>
                    </div>
                ';
            echo '</div>'
        ?>

    </div>
</div>

<?php
echo'<div class="modal fade" id="deleteEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="dayInput" class="form-label">You will not be able to undo this action.</label>
                    </div>
                    <input type="hidden" name="groupid" value="' .$curGroup->getGroupId().'">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="Delete" value="Delete" class="btn btn-danger">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';

require_once '../Student/footer.php'; ?>

</body>
</html>
