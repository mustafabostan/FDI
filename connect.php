<?php
    $con = mysqli_connect("localhost","root","","fdi");
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }
?>