<?php
require_once "DBConn.class.php";

class Review
{
    private  $reviewId;
    private  $reviewer;
    private  $reviewerFirstName;
    private  $reviewerLastName;
    private  $reviewee;
    private  $starRating;
    private  $reviewText;
    private  $date;
    private static $dbConn;

    public function __construct($reviewer, $reviewee, $starRating, $reviewText){
        $this->reviewer = $reviewer;
        $this->reviewerFirstName = $reviewer->getFName();
        $this->reviewerLastName = $reviewer->getLName();
        $this->reviewee = $reviewee;
        $this->starRating = $starRating;
        $this->reviewText = $reviewText;
    }

    public static function init(){
        self::$dbConn = DBConn::getInstance();
    }

    public function getReviewId()
    {
        return $this->reviewId;
    }

    public function setReviewId($reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public function getReviewer()
    {
        return $this->reviewer;
    }

    public function getReviewerFirstName()
    {
        return $this->reviewerFirstName;
    }

    public function getReviewerLastName()
    {
        return $this->reviewerLastName;
    }
    
    public function getReviewee()
    {
        return $this->reviewee;
    }

    public function getStarRating()
    {
        return $this->starRating;
    }   

    public function getReviewText()
    {
        return $this->reviewText;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function submit()
    {
        $sql = "INSERT INTO `review` (reviewer_id, reviewee_id, user_first_name, user_last_name, star_rating, review_text) VALUES (:reviewer, :reviewee, :reviewerFirstName, :reviewerLastName, :starRating, :reviewText)";
        $stmt = self::$dbConn->getPDO()->prepare($sql);
        $stmt->execute(array(
            ':reviewer' => $this->reviewer->getId(),
            ':reviewee' => $this->reviewee->getId(),
            ':reviewerFirstName' => $this->reviewerFirstName,
            ':reviewerLastName' => $this->reviewerLastName,
            ':starRating' => $this->starRating,           
            ':reviewText' => $this->reviewText ));
        
        $this->reviewee->readReviews();
        $numReviews = count($this->reviewee->getReviewList());
        $newRating = ($this->reviewee->getRating()*$numReviews + $this->starRating)/($numReviews+1);
        $this->reviewee->setRating($newRating);

    }

    public static function receiveReviews($reviewee)
    {
        $sql = "SELECT * FROM `review` WHERE reviewee_id = :revieweeId";
        $stmt = self::$dbConn->getPDO()->prepare($sql);
        $stmt->execute(array(':revieweeId'=>$reviewee->getId()));
        
        return $stmt;
    }
    
}

Review::init();