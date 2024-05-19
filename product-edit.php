<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <title>Edit Product</title>
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
    ob_start();
    session_start();
    include 'connect.php';
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
        header('Location: home.php');
    }
    include 'admin_navbar.php';
    global $con;
    $id = $_POST['id'];
    $stmt = $con->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    ?>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card w-50">
            <div class="card-header">
                <h1 class="text-center">Edit Product</h1>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="productname">Product Name</label>
                        <input type="text" class="form-control" id="name" name="productname" value="<?php echo $row['productname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo $row['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step=0.01 class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="product-type">Product Type</label>
                        <select class="form-control" id="product-type" name="product-type">
                            <option value="1" <?php if ($row['product_type'] == 'meal') echo 'selected'; ?>>Meal</option>
                            <option value="2" <?php if ($row['product_type'] == 'desert') echo 'selected'; ?>>Desert</option>
                            <option value="3" <?php if ($row['product_type'] == 'drink') echo 'selected'; ?>>Drink</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="product-img">Image</label>
                        <div class="d-flex">
                            <img class='img-thumbnail' id='product-image' src="<?php echo $row['image_path']; ?>" style="width: 150px; height: 150px;">
                            <input type="file" class="form-control align-self-center ms-1" id="newimage" name="newimage">
                        </div>
                    </div>
                    <div class="form-group text-center mt-1">
                        <input type="reset" class="btn btn-warning" value="Reset"></input>
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save Changes"></input>
                    </div>

                </form>
            </div>
            <div class="card-footer">
                <div class="form-group text-center mt-3">
                    <div role='alert' id="alert"></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    ob_start();
    include 'connect.php';
    function updateProduct()
    {
        global $con;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $productname = $_POST['productname'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $product_type = $_POST['product-type'];
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['newimage']['tmp_name']);
            if (move_uploaded_file($_FILES['newimage']['tmp_name'], $target_file)) {
                $stmt = $con->prepare("UPDATE product SET productname = ?, description = ?, price = ?, product_type = ?, image_path = ? WHERE id = ?");
                $stmt->bind_param("ssdssi", $productname, $description, $price, $product_type, $target_file, $id);                
                if ($stmt->execute()) {
                    header('Location: productmanagement.php?update=success');
                } else {
                    echo "<script>document.getElementById('alert').innerHTML = 'Error updating record: $stmt->error;
                    document.getElementById('alert').classList.add('alert', 'alert-danger');";
                }
            } else {
                $stmt = $con->prepare("UPDATE product SET productname = ?, description = ?, price = ?, product_type = ? WHERE id = ?");
                $stmt->bind_param("ssdsi", $productname, $description, $price, $product_type, $id);                
                if ($stmt->execute()) {
                    header('Location: productmanagement.php?update=success');
                } else {
                    echo "<script>document.getElementById('alert').innerHTML = 'Error updating record: $stmt->error;
                    document.getElementById('alert').classList.add('alert', 'alert-danger');";
                }
            }
        }
    }

    if (isset($_POST['submit'])) {
        updateProduct();
    }

    ob_end_flush();
    ?>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#product-image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#newimage").change(function() {
            readURL(this);
        });
    </script>
</body>

</html>