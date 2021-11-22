<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    
    require_once "../bootstrap.php";
    require_once "head.php"; ?>
    <style>
        <?php include "../User/css/style.css" ?>
    </style>

<body>
        <?php require_once "navbar.php";
            if (!isset($_GET['tid'])){
                header("location: ../group_index.php");
            }
            $tutor = Tutor::getInstance(Tutor::getUserId($_GET['tid']));
            $tutor->readReviews();
            $reviews = $tutor->getReviewList();

            echo'
                <div class="container p-5">
                    <div>Full Name : '.
                        $tutor->getFName().' '.$tutor->getLName()
                    .'</div>
                    <div>Email : '.
                        $tutor->getEmail()
                    .'</div>
                    <div>Description : '.
                        $tutor->getDescription()
                    .'</div>                  
                    <div>District : '.
                        $tutor->getDistrict()
                    .'</div>
                    <div>City : '.
                        $tutor->getCity()
                    .'</div><br>
                    <div>
                        <a class="btn btn-primary" href="../User/message.php?receiver_id='.$tutor->getId().'">Send Message</a>
                    </div><br>
                    <h2 style="display:inline">Reviews &emsp; &emsp; &emsp;</h2>
            ';

            if (null != $tutor->getRating())
                echo '
                    <h4 style="display:inline">Overall Rating : '.
                        $tutor->getRating()
                    .' Stars</h4>
                ';

            require_once "../User/reviewForm.php";
            echo '<br><hr>';
            
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
        
    </body>
</html>