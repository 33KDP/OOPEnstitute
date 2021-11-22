<?php
    session_start();
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }


    if (isset($_POST['submit'])) {
        if (isset($_POST['student'])){
            $student = Student::getInstance(Student::getUserId($_POST['student']));
            $reviewer = Tutor::getInstance($_SESSION['user_id']);
            $reviewee = $student;
        }
        else if(isset($_POST['tutor'])){
            $tutor = Tutor::getInstance(Tutor::getUserId($_POST['tutor']));
            $reviewer = Student::getInstance($_SESSION['user_id']);
            $reviewee = $tutor;
        }

        else{
            header("location: ../index.php");
        }

        if (isset($_POST['rate'])) {
            $starRating = $_POST['rate'];
            $reviewText = trim($_POST['review']);
            $reviewer->writeReview($reviewer, $reviewee, $starRating, $reviewText);

            if ($reviewee instanceof Tutor) {
                header("Location: ../Student/viewTutor.php?tid=".$reviewee->getTutorId()."");
                return;
            }
            else{
                header("Location: ../tutor/viewStudent.php?sid=".$reviewee->getstudentId()."");
                return;
            }

        }else{
            if ($reviewee instanceof Tutor) {
                header("Location: ../Student/viewTutor.php?tid=".$reviewee->getTutorId()."");
                return;
            }
            else{
                header("Location: ../tutor/viewStudent.php?sid=".$reviewee->getstudentId()."");
                return;
            }
        }
    }
?>
