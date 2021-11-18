<?php
    session_start();
    require_once "../classes/DBConn.class.php";

    if (empty($_GET['subId'])) {
        header ('location: joinClass.php' );

    } else{
        $subjectID = $_GET['subId'];
        $district = $_GET['district'];
        $rating = $_GET['rating'];
        $lastURL = array('subId' => $subjectID, 'district' => $district, 'rating' => $rating);
        $_SESSION ['lastURL'] = $lastURL;

        $search_query = "SELECT `User`.id, `User`.first_name, `User`.last_name, District.district, `User`.rating FROM Tutor 
                            JOIN District Join Tutor_Subject Join `User` ON `User`.id = tutor.user_id and `User`.district_id = district.id and 
                                Tutor.id = Tutor_Subject.tutor_id WHERE Tutor_Subject.Subject_id = '$subjectID' AND Tutor.availability_flag=0";
        if($district !="") {
            $search_query .= " AND District.district='$district'";
        }

        if($rating !="") {
            $search_query .= " AND User.rating='$rating'";
        }

        $search_query = DBConn::getInstance()->getPDO()->prepare($search_query);
        $search_query->execute();

        while ($row = $search_query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['first_name'] . ' ' .  $row['last_name'];
            $dis = $row['district'];
            $rate = $row['rating'];

            if (is_null($id)){
                header ('location: joinClass.php' );
            }
            ?>

<html>
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "../Student/head.php"; ?>
    <link rel="stylesheet" href="../Student/css/style.css" />
</head>

<body class="sb-nav-fixed">
    <?php require_once "../Student/navbar.php";

            echo '<div class="card" style="background-color:black;color: #dddddd ">
                      <div class="card-header">
                        '.$name.'
                      </div>
                      <div class="card-body">
                        <h5 class="card-title">Rating: '.$rate.'</h5>
                        <h5 class="card-title">District: '.$district.'</h5>
                        <a href="tutorDetails.php?id='.$id.'&sid='.$subjectID. '"><button>View</button></a>
                        <a href="submit.php?id=' .$id.'&sid='.$subjectID.'" ><button>Enroll</button></a>
                      </div>
                    </div>';
            }
    }
    ?>
