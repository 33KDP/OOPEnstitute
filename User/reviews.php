<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/tutor.class.php";

    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $usertype_id = User::getUserType($user_id);

        if ($usertype_id == 1){
            $curUser = Student::getInstance($user_id);
            require_once "../Student/head.php";
            require_once "../Student/navbar.php";            
        }
        else{
            $curUser = Tutor::getInstance($user_id);
            require_once "../tutor/head.php";
            require_once "../tutor/navbar.php";            
        }
        $curUser->readReviews();
        $reviews = $curUser->getReviewList();
    }
    else
        header("location: ../index.php");

?>

        <style>
            <?php include "css/style.css"; ?>
        </style>

        <?php
            echo'
                <div class="container p-5">
                    <h2 style="display:inline">Reviews &emsp; &emsp; &emsp;</h2>
            ';

            if (null != $curUser->getRating())
                echo '
                    <h4 style="display:inline">Overall Rating : '.
                        $curUser->getRating()
                    .' Stars</h4><br><hr>
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
    </body>
</html>