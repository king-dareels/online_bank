<?php

    session_start();
    include('../db/db_connect.php');
     $admin_id = $_SESSION['admin_id'];
     $admin_name = $_SESSION['admin_name'];
   ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <marquee><h3>Logged in Admin <span style="color:green"><?php echo $admin_name ?></span></h3></marquee>
    <hr>
    <a href="admin_home.php">Dashboard</a>
    <a href="add_customer.php">Add Customer</a>
    <a href="view_customer.php">View Customer</a>
    <a href="logout.php">Click to Logout</a>
</body>
</html>