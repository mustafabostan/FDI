<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/bc384378e9.js" crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body>
    <?php
    include 'connect.php';
    session_start();
    include 'navbar.php';
    $product_type = filter_input(INPUT_POST, 'product_filter', FILTER_SANITIZE_STRING);
    ?>
    <div class="container mt-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <h1>Products</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Filter: </h5>
                                <select class="form-select ms-1" name="product_filter" id="product_filter">
                                    <option value="All" <?php echo ($product_type == 'All' || $product_type == NULL) ? 'selected' : ''; ?>>All</option>
                                    <option value="meal" <?php echo $product_type == 'meal' ? 'selected' : ''; ?>>Meal</option>
                                    <option value="desert" <?php echo $product_type == 'desert' ? 'selected' : ''; ?>>Desert</option>
                                    <option value="drink" <?php echo $product_type == 'drink' ? 'selected' : ''; ?>>Drink</option>
                                </select>
                                <input class="btn btn-primary ms-2" type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $stmt = $con->prepare("SELECT * FROM product");
                if ($product_type == 'All' || $product_type == NULL) {
                    $stmt = $con->prepare("SELECT * FROM product");
                } else {
                    $stmt = $con->prepare("SELECT * FROM product WHERE product_type = ?");
                    $stmt->bind_param("s", $product_type);
                }
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-sm-3 mt-2'>";
                    echo "<div class='card' style='width: 19rem; height: 28rem;'>";
                    echo "<div class='card-body'>";
                    echo "<img style='width:17rem; height: 17rem;' src='" . $row['image_path'] . "' class='card-img-top' alt='" . $row['productname'] . "'>";
                    echo "<h5 class='card-title'>" . $row['productname'] . "</h5>";
                    $description = $row['description'];
                    $short_description = substr($description, 0, 35);
                    if (strlen($description) > 35) {
                        $short_description .= '...';
                    }
                    echo "<p class='card-text'>" . $short_description . "</p>";
                    echo "<p class='card-text'>Price: " . $row['price'] . " TL</p>";
                    echo "<form action='";
                    echo htmlspecialchars($_SERVER["PHP_SELF"]);
                    echo "' method='post'>";
                    echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo "<input type='hidden' name='user_id' value='" . $_SESSION['id'] . "'>";
                        echo "<input type='submit' class='btn btn-primary' value='Add to Cart'>";
                    } else {
                        echo "<a href='login.php' class='btn btn-primary'>Login to Add to Cart</a>";
                    }
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['user_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_POST['user_id'];
        $stmt = $con->prepare("SELECT * FROM cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
        $cart = $stmt->get_result();
        if ($cart->num_rows > 0) {
            $stmt = $con->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $product_id, $user_id);
        } else {
            $stmt = $con->prepare("INSERT INTO cart (product_id, user_id, quantity) VALUES (?, ?, 1)");
            $stmt->bind_param("ii", $product_id, $user_id);
        }
        $stmt->execute();
    }

    ?>




</body>
<?php
include 'footer.php';
?>
    
</html>