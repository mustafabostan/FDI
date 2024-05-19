<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <script src="assets/js/bootstrap.js"></script>
  <title>Sign Up</title>
</head>

<body>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="assets/img/login.png" alt="sign up form" class="img-fluid" style="border-radius: 2rem 0 0 2rem; height: 100%; object-fit: cover;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <div role='alert' id="alert"></div>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                  <div class="d-flex align-items-center flex-column mb-3 pb-1">
                    <img src="assets/img/logo-circle.png" alt="" width="150px" height="150px">
                  </div>
                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create your account</h5>
                  <div class="form-outline mb-4">
                    <label class="form-label">User Name</label>
                    <input type="text" name="name" class="form-control form-control-lg" />
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control form-control-lg" />
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" />
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirmpass" class="form-control form-control-lg" />
                  </div>
                  <div class="pt-1 mb-4">
                    <input class="btn btn-dark btn-lg btn-block" type="submit" name="submit" value="Sign Up"></input>
                    <input type="reset" class="btn btn-secondary btn-lg btn-block" value="Reset">
                  </div>
                  <a class="small text-muted" href="login.php">Already have an account? Login</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: home.php");
    exit;
  }

  include 'connect.php';
  function getdata()
  {
    global $con;
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (strlen($_POST['name']) < 3) {
        $errors[] = 'Name must be at least 3 characters long';
      } else {
        $name = $_POST['name'];
      }
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
      } else {
        $email = $_POST['email'];
      }
      if (strlen($_POST['password']) < 6) {
        $errors[] = 'Password must be at least 6 characters long';
      } else {
        $password = $_POST['password'];
      }
      $password = $_POST['password'];
      $confirmpass = $_POST['confirmpass'];
      if ($password !== $confirmpass) {
        $errors[] = 'Passwords do not match';
      }
      $hash = md5($password);
    }

    if (empty($errors)) {
      $stmt = $con->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $hash);
      if ($stmt->execute()) {
        echo 'User added successfully';
        header('Location: login.php');
        exit();
      } else {
        echo "<script>document.getElementById('alert').innerHTML = 'Error: $stmt . '<br>' . mysqli_error($con)';"
          . "document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
      }
    } else {
      echo "<script>document.getElementById('alert').innerHTML = '";
      echo 'Errors :';
      echo '<ul>';
      foreach ($errors as $error) {
        echo '<li>' . $error . '</li>';
      }
      echo '</ul>';
      echo "';document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
    }
  }

  if (isset($_POST['submit'])) {
    getdata();
  }
  ?>
</body>

</html>