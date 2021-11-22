<?php 
    include_once 'header.php' ;
    require_once("includes/utils.php");
?>
    <link rel="stylesheet" href="assets/css/demo.css">
    <section class="index-categories">
        <?php
        if(isset($_SESSION['error'])){
            if(check_signup()){
                echo '<script>
                        document.onreadystatechange = function () {
                        var myModal = new bootstrap.Modal(document.getElementById("signup"));
                        document.onreadystatechange = function () {
                            myModal.show();
                        };
                        };
                    </script>';
            }elseif(check_login()){
                echo '<script>
                        document.onreadystatechange = function () {
                        var myModal = new bootstrap.Modal(document.getElementById("login"));
                        document.onreadystatechange = function () {
                            myModal.show();
                        };
                        };
                    </script>';
            }


        }
        ?>
        <!-- ======= Hero Section ======= -->
        <div id="hero" class="home">

            <div class="container">
                <div class="hero-content">
                    <h1>E-Nstitute<span class="typed"></span></h1>
                    <p>“E-nstitute” is an online platform which will help students to find the best suited private tutors across the island.
                        Teachers and students can register in E-nstitute and students will be able to search teachers based on the subject, teaching platforms(online/physical) and other criteria.
                        Students can find a tutors using E-nstitute based on their locations. Students can rate and review teachers by their performance.</p>
                </div>
                    <!--div class="wrapper">
                        <div class="icon facebook">
                            <div class="tooltip">Facebook</div>
                            <span><i class="fab fa-facebook-f"></i></span>
                        </div>
                        <div class="icon twitter">
                            <div class="tooltip">Twitter</div>
                            <span><i class="fab fa-twitter"></i></span>
                        </div>
                        <div class="icon instagram">
                            <div class="tooltip">Instagram</div>
                            <span><i class="fab fa-instagram"></i></span>
                        </div>
                        <div class="icon github">
                            <div class="tooltip">Github</div>
                            <span><i class="fab fa-github"></i></span>
                        </div>
                        <div class="icon youtube">
                            <div class="tooltip">Youtube</div>
                            <span><i class="fab fa-youtube"></i></span>
                        </div>
                    </div-->
            </div>
        </div>
        <!-- End Hero -->


    </section>


    <!-- Loging popup window -->
    <div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header ">
                <h5 class="modal-title" id="staticBackdropLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- var_dump("checking session");
                ?> -->
                <form action="includes/loginController.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="email1" name="uemail" placeholder="Email...">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password1" name="pwd" placeholder="password...">
                    </div>
                    <input type="submit" name="Login" value="Login" class="btn btn-info btn-block btn-round">
                </form>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="signup-section ">Not a member yet? </div><a class="nav-link text-info" type="button"  data-bs-toggle="modal" data-bs-target="#signup">Sign up</a>
                    <!-- <a href="signup.php" class="text-info"> -->
                    
                </div>
            </div>
        </div>
    </div>


    <!-- Singup popup window -->
    <div class="modal fade" id="signup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Signup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php  check_session();
                    ?>
                    <form action="includes/signupController.php" method="post">
                        <div class="form-group mx-5">
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
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="signup-section">Already a member?</div><a class="nav-link text-info" type="button"  data-bs-toggle="modal" data-bs-target="#login">login</a>
                </div>
            </div>
        </div>
    </div>



<?php 
    include_once 'footer.php';
?>    