<nav class="navbar navbar-expand-lg p-3" style="background-color: #FFF2D5;" id="headerNav">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link mx-2" href="admin.php">
            <img src="assets/img/logo-circle.png" height="70px" />
          </a>
        </li>
      </ul>
      <ul class="navbar-nav me-auto ">
        <li class="nav-item">
          <a class="nav-link mx-2 active" href="admin.php">
            <h5>FDI ADMIN PANEL</h5>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2 " href="admin.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="add-product.php">Add Product</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Management
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="usermanagement.php">User Management</a></li>
            <li><a class="dropdown-item" href="productmanagement.php">Product Management</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="home.php">Site Home</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <label class='nav-link mx-2' for="username">
            <i class="fa-solid fa-user"></i>
            <?php echo $_SESSION['username'] ?></label>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="logout.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://kit.fontawesome.com/bc384378e9.js" crossorigin="anonymous"></script>