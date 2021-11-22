<?php 
    include_once 'header.php';
    require_once("includes/utils.php");
?>

    <section class="signup-form">
        <div class="signup-form-form">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-title text-center">
                            <h4>Login</h4>
                         </div>
                        <div class="d-flex flex-column text-center">

                            <form action="includes/loginController.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email1" name="uemail" placeholder="Email...">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password1" name="pwd" placeholder="password...">
                                </div>
                                <input type="submit" name="Login" value="Login" class="btn btn-info btn-block btn-round">
                            </form>
                
                            <div class="text-center text-muted delimiter">
                                <?php
                                check_session();
                                ?>
                            </div>               
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="signup-section">Not a member yet? <a href="signup.php" class="text-info"> Sign Up</a>.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 
    include_once 'footer.php';
?>    
