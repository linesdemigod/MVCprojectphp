<!-- START HERE -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Banks</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php echo URLROOT; ?>/pages/index">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/contact">Contact</a>
          </li>
          <li class="nav-item">
            <?php if (isset($_SESSION['user_id'])): ?>
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
            <?php else: ?>
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
              <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>
