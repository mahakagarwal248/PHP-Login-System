<?php

  $dbhost="localhost";
  $dbuser="root";
  $dbpass="";
  $dbname="login";

  $conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
  if(!$conn){
    die("Error" . mysqli_connect_error());
  }

  
  $Alert= false;
  $showError= false;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
      $username= $_POST['username'];
      $password= $_POST['password'];
      $cpassword= $_POST['cpassword'];
      $mno= $_POST['mnumber'];
      $email= $_POST['email'];
      $exsits= false;
      $existsquery= "SELECT * FROM users WHERE username='$username'";
      $res= mysqli_query($conn, $existsquery);
      $num= mysqli_num_rows($res);
      if($num > 0){
        $exsits = true;
        $showError = "Error! Username already exsists.";
      }else{

        if($password == $cpassword){
          $hash = password_hash($password, PASSWORD_DEFAULT);
          $sql= "INSERT into users (`username`,`password`,`mnumber`,`email`) values('$username','$hash','$mno','$email')";
          $result = mysqli_query($conn,$sql);
          if($result){
            $Alert= true;
          }
        }else{
          $showError = "Error! Passwords do not match.";
      } 
    }
  }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Signup</title>
    <style>
      form{
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: smaller;
      }
      label{
        font-size: 16px;
      }

    </style>
  </head>
  <body>
    <?php
    if($Alert){
      echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You can login now by <a href="login.php">clicking here</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> ';
    }
    if($showError){
      echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry!</strong>' . ' ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> ';
    }
    ?>

    <div class="container">
      <h1 class="text-center">Signup Here</h1>
    </div>

    <form action="/phploginsystem/signup.php" method="POST">
        <div class="form-group col-md-6">
          <label for="username">Username</label>
          <input type="text" minlength= "6" maxlength="15" class="form-control" id="username" name="username" aria-describedby="emailHelp">
        </div>
        <div class="form-group col-md-6">
          <label for="password">Password</label>
          <input type="password" minlength="5" maxlength="15" class="form-control" id="password" name="password">
          <small id="passwordInstrution" class="form-text text-muted">Password must be 6-15 characters long.</small>
        </div>
        <div class="form-group col-md-6">
          <label for="cpassword">Confirm Password</label>
          <input type="password" class="form-control" id="cpassword" name="cpassword">
        </div>
        <div class="form-group col-md-6">
          <label for="mnumber">Mobile number</label>
          <input type="tel" minlength="10" class="form-control" id="mnumber" name="mnumber">
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email Address</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
        
        
        <button type="submit" class="btn btn-primary col-sm-4">Signup</button>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>