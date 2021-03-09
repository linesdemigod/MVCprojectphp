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
                        <?php if(!isLoggedIn()): ?>
                           <?php header('Location: ' . URLROOT . '/users/resetpassword'); ?> 
                        <?php endif; ?>
                            <h3 class="text-center">Code verification</h3>
                            <hr>
                            <form action="<?php echo URLROOT; ?>/users/resetcode" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <p class="text-center text-success"><?php echo $data['codeSuccess']?></p>
                                            <input type="number" name="code" class="form-control" placeholder="Enter the pin here">
                                            <p class="text-center text-danger"><?php echo $data['codeError']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" name="reset-password" value="Reset password" class="btn btn-primary btn-block">
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