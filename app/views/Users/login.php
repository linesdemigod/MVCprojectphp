<?php 
    require APPROOT . '/views/includes/head.php';
?>


<?php 
    require APPROOT . '/views/includes/navigation.php';
?>
 <?php if (isset($_SESSION['user_id'])): ?>
    <?php header('Location: ' . URLROOT . '/pages/index');?>
<?php endif;?>
<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                    <div class="card p-4">
                        <div class="card-body">
                            <h3 class="text-center">Login Form</h3>
                            <hr>
                            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control" placeholder="Username">
                                            <p class="text-center text-danger"><?php echo $data['usernameError']?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            <p class="text-center text-danger"><?php echo $data['passwordError']?></p>
                                            <p class="text-center"> <a href="<?php echo URLROOT; ?>/users/resetpassword">Forgot Password?</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                                        </div>
                                        <div class="form-group">
                                        <p class="text-center">Not registered yet? <a href="<?php echo URLROOT; ?>/users/register">Create an account!</a></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>