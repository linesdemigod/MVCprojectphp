<?php 
    require APPROOT . '/views/includes/head.php';
?>


<?php 
    require APPROOT . '/views/includes/navigation.php';
?>

<?php if(!isLoggedIn()): ?>
    <?php header('Location: ' . URLROOT . '/users/resetpassword'); ?> 
<?php endif; ?>

<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                    <div class="card p-4">
                        <div class="card-body">
                        <h3 class="text-center">Reset Password</h3>
                            <hr>
                            
                            <form action="<?php echo URLROOT; ?>/users/createpassword" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <p class="text-center text-success"><?php echo $data['passwordSuccess']?></p>
                                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                                            <p class="text-center text-danger"><?php echo $data['passwordError']?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="repeatpassword" class="form-control" placeholder="Reapeat Password">
                                            <p class="text-center text-danger"><?php echo $data['repeatPasswordError']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" name="createpassword" value="Reset password" class="btn btn-primary btn-block">
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