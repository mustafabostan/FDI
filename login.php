<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <script src="assets/js/bootstrap.js"></script>
  <title>Login</title>
</head>

<body>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="assets/img/login.png" alt="login form" class="img-fluid" style="border-radius: 2rem 0 0 2rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <div role='alert' id="alert"></div>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <div class="d-flex align-items-center flex-column mb-3 pb-1">
                    <img src="assets/img/logo-circle.png" alt="" width="150px" height="150px">
                  </div>
                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                  <div class="form-outline mb-4">
                    <label class="form-label" for="Username">Username</label>
                    <input type="text" name="username" id="username" class="form-control form-control-lg" required />
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                  </div>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                    <a class="btn btn-dark btn-lg btn-block" type="button" href="sign-up.php">Sign Up</a>
                  </div>

                  <a class="small text-muted" href="#!">Forgot password?</a>
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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $message = "";
    $stmt = $con->prepare("SELECT id, username, password, user_type FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();    
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      $hash = $row['password'];
      if (md5($password) == $hash) {
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_type'] = $row['user_type'];
        header("Location: home.php");
      } else {
        $message = "Invalid password";
        echo "<script>document.getElementById('alert').innerHTML = '$message';"
          . "document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
      }
    } else {
      $message = "Invalid username";
      echo "<script>document.getElementById('alert').innerHTML = '$message';"
        . "document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
    }
  }



  ?>
</body>

</html>