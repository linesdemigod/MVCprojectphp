<?php 
    require APPROOT . '/views/includes/head.php';
?>


<?php 
    require APPROOT . '/views/includes/navigation.php';
?>

<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                    <div class="card p-4">
                        <div class="card-body">
                            <h3 class="text-center">Registration Form</h3>
                            <hr>
                            <form action="<?php echo URLROOT; ?>/users/register" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control" placeholder="Username">
                                            <p class="text-center text-danger"><?php echo $data['usernameError']?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" placeholder="Email">
                                        </div>
                                        <p class="text-center text-danger"><?php echo $data['emailError']?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            <p class="text-center text-danger"><?php echo $data['passwordError']?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm password">
                                            <p class="text-center text-danger"><?php echo $data['confirmPasswordError']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="Register" class="btn btn-primary btn-block">
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

<?php 
    require APPROOT . '/views/includes/footer.php';
?>