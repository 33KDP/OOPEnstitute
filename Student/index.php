<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Tutor.class.php";
require_once "../classes/Student.class.php";


if (!isset($_SESSION['user_id'])){
    header("location: ../index.php");
}
$curStudent=  Student::getInstance($_SESSION['user_id']);

?>


<?php require_once "../bootstrap.php"; ?>
<?php require_once "head.php"; ?>


<body class="sb-nav-fixed">
<?php require_once "navbar.php";

        echo '
                <div class="title">
                <h1>Welcome <br/>'.$curStudent->getFName().' '.$curStudent->getLName().'</h1>
                </div>'
?>



            <a href="../Class/joinClass.php">
                <button>Join a Tutor</button>
            </a><br/>

            <a href="../Class/individualClassList.php">
                <button>Manage Classes</button>
            </a><br/>

            <h2 style="color: white"> Groups </h2>
            <a href="../Group/manage_group.php">
                <button>Manage Groups</button>
            </a><br/>

            <a href="../Group/join_group.php">
                <button>Join Groups</button>
            </a><br/>

            <br/>
            <br/>

            <ul>
                <li>
                    <a href="../Group/create_group.php" onclick="kevin()">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span class="fab_fa-css3-alt" style="align-content: center">Create <br/> Group</span>
                    </a>

                </li>
            </ul><br/>

        <footer class="py-4 bg-dark mt-auto">
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
        </footer>
        </div>

<div>

</body>
<?php require_once "foot.php"?>

