<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Student.class.php";


if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}
$curStudent = Student::getInstance($_SESSION['user_id']);

?>

<?php require_once "../bootstrap.php"; ?>
<?php require_once "head.php"; ?>

<body>
<?php require_once "navbar.php";

echo '          <br/>
                <div class="title" style="text-align: center">
                <h1>Welcome <br/>' . $curStudent->getFName() . ' ' . $curStudent->getLName() . '</h1>
                </div></br>'

?>

        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">Join Individual Classes</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="../Class/joinClass.php" class="btn btn-primary">Join</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">Manage Individual Classes</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <?php echo '<a href="../Class/individualClassList.php?id=' . $_SESSION['user_id'] . '" class="btn btn-primary">View</a> ' ?>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">Manage Group Classes</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <?php echo '<a href="../Class/groupClassList.php?id=' . $_SESSION['user_id'] . '" class="btn btn-primary">View</a> ' ?>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">Create Group</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="../Group/create_group.php" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">Join Group</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="../Group/join_group.php" class="btn btn-primary">Join</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="card-title">Manage your Groups</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="../Group/manage_group.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

        <!--footer class="py-4 bg-dark mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2021</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer-->


