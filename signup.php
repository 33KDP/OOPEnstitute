<?php 
    include_once 'header.php' ;
?>

<?php 
    include_once 'header.php';
?>

    <section class="signup-form">
        <div class="signup-form-form">
        <!--
            .inc.php or -inc.php  user cant see in the page but only.php files user can see
        -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-title text-center">
                <h4>Sign up</h4>
                </div>
                <div class="d-flex flex-column text-center">
                <form action="includes/signupController.php" method="post">
                    <div class="form-group">
                    <p>You are a</p>
                    <input type="radio"  id="student_ut" name="usertype" value="student" onclick="show();">
                    <label for="student_ut">Student</label>
                    <input type="radio" id="tutor_ut" name="usertype" value="tutor" onclick="hide();">
                    <label for="tutor_ut">Tutor</label>
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control" id="name1" name="fname" placeholder="first name...">
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control" id="name2" name="lname" placeholder="last name...">
                    </div>

                    <div class="form-group" id="grade">
                    <select class="form-control" id="grd" name="grade" placeholder="Grade...">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                    </select>
                    </div>


                    <div class="form-group">
                    <select class="form-control" id="dis" name="district"  placeholder="your distric...">
                        <option value="Ampara">Ampara</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Matale">Matale</option>
                        <option value="Matara">Matara</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Vavuniya">Vavuniya</option>
                    </select>
                    </div>


                    <div class="form-group">
                    <input type="text" class="form-control" id="cit" name="city" placeholder="your city...">
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control" id="email1" name="email" placeholder="email...">
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control" id="password1" name="pwd" placeholder="password...">
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control" id="password2" name="pwdrepeat" placeholder="repeat password...">
                    </div>
                    <button type="submit" name="signup" class="btn btn-info btn-block btn-round">Sign Up</button>
                </form>
                
                <div class="text-center text-muted delimiter">
                <?php
                if(isset($_GET["error"])){
                    if($_GET["error"]=="emptyinput"){
                        echo "<p>Fill in all fields!</p>" ;
                    }
                    else if($_GET["error"]=="invaliduid"){
                        echo "<p>Choose a proper username!</p>" ;
                    }
                    else if($_GET["error"]=="invalidemail"){
                        echo "<p>Choose a proper email!</p>" ;
                    }
                    else if($_GET["error"]=="passwordsdontmatch"){
                        echo "<p>Passwords don't match!</p>" ;
                    }
                    else if($_GET["error"]=="usernametaken"){
                        echo "<p>Your username is already taken!</p>" ;
                    }   
                    else if($_GET["error"]=="stmtfailed"){
                        echo "<p>Something went wrong, try again!</p>" ;
                    }    
                    else if($_GET["error"]=="none"){
                        echo "<p>You have signed up!</p>" ;
                    }                                   
                }
                ?>
                </div>

                </div>
            </div>
            </div>
        </div>
    </section>
<?php 
    include_once 'footer.php';
?>    

