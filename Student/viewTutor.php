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
            <div >
                <?php echo '<a class="btn btn-primary" href="../User/message.php?receiver_id='.$curTutor->getId().'"> Send Message</a> '?>
            </div><br/>

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
                    if (!empty($curTutor->getTimeSlots())) {
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


            <?php
                if (isset($_GET['sid'])) {
                    echo '<div>';
                        $lastURL = $_SESSION['lastURL'];
                        echo '<a href="../Class/form.php?subId=' . $lastURL['subId'] .
                            '&district=' . $lastURL['district'] . '&rating=' . $lastURL['rating'] . '" class="btn btn-secondary">Cancel</a>';
                        echo '<a href="../Class/submit.php?id=' . $_GET['tid'] . '&sid=' . $_GET['sid'] . '&type=enroll" class="btn btn-primary">Enroll</a>';
                    echo '</div>';
                }
                
                echo '<br><h2 style="display:inline">Reviews &emsp; &emsp; &emsp;</h2>';

                if (null != $curTutor->getRating())
                    echo '
                        <h4 style="display:inline">Overall Rating : '.
                            $curTutor->getRating()
                        .' Stars</h4>
                    ';
            ?>

            <link rel="stylesheet" type="text/css" href="../User/css/style.css">

            <?php
            if (!isset($_GET['sid']))
                echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReviewModal" style="float: right;">Rate and Review</button>';
            ?>

            <div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ReviewModalLabel">Write a review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="../User/reviewForm.php" method="POST">
                            <div class="modal-body">
                                <div class="row justify-content-start">
                                    <div class="col-md-auto" style="padding-right:0">
                                        <label for="rate" class="col-form-label py-2">Star rating :</label>
                                    </div>
                                    <div class="col-md-auto">
                                        <div class="rate" style="padding-left:0">
                                            <input type="radio" id="star5" name="rate" value="5" />
                                            <label for="star5" title="text">5 stars</label>
                                            <input type="radio" id="star4" name="rate" value="4" />
                                            <label for="star4" title="text">4 stars</label>
                                            <input type="radio" id="star3" name="rate" value="3" />
                                            <label for="star3" title="text">3 stars</label>
                                            <input type="radio" id="star2" name="rate" value="2" />
                                            <label for="star2" title="text">2 stars</label>
                                            <input type="radio" id="star1" name="rate" value="1" />
                                            <label for="star1" title="text">1 star</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?= $curTutor->getTutorId() ?>" name="tutor">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label p-0">Review:</label>
                                    <textarea class="form-control" rows="10" name="review" id="message-text"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit review</button>
                            </div>


                        </form>

                    </div>
                </div>
            </div>

            <?php
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
        </div>

    </body>
</html>