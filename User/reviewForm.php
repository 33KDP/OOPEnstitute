<?php
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    if (isset($student)){
        $reviewer = Tutor::getInstance($_SESSION['user_id']);
        $reviewee = $student;
    }
    else if(isset($tutor)){
        $reviewer = Student::getInstance($_SESSION['user_id']);
        $reviewee = $tutor;
    }
    else{
        header("location: ../index.php");
    }

    if (isset($_POST['submit'])) {
        if (isset($_POST['rate'])) {
            $starRating = $_POST['rate'];
            $reviewText = trim($_POST['review']);
            $reviewer->writeReview($reviewer, $reviewee, $starRating, $reviewText);

            if($reviewee instanceof Tutor) {
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

<link rel="stylesheet" type="text/css" href="../User/css/style.css">

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReviewModal" style="float: right;">Rate and Review</button>
<div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ReviewModalLabel">Write a review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form method="POST">
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
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label p-0">Review:</label>
                        <textarea class="form-control" rows="10" name="review" id="message-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit" >Submit review</button>
                </div>
            </form>

        </div>
    </div>
</div>