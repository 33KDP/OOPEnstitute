<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_SESSION['user_id'])) {
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
            $curTutor = Tutor::getInstance(Tutor::getUserId($_GET['tid']));
            $curTutor->readReviews();
            $reviews = $curTutor->getReviewList();
        ?>

        <div class="container p-5 shadow my-5 rounded-3">
            <div>
                <h5>Name:</h5>
                <?= htmlentities($curTutor->getFName()) ?> <?= htmlentities($curTutor->getLName()) ?>
            </div><br/>

            <div>
                <h5>District:</h5>
                <?= htmlentities($curTutor->getDistrict()) ?>
            </div><br/>

            <div>
                <h5>City:</h5>
                <?= htmlentities($curTutor->getCity()) ?>
            </div><br/>

            <div>
                <h5>Email:</h5>
                <?= htmlentities($curTutor->getEmail()) ?>
            </div><br/>

            <div>
                <h5>Mobile:</h5>
                Mobile Number Not Available
            </div><br/>

            <div>
                <h5>Description:</h5>
                <?php
                    if (!empty($curTutor->getDescription())) {
                        echo htmlentities($curTutor->getDescription());
                    } else {
                        echo "No Description";
                    } ?>
                </h5>
            </div><br/>

            <div>
                <h5>Available Time Slots: </h5>

                <?php
                    if (!empty($curTutor->getDescription())) {
                        echo '<div class="container p-4">';
                        echo '<div class="row">';
                        foreach ($curTutor->getTimeSlots() as $timeSlot) {
                            echo '<div class="col-3">';
                            echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                                                <div class="card-body">
                                                    <h5 class="card-title">' . htmlentities($timeSlot->getDay()) . '</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">' . htmlentities(Timeslot::getTime12($timeSlot->getStartTime())) . ' - ' . htmlentities(Timeslot::getTime12($timeSlot->getEndTime())) . '</h6>
                                                    <div class="my-3">';
                            if (!$timeSlot->getNotAvailable()) {
                                echo '<span class="badge rounded-pill bg-success">Vacant</span>';
                            } else {
                                echo '<span class="badge rounded-pill bg-warning text-dark">Occupied</span></td>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo "No Available Time Slots to Preview. Please Contact the tutor";
                    }
                ?>
            </div>
            <br>
            <div>
                <a class="btn btn-primary" href="../User/message.php?receiver_id='.$tutor->getId().'">Send Message</a>
            </div><br>
            <h2 style="display:inline">Reviews &emsp; &emsp; &emsp;</h2>
        </div>

        <?php
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