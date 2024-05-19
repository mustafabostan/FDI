<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/bc384378e9.js" crossorigin="anonymous"></script>
    <title>admin</title>
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


</body>

</html>