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
    <title>Edit User</title>
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
    $stmt = $con->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    ?>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card w-50">
            <div class="card-header">
                <h1 class="text-center">Edit User</h1>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="name">Username:</label>
                        <input type="text" class="form-control" id="name" name="username" value="<?php echo $row['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Hashed Password:</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <a type="submit" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</a>
                    </div>
                    <div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Password</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="newpassword">New Password:</label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password:</label>
                                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input class="btn btn-secondary" data-bs-dismiss="modal" value="Close">
                                    <input type="submit" id="change-pass" name="change-pass" class="btn btn-primary" value="Change Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">User Type:</label>
                        <select class="form-control" id="user_type" name="user_type">
                            <option value="0" <?php if ($row['user_type'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="1" <?php if ($row['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                    </div>
                    <div class="form-group text-center mt-1">
                        <input type="reset" class="btn btn-warning" value="Reset"></input>
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit"></input>
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
    function updateuser()
    {
        global $con;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $user_type = $_POST['user_type'];
            switch ($user_type) {
                case 0:
                    $user_type = 'user';
                    break;
                case 1:
                    $user_type = 'admin';
                    break;
            }
            
            $stmt = $con->prepare("UPDATE user SET username=?, email=?, user_type=? WHERE id=?");
            $stmt->bind_param("sssi", $username, $email, $user_type, $id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {                            
                header('Location: usermanagement.php?update=success');
            } else {
                echo "<script>document.getElementById('alert').innerHTML = 'Error updating record: $stmt->error';
                    document.getElementById('alert').classList.add('alert', 'alert-danger');";
            }
        }
    }

    if (isset($_POST['submit'])) {
        updateuser();
    }

    function updatepassword()
    {
        global $con;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $newpassword = $_POST['newpassword'];
            $confirmpassword = $_POST['confirmpassword'];
            if ($newpassword == $confirmpassword) {
                $hashedpassword = md5($newpassword);
                $stmt = $con->prepare("UPDATE user SET password=? WHERE id=?");
                $stmt->bind_param("si", $hashedpassword, $id);
                $stmt->execute();                
                if ($stmt->affected_rows > 0) {
                    echo "<script>document.getElementById('alert').innerHTML = 'Password updated successfully';
                    document.getElementById('alert').classList.add('alert', 'alert-success');
                    </script>";
                } else {
                    echo "<script>document.getElementById('alert').innerHTML = 'Error updating record: $stmt->error;
                    document.getElementById('alert').classList.add('alert', 'alert-danger');";
                }
            } else {
                echo "<script>document.getElementById('alert').innerHTML = 'Passwords do not match';
                document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
            }
        }
    }

    if (isset($_POST['change-pass'])) {
        updatepassword();
    }

    ob_end_flush();
    ?>
</body>

</html>