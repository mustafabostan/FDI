<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/bc384378e9.js" crossorigin="anonymous"></script>
    <title>Cart</title>
</head>

<body>
    <?php
    include 'connect.php';
    session_start();
    if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
        header("Location: login.php");
        exit;
    }
    include 'navbar.php';
    $user_id = $_SESSION['id'];
    $stmt = $con->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();    
    $result = $stmt->get_result();
    ?>
    <script>
        $(document).ready(function() {
            $("input[name='quantity']").on('change', function() {
                var quantity = $(this).val();
                var product_id = $(this).data('product-id');
                if (quantity == 0) {
                    removeFromCart(product_id);
                } else {
                    $.ajax({
                        url: 'update_quantity.php',
                        type: 'POST',
                        data: {
                            product_id: product_id,
                            quantity: quantity
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            var total_price = data.total_price;
                            $("strong[data-product-id='" + product_id + "']").text(total_price + " TL");
                            var subtotal = 0;
                            $("strong[data-product-id]").each(function() {
                                subtotal += parseFloat($(this).text());
                            });
                            $("#subtotal").text("Subtotal: " + subtotal + " TL");
                        }
                    });
                }
            });
            $("button[name='delete']").on('click', function() {
                var product_id = $(this).prev().data('product-id');
                removeFromCart(product_id);
            });

            function removeFromCart(product_id) {
                $.ajax({
                    url: 'remove_cart.php',
                    type: 'POST',
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    </script>

    <div class="container mt-5">
        <div class="row">
            <div class="col col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4><strong>Shopping Cart</strong></h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-7">Product</th>
                                    <th class="col-2">Price</th>
                                    <th class="col-2">Quantity</th>
                                    <th class="col-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="list-group">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        $subtotal = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $product_id = $row['product_id'];
                                            $stmt = $con->prepare("SELECT * FROM product WHERE id = ?");
                                            $stmt->bind_param("i", $product_id);
                                            $stmt->execute();
                                            $product = $stmt->get_result()->fetch_assoc();
                                            echo "<tr>";
                                            echo "<td><img class='img-fluid rounded me-2' style='height: 80px;width: 100px;' src='" . $product['image_path'] . "'><small>" . $product['productname'] . "</small></td>";
                                            echo "<td><strong>" . $product['price'] . " TL</strong></td>";
                                            echo "<td>";
                                            echo "<div class='d-flex'>";
                                            echo "<input type='number' name='quantity' class='form-control' value='" . $row['quantity'] . "' min='0' style='width: 70px;' data-product-id='" . $product_id . "'>";
                                            echo "<button name='delete' class='btn btn-danger ms-1' type='button'><i class='fa-solid fa-trash'></i></button>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "<td><strong data-product-id='" . $product_id . "'>";
                                            $total_price = $product['price'] * $row['quantity'];
                                            echo $total_price;
                                            echo " TL</strong></td>";
                                            echo "</tr>";
                                            $subtotal += $total_price;
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No items in cart</td></tr>";
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <div class="row">
                                    <div class="col d-flex justify-content-end">
                                        <h4><strong id="subtotal">Subtotal: <?php if (mysqli_num_rows($result) > 0) {
                                                                                echo $subtotal;
                                                                                echo " TL";
                                                                            } ?> </strong></h4>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex justify-content-end">
                                        <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Accept terms and conditions</label></div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-end mt-3">
                                    <div class="col d-flex justify-content-end"><button class="btn btn-primary" type="button">Purchase</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>
<?php
include 'footer.php';
?>

</html>