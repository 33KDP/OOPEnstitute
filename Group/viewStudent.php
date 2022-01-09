<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
?>

    <html>
        <head>
            <?php require_once "../bootstrap.php"; ?>
            <?php require_once "head.php"; ?>
        </head>
        <body>
            <style>
                <?php include "../User/css/style.css"; ?>
            </style>

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

                if (!isset($_GET['sid']))
                    header("location: ../index.php");
                
                $student = Student::getInstance(Student::getUserId($_GET['sid']));
                $student->readReviews();
                $reviews = $student->getReviewList();

                echo'
                    <div class="container p-5">
                        <div><strong>Full Name : </strong>'.
                            $student->getFName().' '.$student->getLName()
                        .'</div>
                        <div><strong>Email : </strong>'.
                            $student->getEmail()
                        .'</div>
                        <div><strong>Grade : </strong>'.
                            $student->getgrade()
                        .'</div>                  
                        <div><strong>District : </strong>'.
                            $student->getDistrict()
                        .'</div>
                        <div><strong>City : </strong>'.
                            $student->getCity()
                        .'</div><br>

                        <h2 style="display:inline">Reviews &emsp; &emsp; &emsp;</h2>
                ';
                
                if (null != $student->getRating())
                    echo '
                        <h4 style="display:inline">Overall Rating : '.
                            $student->getRating()
                        .' Stars</h4>
                    ';
            echo '
                <link rel="stylesheet" type="text/css" href="../User/css/style.css">
                <br><hr>
            ';

            foreach ($reviews as $review) {
                echo '
                    <h5 style="display:inline">'.
                    htmlentities($review->getReviewerFirstName()).' '.htmlentities($review->getReviewerLastName()).'&emsp; &emsp;
                    </h5>
                    <p style="display:inline; font-size: 13px;">'.
                    substr($review->getDate(),0,-3)
                    .'</p>
                    <div class="mt-1">
                ';

                $starRating = $review->getStarRating();
                for ($checkedStars = 1; $checkedStars <= $starRating; $checkedStars++) {
                    echo '<div class="clip-star-checked"></div>';
                }
                for ($unCheckedStars = 0; $unCheckedStars < 5-$starRating; $unCheckedStars++) {
                    echo '<div class="clip-star-unchecked"></div>';
                }

                echo '</div>
                    <p>'.
                    htmlentities($review->getReviewText())
                    .'</p><hr>
                ';
            }

            echo '</div>';
            ?>
            </div>

        </body>
    </html>