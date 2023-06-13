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
    <title></title>
</head>
<body>


    <marquee><h3>Logged in Admin <span style="color:green"><?php echo $admin_name ?></span></h3></marquee>

    <hr>

    <a href="admin_home.php">Dashboard</a>
    <a href="add_customer.php">Add Customer</a>
    <a href="view_customer.php">View Customer</a>
    <a href="logout.php">Click to Logout</a>
    <hr>
    <h3>Customer Registration Form</h3>
    <p>Please fill the form field below</p>


    <?php
  if(isset($_POST['add'])){

      $max_size = 2097152;
      $extension = array("image/png", "image/jpg", "image/jpeg", "image/webp", "image/jfif");


      if (!in_array($_FILES['upload']['type'], $extension)) {
        $er['fi'] = "This file is not acceptable";
      }

      if ($_FILES['upload']['size'] > $max_size) {
        $er['fi'] = "This file is too large. 2MB or below is preferred";
      }

      $filename = str_replace(" ", "_", $_FILES['upload']['name']);

      $destination = 'images/' . $filename;

      if (!move_uploaded_file($_FILES['upload']['tmp_name'], $destination)) {
        $er['fi'] = "File not successfully added";
      }


      if(empty($_POST['fn'])){
          $er['fn'] = "Enter customer Firstname";

      }else{
          $fn = mysqli_real_escape_string($db, $_POST['ln']);
      }
      if(empty($_POST['email'])){
          $er['email'] = "Enter Customer Email ";
      }else{
          $email = mysqli_real_escape_string($db, $_POST['email']);
      }

      if(empty($_POST['sex'])) {
        $er['sex'] = "Select Customer Gender";
      }else{
        $sex = mysqli_real_escape_string($db, $_POST['sex']);
      }

      if(empty($_POST['acctype'])) {
        $er['sex'] = "Select Type of Account";
      }else{
        $acctype = mysqli_real_escape_string($db, $_POST['acctype']);
      }

      if (empty($_POST['o-bal'])) {
        $er['obal'] = "Enter Account Opening Balance ";
      }elseif(!is_numeric($_POST['o-bal'])){
        $er['obal'] = "Opening Balance must be a numeric value";
      }else{
        $email = mysqli_real_escape_string($db, $_POST['o-bal']);
      }

      if(empty($_POST['pass'])){
          $er['pass'] = "Enter Customer Password ";
      }else{
          $pass = mysqli_real_escape_string($db, $_POST['pass']);
      }

      if(empty($er)) {
        $pre = 203;
        $num = rand(0000000, 9999999);
        $account_number = $pre.$num;

        $insert = mysqli_query($db, "INSERT INTO customer 
                                                  VALUES(NULL, '".$fn."',
                                                              '" . $ln . "',
                                                              '" . $email . "',
                                                              '" . $sex . "',
                                                              '" . $acctype . "',
                                                              '" . $obal . "',
                                                              '" . $obal . "',
                                                              '" . $account_number . "',
                                                              '" . $pass . "',
                                                              '" . $filename . "',
                                                              NOW(),
                                                              '" . $admin_id . "')") or die(mysqli_error($db));

          echo "<h5 style= \"color:green\">Customer Successfully Added</h5>";
      }

  }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
       <p>Firstname: <input type="text" name="fn">
       <span style = "color:red"><?php if (isset($er['fn'])) echo $er['fn'] ?></span>
       </p>
       <p>Lastname: <input type="text" name="ln">
       <span style = "color:red"><?php if (isset($er['ln'])) echo $er['ln'] ?></span>
       </p>
       <p>Email: <input type="email" name="email">
       <span style = "color:red"><?php if (isset($er['email'])) echo $er['email'] ?></span>
       </p>
       <p>Gender: Male <input type="radio" name="sex" value="M">
                  Female <input type="radio" name="sex" value="F">
                <span style = "color:red"><?php if (isset($er['sex'])) echo $er['sex'] ?></span>
        </p>

                    <?php $type = array("savings", "fixed", "Current", "Student Account", "Domicilliary", "Wallet")?>
                    <p>Account Type: <select name="acctype" >
                        <option value="">Select Type of Account</option>
                        <?php foreach($type as $type){ ?>
                      <option value="<?php echo  $type ?>"><?php echo $type ?></option> 
                     <?php } ?>
                     </select>
                    <span style = "color:red"><?php if (isset($er['acctype'])) echo $er['acctype'] ?></span>
                  </p>
    
        <p>Opening Balance: <input type = "text" name = "o-bal">
        <span style = "color:red"><?php if (isset($er['o-bal'])) echo $er['o-bal'] ?></span>
        </p>
        <p>Password: <input type = "text" name = "pass">
        <span style = "color:red"><?php if (isset($er['pass'])) echo $er['pass'] ?></span>
        </p>
        <p>Upload File: <input type = "file" name = "upload">
        <span style = "color:red"><?php if (isset($er['upload'])) echo $er['upload'] ?></span>
        </p>

        <input type = "submit" name = "add" value = "Click to Add">
    
    </form>
</body>
</html>