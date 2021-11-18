<?php
session_start();
require_once "../classes/DBConn.class.php";
require_once "../classes/Tutor.class.php";
require_once "../classes/Student.class.php";


if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}
$curStudent = Student::getInstance($_SESSION['user_id']);

?>


<?php require_once "../bootstrap.php"; ?>
<?php require_once "head.php"; ?>


<body class="sb-nav-fixed">
<?php require_once "navbar.php";

echo '
                <div class="title">
                <h1 class="h1">Welcome <br/>' . $curStudent->getFName() . ' ' . $curStudent->getLName() . '</h1>
                </div>'
?>

<a href="../Class/joinClass.php" style="position: absolute; top: 45%; left: 42%;">
    <button>Join a Tutor</button>
</a><br/>


<?php
echo '
            <ul class="ul_li" style="position: absolute; top: 60%; left: 15%;">
                <li>
                    <a href="../Class/individualClassList.php?id=' . $_SESSION['user_id'] . '">
                    ' ?>
<span class="ul_li_span"></span>
<span class="ul_li_span"></span>
<span class="ul_li_span"></span>
<span class="ul_li_span"></span>
<span class="ul_li_span" style="align-content: center; font-family: 'Bebas Neue', cursive;
                background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);">Individual <br/> Classes</span>
</a>
</li>
</ul><br/>

<?php
echo '
            <ul class="ul_li" style="position: absolute; top: 60%; left: 29%;">
                <li>
                    <a href="../Class/groupClassList.php?id=' . $_SESSION['user_id'] . '" > ' ?>
<span class="ul_li_span"></span>
<span class="ul_li_span"></span>
<span class="ul_li_span"></span>
<span class="ul_li_span"></span>
<span class="ul_li_span" style="align-content: center; font-family: 'Bebas Neue', cursive;
                background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);">Group <br/> Classes</span>
</a>
</li>
</ul><br/>


<ul class="ul_li" style="position: absolute; top: 60%; left: 43%;">
    <li>
        <a href="../Group/create_group.php">
            <span class="ul_li_span"></span>
            <span class="ul_li_span"></span>
            <span class="ul_li_span"></span>
            <span class="ul_li_span"></span>
            <span class="ul_li_span" style="align-content: center; font-family: 'Bebas Neue', cursive;
    background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);">Create <br/> Group</span>
        </a>
    </li>
</ul>
<br/>

<ul class="ul_li" style="position: absolute; top: 60%; left: 57%;">
    <li>
        <a href="../Group/join_group.php">
            <span class="ul_li_span"></span>
            <span class="ul_li_span"></span>
            <span class="ul_li_span"></span>
            <span class="ul_li_span"></span>
            <span class="ul_li_span" style="align-content: center; font-family: 'Bebas Neue', cursive;
                background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);">Join <br/> Group</span>
        </a>
    </li>
</ul>
<br/>

<ul class="ul_li" style="position: absolute; top: 60%; left: 71%;">
    <li>
        <a href="../Group/manage_group.php"" >
        <span class="ul_li_span"></span>
        <span class="ul_li_span"></span>
        <span class="ul_li_span"></span>
        <span class="ul_li_span"></span>
        <span class="ul_li_span" style="align-content: center; font-family: 'Bebas Neue', cursive;
                            background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);">Manage <br/> Groups</span>
        </a>
    </li>
</ul>
<br/>

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
<?php require_once "foot.php" ?>

