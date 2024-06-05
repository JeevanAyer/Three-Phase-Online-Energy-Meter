<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <style>
        .required::after{
            content: "*";
            color:red ;
            font-size: 20px;
        }
        </style>
</head>
<body style="background-image: url('5.jpg');">

<h1 style="color:black; text-align:center; background-color:MediumSeaGreenDArk;"><b><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
  <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
  <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z"/>
</svg> Three Phase Online Energy Meter <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
  <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
  <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z"/>
</svg> </b></h1> 
<br>



    <div style="background-color:darkgreyy;" class="container">


        <?php
         if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];

           $Address = $_POST["Address"];
          // $file = $_POST["file"];

           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{


            $sql = "INSERT INTO users (full_name, email, password,Address) VALUES ( ?, ?, ? , '$Address')";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
         }
        ?>
        <form  action="registration.php" method="post">

            <div class="required" class="form-group">
                <input  type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="required"  class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            

            <div class="required" class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>

            <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Optional</small>
                <input type="text" class="form-control" name="Address" placeholder="Address:"> 
            </div>

         <!--   <small id="emailHelp" class="form-text text-muted">Optional</small>
             <div class="form-group">
               <label for="exampleFormControlFile1">IMAGE : </label>
               <input type="file" class="form-control-file" name="file" id="file">
              </div>
        -->


            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>

        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>
    </div>

   
<div class=" text-center"; style="color:yellow">
 <br>
<br>
<br>
<br>
<br>
<address style="color:Tomat; background-color:grey;">
<h5><u>ABOUT US: </u></h5>
This project presents a Three-phase online energy meter featuring a real-time Liquid 
Crystal Display (LCD) and a web dashboard. The meter will measure voltage, current, 
active power consumption, and total energy usage. Utilizing Built-in Wi-Fi and IoT 
techniques, the meter will then transmit the data to the Web cloud for remote accessibility. 
The web dashboard will offer a user-friendly interface for real-time monitoring. The 
recorded data will also be applied for data analysis, revealing insights into energy 
consumption patterns.
<br>
Project by: Jeevan Ayer, Razin Maharjan and Bijeta Rijal <br>
Supervised by: Ass Prof Pramish Shrestha Sir<br>
Visit us at:<br>
Example.com<br>
Kathmandu University, 28-Kilo<br>
NEPAL
</address>



</div>



</body>
</html>