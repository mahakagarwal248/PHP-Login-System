<?php

    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="login";

    $conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    if(!$conn){
    die("Error" . mysqli_connect_error());
    }
    $login= false;
    $showError = false;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];


        $query = "SELECT * FROM `users` Where `username`='$username'";
        $result= mysqli_query($conn, $query);
        $num = mysqli_num_rows($result);
        if($num == 1){
            while($row = mysqli_fetch_assoc($result)){
                if(password_verify($password, $row['password'])){
                    $login=true;
                    session_start();
                    $_SESSION['loggedin']= true;
                    $_SESSION['username']= $username;
                    header("location: welcome.php");
                }else{
                    $showError = "Invalid Credentials";
                }
            }
            
        }else{
            $showError = "Username doesn't exist.";
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

    <title>Login</title>
    <style>
      form{
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: smaller;
        margin-top: 25px;
      }
      label{
        font-size: 16px;
      }
      button{
          margin-top: 20px;
      }

    </style>
  </head>
  <body>
        <?php
            if($login){
                echo ' <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <strong>Success!</strong> You are logged in.
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
        <button type="button" class="btn btn-link" style="font-style: oblique; font-size: 25px; border: 2px black solid;">
			<a href="home.php" style="font-weight: bold;">Home</a>
		</button>
        <div class="container">
            <h1 class="text-center">Login Here</h1>
        </div>
        <form action="login.php" method="POST">
        <div class="form-group col-md-4">
            <label for="username" >Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username">
        </div>
        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary col-sm-3">Login</button>
        </form>
        

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>