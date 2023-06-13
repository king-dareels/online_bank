<?php

    session_start();
    include('../db/db_connect.php')

   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>;;TCC Bank | Admin login</title>
</head>
<body>
    <h3>welcome!!! </h3>
    <p>Please enter your admin name and password</p>

    <?php
          if(isset($_POST['submit'])){
              if(empty($_POST['aname'])){
                  $er['aname'] = "Enter your Admin name";

              }else{
                  $aname = mysqli_real_escape_string($db, $_POST['aname']);
              }
              if(empty($_POST['pword'])){
                $er['pword'] = "Enter your Password";

            }else{
                $password = mysqli_real_escape_string($db, $_POST['pword']);
            }

            if(empty($er)){
                $select = mysqli_query($db, "SELECT * FROM admin 
                                            WHERE admin_name = '".$aname."'
                                            AND secured_password = '".md5($password)."'")
                                            or die(mysqli_error($db));
                                            // echo mysqli_num_rows($select);

                    
                   if(mysqli_num_rows($select) == 1){
                       $result = mysqli_fetch_array($select);

                    //    below we establish session variable for the admin login in
                    $_SESSION['admin_id'] = $result[0];
                    $_SESSION['admin_name'] = $result[0];

                    // below we now redirect the user to the dashboard page i.e log the user in
                     
                   header("location:admin_home.php");

                   }else{ //if it's not equal to 1
                    $msg = "Invalid admin_name and/ or Password";
                    header("location:admin_login.php?login_error=$msg");
                   }
                }
            }
              if(isset($_GET['login_error'])){
                  echo"<h4 style=\"color:red\">".$_GET['login_error']."</h4>";
              }        
      
      ?>

    <form action="" method="post">
       <p>Admin Name: <input type="text" name="aname"><span style="color:red"><?php if(isset($er['aname'])) echo $er['aname']?></span></p>
       <p>Password: <input type="password" name="pword"><span style="color:red"><?php if(isset($er['pword'])) echo $er['pword']?></span></p>


       <input type="submit" name="submit" value="Click to login">
    
    
    
    </form>
</body>
</html>