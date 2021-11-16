<?php
require_once "../classes/DBConn.class.php";
require_once "../classes/Tutor.class.php";

if (!isset($_SESSION['user_id'])){
    header("location: ../index.php");
}
$curStudent=  Student::getInstance($_SESSION['user_id']);
?>

<html>
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "head.php"; ?>
</head>

<body class="sb-nav-fixed">
<?php require_once "navbar.php";
        echo '<div><h1>Welcome '. $curStudent->getFName().' '.$curStudent->getLName().'</h1></div>'
?>
        <div class="position-fixed"  style="top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 1000">
            <a href="../Class/joinClass.php">
                <button>Join a Tutor</button>
            </a>
        </div>

        <div class="position-fixed"  style="top: 40%; left: 50%; transform: translate(-50%, -50%); z-index: 1000">
            <a href="../Class/index.php">
                <button>Manage Classes</button>
            </a>
        </div>

        <div class="position-fixed"  style="top: 90%; left: 50%; transform: translate(-50%, -50%); z-index: 1000">
        <footer class="py-4 bg-light mt-auto">
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
</body>
</html>

