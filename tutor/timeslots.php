<?php
    session_start();
    require_once "../classes/Timeslot.class.php";
    require_once  "../classes/Tutor.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
?>

<html>
    <head>
        <?php require_once "../bootstrap.php"; ?>
        <?php require_once "head.php"; ?>
    </head>
    <body>
        <?php require_once "navbar.php"; ?>

        <?php

        echo '<div class="position-fixed"  style="top: 90%; left: 90%; transform: translate(-50%, -50%);">';
        echo '<svg type="button" data-bs-toggle="modal" data-bs-target="#addEntry" xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" fill="#0a89a6" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                        </svg>';
        echo '</div>';

        echo'<div class="modal fade" id="addEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Timeslot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="addTimeslot.php" method="POST">
                      <div class="mb-3">
                        <label for="dayInput" class="form-label">Day</label>
                        <input type="text"  name="dayInput" class="form-control" id="dayInput">
                      </div>
                      <div class="mb-3">
                        <label for="startTime" class="form-label">Start time</label>
                        <input type="time"  name="startTime" class="form-control" id="startTime">
                      </div>
                      <div class="mb-3">
                        <label for="endTime" class="form-label">End time</label>
                        <input type="time" name="endTime" class="form-control" id="endTime">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="Add" value="Add" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>';

        echo '<div class="container p-4">';
        echo '<div class="row">';
        foreach ($curTutor->getTimeSlots() as $timeSlot) {
            echo '<div class="col-4">';
            echo '<div class="card mx-auto rounded-3 border-0 shadow my-3">
                                  <div class="card-body">
                                    <h5 class="card-title">'.htmlentities($timeSlot->getDay()).'</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">'.htmlentities(Timeslot::getTime12($timeSlot->getStartTime())).' - '.htmlentities(Timeslot::getTime12($timeSlot->getEndTime())).'</h6>
                                    <div class="my-3">';
            if (!$timeSlot->getNotAvailable()){
                echo '<span class="badge rounded-pill bg-success">Vacant</span>';
            } else{
                echo '<span class="badge rounded-pill bg-warning text-dark">Occupied</span>';
            }
            echo'</div>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEntry'.$timeSlot->getTimeslotId().'">Edit</button>
                                    <button class="btn btn-sm btn-secondary"  data-bs-toggle="modal" data-bs-target="#deleteEntry'.$timeSlot->getTimeslotId().'">Delete</button>
                                  </div>
                                </div>';
            echo '</div>';

            echo'<div class="modal fade" id="editEntry'.$timeSlot->getTimeslotId().'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Timeslot</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="editTimeslot.php" method="POST">
                          <div class="mb-3">
                            <label for="dayInput" class="form-label">Day</label>
                            <input type="text"  name="dayInput" class="form-control" id="dayInput" value="'.htmlentities($timeSlot->getDay()).'">
                          </div>
                          <div class="mb-3">
                            <label for="startTime" class="form-label">Start time</label>
                            <input type="time"  name="startTime" class="form-control" id="startTime" value="'.htmlentities(Timeslot::getTime24($timeSlot->getStartTime())).'">
                          </div>
                          <div class="mb-3">
                            <label for="endTime" class="form-label">End time</label>
                            <input type="time" name="endTime" class="form-control" id="endTime" value="'.htmlentities(Timeslot::getTime24($timeSlot->getStartTime())).'">
                          </div>
                          <input type="hidden" name="timeid" value="'.$timeSlot->getTimeslotId().'">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="Save" value="Save" class="btn btn-primary">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>   
                </div>';

            echo'<div class="modal fade" id="deleteEntry'.$timeSlot->getTimeslotId().'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="deleteTimeslot.php" method="POST">
                          <div class="mb-3">
                            <label for="dayInput" class="form-label">You will not be able to undo this action.</label>
                          </div>     
                          <input type="hidden" name="timeid" value="'.$timeSlot->getTimeslotId().'">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="Delete" value="Delete" class="btn btn-danger">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>   
                </div>';
        }
        echo '</div>';
        echo '</div>';


        ?>
        <script src="js/timeslot.js"></script>
    </body>
</html>
