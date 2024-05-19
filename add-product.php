<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/bootstrap.bundle.js"></script>
  <title>Add Product</title>
  <style>
    body::after {
      content: "";
      background: url('assets/img/add-product.png');
      background-repeat: no-repeat;
      background-size: cover;
      filter: blur(5px);
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>

<body>
  <?php
  session_start();
  include 'connect.php';
  if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header('Location: home.php');
  }
  include 'admin_navbar.php';
  ?>


  <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card w-50">
      <div class="card-header">
        <h2 class="text-center">Add Product</h2>
      </div>
      <div class="card-body">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="productname">
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" id="type" name="type">
              <option value="1">Meal</option>
              <option value="2">Desert</option>
              <option value="3">Drink</option>
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step=0.01 class="form-control" id="price" name="price">
          </div>
          <div class="form-group mt-3 mb-3">
            <label for="file">File:</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar" accept="image/png, image/jpeg" require>
          </div>
          <div class="form-group text-center mb-1">
            <input type="reset" class="btn btn-warning" value="Reset"></input>
            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit"></input>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <div role='alert' id="alert"></div>
      </div>
    </div>
  </div>
  <p>
    <?php
    include 'connect.php';
    function addproduct()
    {
      global $con;
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $productname = $_POST['productname'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $price = $_POST['price'];

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
          $target_dir = 'uploads/';
          $target_file = $target_dir . basename($_FILES['avatar']['tmp_name']);
          if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
          }
          if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            echo "<script>document.getElementById('alert').innerHTML = 'The file " . htmlspecialchars(basename($_FILES['avatar']['name'])) . " has been uploaded.';
            document.getElementById('alert').classList.add('alert', 'alert-success');</script>";
          } else {
            echo "<script>document.getElementById('alert').innerHTML = 'Sorry, there was an error uploading your file.';
            document.getElementById('alert').classList.add('alert', 'alert-danger'); </script>";
          }
        }

        switch ($type) {
          case '1':
            $selected = 'meal';
            break;
          case '2':
            $selected = 'desert';
            break;
          case '3':
            $selected = 'drink';
            break;
          default:
            $selected = 'unknown';
            break;
        }
        if (empty($productname) || empty($description) || empty($type) || empty($price) || empty($target_file)) {
          echo "<script>document.getElementById('alert').innerHTML = 'Please fill all fields';
          document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
        } else {
          $sql = "INSERT INTO product (productname, description, price, product_type, image_path) VALUES (?, ?, ?, ?, ?)";
          if($stmt = $con->prepare($sql)){
            $stmt->bind_param("ssdss", $productname, $description, $price, $selected, $target_file);
            if($stmt->execute()){
              echo "<script>document.getElementById('alert').innerHTML = 'New record created successfully';
              document.getElementById('alert').classList.add('alert', 'alert-success');</script>";
            } else {
              echo "<script>document.getElementById('alert').innerHTML = 'Error: " . $sql . "<br>" . $stmt->error . "';
              document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";              
            }
            $stmt->close();
          } else {
            echo "<script>document.getElementById('alert').innerHTML = 'Error: " . $sql . "<br>" . $con->error . "';
            document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";          
          }         
        }
      }
      $con->close();
    }
    if (isset($_POST['submit'])) {
      addproduct();
    }
    ?>
  </p>
</body>

</html>