<?php
require_once "../classes/DBConn.class.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
}

header('Content-Type: application/json; charset=utf-8');

if (isset($_REQUEST['term'])) {
    $pdo = DBConn::getInstance()->getPDO();
    $qry = $pdo->prepare("SELECT Subject.id, SubjectMedium.medium, SubjectName.name, Grade.grade FROM Subject JOIN Grade JOIN SubjectName JOIN SubjectMedium ON
                                                            Subject.name_id = SubjectName.id AND Subject.grade_id=Grade.id AND Subject.medium_id=SubjectMedium.id WHERE SubjectName.name LIKE :prefix");
    $qry->execute(array(
        ':prefix' => $_REQUEST['term'] . '%'
    ));
    $res = array();
    while ($result = $qry->fetch(PDO::FETCH_ASSOC)) {
        $temp['label'] = $result['name'] . ': Grade ' . $result['grade'] . ', ' . $result['medium'] . ' medium';
        $temp['value'] = $result['id'];
        $res[] = $temp;

    }
    echo(json_encode($res, JSON_PRETTY_PRINT));
}