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
    <title>Product Management</title>
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
    <div class="container mt-3">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Product Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'connect.php';
                        global $con;
                        $sql = "SELECT * FROM product";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td><img src=" . $row['image_path'] . " width='100px' height='100px'></td>";
                                echo "<td>" . $row['productname'] . "</td>";
                                $description = $row['description'];
                                $short_description = substr($description, 0, 70);
                                if (strlen($description) > 70) {
                                    $short_description .= '...';
                                }
                                echo "<td>" . $short_description . "</td>";
                                echo "<td>" . $row['price'] . " TL</td>";
                                echo "<td>" . $row['product_type'] . "</td>";                               
                                echo "<td><div class='d-flex'><form method='POST' action='product-edit.php'>";
                                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                echo "<input type='submit' class='btn btn-primary' value='Edit'>";
                                echo "</form>";
                                echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                echo "<button type='button' class='btn btn-danger ms-1' data-bs-toggle='modal' data-bs-target='#deleteModal'><i class='fa-solid fa-trash'></i></button>";
                                echo "</form></div></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form method='POST' action=''>
                            <input type='hidden' id='deleteId' name='id' value=''>
                            <input type='submit' name='delete' class='btn btn-danger' value='Yes'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Product updated successfully.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            $('.btn-danger').click(function() {
                var id = $(this).parent().find('input[type=hidden]').val();
                $('#deleteId').val(id);
            });
        });

        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('update') === 'success') {
                $('#successModal').modal('show');
            }
        });
    </script>

    <?php
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $con->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);        
        if ($stmt->execute()) {
            echo "<script>$(document).ready(function() { $('#myModal').modal('show'); setTimeout(function(){ window.location.href = window.location.href; }, 10); });</script>";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
    }
    ?>
</body>

</html>