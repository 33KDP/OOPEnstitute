<?php 
    include_once 'header.php' ;
    require_once("includes/utils.php");
?>
    <link rel="stylesheet" href="assets/css/demo.css">
    <section class="index-categories">
        <?php
        if(isset($_SESSION['error'])||isset($_SESSION['success'])){
            if(check_signup()){
                set_try_signup("signup");
                echo '<script>
                        document.onreadystatechange = function () {
                        var myModal = new bootstrap.Modal(document.getElementById("signup"));
                        document.onreadystatechange = function () {
                            myModal.show();
                        };
                        };
                    </script>';
            }elseif(check_login()){
                set_try_login("login");
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
                    <div class="d-grid gap-2 d-md-block">
                    <button type="button" class="btn btn-primary"><a id="logbt"  type="button"  data-bs-toggle="modal" data-bs-target="#login">Log in</a></button>
                    <button type="button" class="btn btn-primary"><a id="signbt"  type="button"  data-bs-toggle="modal" data-bs-target="#signup">Sign up</a></button>    
                    </div>
                </div>

            </div>
        </div>
        <!-- End Hero -->


    </section>


    <!-- Loging popup window -->
    <div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h3 class="modal-title">Login</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php
                if(check_login()){
                    check_session();
                }
                ?>
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
                    
                </div>
            </div>
        </div>
    </div>


    <!-- Singup popup window -->
    <div class="modal fade" id="signup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header ">
                <h3 class="modal-title">Signup </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php  
                    if(check_signup()){
                        check_session();
                    }
                    ?>
                    <form action="includes/signupController.php" method="post">

                        <div class="form-group">
                            <div>
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                                <i class="bi bi-people-fill pl-1">Are you a STUDENT or TUTOR ?</i>
                                </div>
                                <div class="mt-2">
                                    <input type="radio"  id="student_ut" name="usertype" value="student" onclick="show();">
                                    <label for="student_ut">Student</label>
                                </div>
                                <div>
                                <input type="radio" id="tutor_ut" name="usertype" value="tutor" onclick="hide();">
                                <label for="tutor_ut">Tutor</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="name1" name="fname" placeholder="first name...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name2" name="lname" placeholder="last name...">
                        </div>

                        <div class="form-group" id="grade">

                            <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book-fill" viewBox="0 0 16 16">
                            <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                            <i class="bi bi-book-fill">Select your current grade:</i>
                            </div>
                        
                        <select class="form-control" id="grd" name="grade" placeholder="Grade...">
                            <option value="5"></option>
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
                            <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-map-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8l3-4z"/>
                            <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"/>
                            </svg>
                            <i class="bi bi-pin-map-fill">Select your District:</i>
                            </div>
                        <select class="form-control" id="dis" name="district"  placeholder="your distric...">
                            <option value="Colombo"></option>
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