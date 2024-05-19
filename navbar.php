<nav class="navbar navbar-expand-lg p-3" style="background-color: #FFF2D5;" id="headerNav">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navba-nav">
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link mx-2" href="home.php">
            <img src="assets/img/logo-circle.png" height="70px" />
          </a>
        </li>
      </ul>
      <ul class="navbar-nav mx-auto ">
        <li class="nav-item">
          <a class="nav-link mx-2" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
            Cart
          </a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
          <li class="nav-item">
            <label class='nav-link mx-2' for="username">
              <i class="fa-solid fa-user"></i>
              <?php echo $_SESSION['username'] ?></label>
          </li>
          <li class='nav-item'>
            <a href="logout.php" class='nav-link mx-2'>Log Out</a>
          </li>
          <?php
          if ($_SESSION['user_type'] == 'admin') : ?>
            <li class="nav-item">
              <a class="nav-link mx-2" href="admin.php">Admin Page</a>
            </li>
          <?php endif; ?>
        <?php } else {; ?>
          <li class="nav-item">
            <a class="nav-link mx-2" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="sign-up.php">Sign Up</a>
          </li>
        <?php } ?>

      </ul>
    </div>
  </div>
</nav>