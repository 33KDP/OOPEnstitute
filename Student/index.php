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
                <h1 class="h1">Welcome <br/>'.$curStudent->getFName().' '.$curStudent->getLName().'</h1>
                </div>'
?>

            <div class="butns">
                <div class="row">
                    <div class="column">
                        <a href="../Class/joinClass.php">
                            <button>Join a Tutor</button>
                        </a><br/>
                    </div>
                    <div class="column">
                        <a href="../Class/individualClassList.php">
                            <button>Manage Classes</button>
                        </a><br/>
                    </div>
                </div>


                <div class="row">
                    <div class="column">
                        <a href="../Group/manage_group.php">
                            <button>Manage Groups</button>
                        </a><br/>
                    </div>
                    <div class="column">
                        <a href="../Group/join_group.php">
                            <button>Join Groups</button>
                        </a><br/>
                    </div>
                </div>
            </div>

            <br/>
            <br/>

            <ul class="ul_li">
                <li>
                    <a href="../Group/create_group.php" onclick="kevin()">
                        <span class="ul_li_span"></span>
                        <span class="ul_li_span"></span>
                        <span class="ul_li_span"></span>
                        <span class="ul_li_span"></span>
                        <span class="ul_li_span" style="align-content: center; font-family: 'Bebas Neue', cursive;
    background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);">Create <br/> Group</span>
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




</body>
<?php require_once "foot.php"?>

