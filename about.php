<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/bc384378e9.js" crossorigin="anonymous"></script>
    <title>About Us - FDI</title>
</head>

<body>
    <?php
    session_start();
    include 'navbar.php';
    ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">About FDI</h1>
                <p class="lead">Connecting you with the best homemade meals and swift delivery service.</p>
                <div class="row">
                    <div class="col-md-6">
                        <p>Welcome to FDI, your premier food delivery service that bridges the gap between culinary enthusiasts and delicious homemade meals. Our mission is to provide a platform where talented home chefs can share their culinary creations with the community, ensuring everyone has access to wholesome and tasty food.</p>
                        <h3>Our Mission</h3>
                        <p>At FDI, we strive to bring convenience and quality to your doorstep. We believe in supporting local chefs and promoting healthy, homemade meals. Our platform makes it easy for customers to explore a variety of cuisines and enjoy the comfort of home-cooked food without the hassle of cooking.</p>
                    </div>
                    <div class="col-md-6">
                        <img src="assets/img/logo-circle.png" width="100" height="100" class="img-fluid" alt="About Us Image">
                    </div>
                </div>
                <h3>Why Choose Us?</h3>
                <ul>
                    <li><i class="fas fa-utensils"></i> <strong>Variety:</strong> Discover diverse culinary delights from local home chefs.</li>
                    <li><i class="fas fa-shipping-fast"></i> <strong>Convenience:</strong> Easy ordering process and fast delivery right to your doorstep.</li>
                    <li><i class="fas fa-star"></i> <strong>Quality:</strong> Enjoy high-quality, homemade meals made with love and care.</li>
                    <li><i class="fas fa-users"></i> <strong>Community:</strong> Support local chefs and be a part of a vibrant food community.</li>
                </ul>
                <h3>Join Us Today!</h3>
                <p>Whether you are a food lover looking for the next delicious meal or a home chef ready to share your creations, FDI is the place for you. <a href="sign-up.php" class="btn btn-primary">Sign Up Now</a></p>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>
</body>

</html>
