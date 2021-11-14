<?php
    require_once "../classes/DBConn.class.php";
    session_start();
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    header('Content-Type: application/json; charset=utf-8');

    if (isset($_REQUEST['term'])) {
        $pdo = DBConn::getInstance()->getPDO();
        $qry = $pdo->prepare("SELECT * FROM Subject WHERE name LIKE :prefix");
        $qry->execute(array(
            ':prefix'=>$_REQUEST['term'].'%'
        ));
        $res = array();
        while ($result = $qry->fetch(PDO::FETCH_ASSOC) ) {
            $res[] = $result['name'].': Grade '.$result['grade'].', '.$result['subject_medium'].' medium';
        }
        echo(json_encode($res, JSON_PRETTY_PRINT));
    }