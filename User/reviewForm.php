<?php 
    require_once "../bootstrap.php";

    if (isset($_POST['submit'])) {
        echo $_POST['rate'];
        echo $_POST['review'];
    }
?>

<link rel="stylesheet" type="text/css" href="../User/css/style.css">

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReviewModal" >Review</button>
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
                            <label for="rate" class="col-form-label">Star rating :</label>
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
                        <label for="message-text" class="col-form-label">Review:</label>
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