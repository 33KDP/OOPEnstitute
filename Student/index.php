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

echo '<br/>
    <div class="title" style="text-align: center">
    <h1>Welcome <br/>' . $curStudent->getFName() . ' ' . $curStudent->getLName() . '</h1>
    </div></br>'
?>
        <div class="position-fixed"  style="top: 70%; left: 90%; transform: translate(-50%, -50%); z-index: 1000;">
            <a href="conversations.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" fill="#0a89a6" class="bi bi-chat-quote-fill" viewBox="0 0 16 16">
                    <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM7.194 6.766a1.688 1.688 0 0 0-.227-.272 1.467 1.467 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 5.734 6C4.776 6 4 6.746 4 7.667c0 .92.776 1.666 1.734 1.666.343 0 .662-.095.931-.26-.137.389-.39.804-.81 1.22a.405.405 0 0 0 .011.59c.173.16.447.155.614-.01 1.334-1.329 1.37-2.758.941-3.706a2.461 2.461 0 0 0-.227-.4zM11 9.073c-.136.389-.39.804-.81 1.22a.405.405 0 0 0 .012.59c.172.16.446.155.613-.01 1.334-1.329 1.37-2.758.942-3.706a2.466 2.466 0 0 0-.228-.4 1.686 1.686 0 0 0-.227-.273 1.466 1.466 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 10.07 6c-.957 0-1.734.746-1.734 1.667 0 .92.777 1.666 1.734 1.666.343 0 .662-.095.931-.26z"/>
                </svg>
            </a>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <a href="../Class/joinClass.php" class="card border-0 shadow my-3" style="text-align: center; text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Join an Individual Class</h5>
                            <p class="card-text">Search and join tutors and request them for a class from here.</p>
                        </div>
                    </a>
                </div>

                <div class="col-6">
                    <?php
                    echo '<a href="../Class/individualClassList.php?id= '.$_SESSION['user_id'].' " class="card border-0 shadow my-3" style="text-align: center; text-decoration: none;"> ';
                    ?>
                        <div class="card-body">
                            <h5 class="card-title">Manage Individual Classes</h5>
                            <p class="card-text">Manage all individual classes that you have enrolled from here.</p>
                        </div>
                    </a>
                </div>

                <div class="col-6">
                    <?php echo '<a href="../Group/manage_group_request.php" class="card border-0 shadow my-3" style="text-align: center; text-decoration: none;">' ?>
                        <div class="card-body">
                            <h5 class="card-title">Manage Requests</h5>
                            <p class="card-text">View requests from other students to join your groups from here.</p>
                        </div>
                    </a>
                </div>

                <div class="col-6">
                    <a href="../Group/join_group.php" class="card border-0 shadow my-3" style="text-align: center; text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Join a Group</h5>
                            <p class="card-text">Search student groups and join groups that you like from here.</p>
                        </div>
                    </a>
                </div>

                <div class="col-6">
                    <a href="../Group/create_group.php" class="card border-0 shadow my-3" style="text-align: center; text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Create a Group</h5>
                            <p class="card-text">Create groups with conditions and become admin from here.</p>
                        </div>
                    </a>
                </div>

                <div class="col-6">
                    <a href="../Group/manage_group.php" class="card border-0 shadow my-3" style="text-align: center; text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Manage all Groups</h5>
                            <p class="card-text">Manage all groups that you have enrolled or created from here.</p>
                        </div>
                    </a>
                </div>

            </div>
        </div>

 <?php require_once '../Student/footer.php'; ?>
</body>
</html>



