<!-- PHP for line diagram -->
<?php
// Database connection
require 'database.php';
// Fetch data from the database
$result = $conn->query("SELECT  Time, Energy FROM device1");

// Create an array to hold the data
$data = array();

// Add column headers
$data[] = ['TimeStamp', 'Total Energy in KWhr'];

// Add data rows
while ($row = $result->fetch_assoc()) {
    $data[] = [$row['Time'], (float)$row['Energy']/1000];
}

// Close the database connection
$conn->close();
?>



<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

// Connecting to the Database
require "database.php";

$sql = "SELECT * FROM `device1`";
$result = mysqli_query($conn, $sql);

// number of records in database
$num = mysqli_num_rows($result);
echo  " <font color = yellow font size=2 font face = 'italic'> $num </font>"  ;
echo  " <font color = yellow font size=2 font face = 'italic'> records found in the DataBase </font><br>";
?>


<!DOCTYPE html>
<html lang="en">
<head>


<style>
    /* Define your styles here */
    .red-text {
      color: red;
    }

    .blue-text {
      color: blue;
    }

    .green-text {
      color: yellowgreen;
    }
  </style>





<!-- PHP for line diagram -->
<!-- Load Google Charts library -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

            var options = {
                title: 'Energy Vs Time',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>3SEM</title>


  

</head>
<h6  style="text-align:right; color:tomato;" > <?php echo "Hi"."__".$_SESSION["email"]; ?> </h6>

  <div style="text-align:right;">
        <a  href="logout.php" class="btn btn-warning">Logout</a>
    </div>
    

    <?php
    // Replace these with your actual database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sem";

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you have a user email, replace 'user@example.com' with the actual user email
    $userEmail = $_SESSION['email'];

    // Determine the user and construct the query accordingly
    $tableName = '';
    switch ($userEmail) {
        case 'jayer695@gmail.com':
            $tableName = 'device1';
            break;
        case 'starcmitchell@gmail.com':
            $tableName = 'device1';
            break;
        case 'ronaldochristiano@gmail.com':
            $tableName = 'device1';
            break;
        case 'khadkabhishek@gmail.com':
              $tableName = 'devicce2';
              break;
        case 'shresthaaadarsha07@gmail.com':
                $tableName = 'nanu';
                break;
         case 'maharjanrajin@gmail.com':
                  $tableName = 'device1';
                  break;
         case 'shahpankah@gmail.com':
                    $tableName = 'device1';
                    break;
            case 'prajwoldahal@gmail.com':
                        $tableName = 'device3';
                        break;

        // Add more cases for other users as needed
        default:

            die('User not registered yet.');
    }

    // Fetch data based on the user's table
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

   /* if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display or process the data as needed
         //   echo "<p>Voltage: " . $row["Voltage"]. "</p>";
          //  echo "<p>Current: " . $row["Current"]. "</p>";
          
        }
    } else {
        echo "0 results";
    }
    */
    ?>





<body style="background-image: url('6.jpg');" class="bg-success p-2 text-white bg-opacity-75">

    <div style="background-image: url('6.jpg');" class="bg-success p-2 text-white bg-opacity-75"; class="container">
<h1 style="color:black; text-align:center; background-color:MediumSeaGreenDArk;"><b><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
  <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
  <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z"/>
</svg> Three Phase Online Energy Meter <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
  <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
  <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z"/>
</svg> </b></h1>

 <div class="card-body">
<table class="table table-bordered text-center">

<table class="table table-striped table-dark">
  <thead>
    <tr>
      
      <th style="color:red;text-align:center;" scope="col">Voltage(V) </th>
      <th style="color:red;text-align:center;" scope="col">Current(A) </th>
      <th style="color:red;text-align:center;" scope="col">PF</th>
      <th style="color:red;text-align:center;" scope="col">P1(W)</th>

      <th style="color:yellow;text-align:center;" scope="col">Voltage</th>
      <th style="color:yellow;text-align:center;" scope="col">Current</th>
      <th style="color:yellow;text-align:center;" scope="col">PF</th>
      <th style="color:yellow;text-align:center;" scope="col">P2</th>

      <th style="color:lightblue;text-align:center;" scope="col">Voltage</th>
      <th style="color:lightblue;text-align:center;" scope="col">Current</th>
      <th style="color:lightblue;text-align:center;" scope="col">PF</th>
      <th style="color:lightblue;text-align:center;" scope="col">P3</th>

      <th style="color:orange;text-align:center;" scope="col">TotalPower<br>(P1+P2+P3)(W)</th>
      <th style="color:green;text-align:center;" scope="col">Energy <br> Consumed(KWh)</th>
     <th scope="col"  style="color:LightGray;text-align:center;">Date & Time</th>
      
    </tr>
  </thead>
  <tbody>
    <?php

    $no=0; // maintaining serial no from 1
    $query1=mysqli_query($conn,"select * from device1 ORDER BY SN desc LIMIT 20");
    while($row=mysqli_fetch_assoc($query1)){
      $no= $no+1;    
    ?>
    
        <tr >
        <td style="text-align:center;color:red;"><?php if  ($row['Voltage1']>285){ echo $row['Voltage1']."*"; } else{ echo $row['Voltage1'];}?></td>
        <td style="text-align:center;color:red;"><?php echo $row['Current1']; ?></td>
        <td style="text-align:center;color:red;"><?php echo $row['PF1']; ?></td>
        <td style="text-align:center;color:red;"><?php echo $row['Voltage1']*$row['Current1']*$row['PF1']; ?></td>

        <td style="text-align:center;color:yellow;"><?php echo $row['Voltage2']; ?></td>
        <td style="text-align:center;color:yellow;"><?php echo $row['Current2']; ?></td>
        <td style="text-align:center;color:yellow;"><?php echo $row['PF2']; ?></td>
        <td style="text-align:center;color:yellow;"><?php echo $row['Voltage2']*$row['Current2']*$row['PF2']; ?></td>

        <td style="text-align:center;color:lightblue;"><?php echo $row['Voltage3']; ?></td>
        <td style="text-align:center;color:lightblue;"><?php echo $row['Current3']; ?></td>
        <td style="text-align:center;color:lightblue;"><?php echo $row['PF3']; ?></td>
        <td style="text-align:center;color:lightblue;"><?php echo $row['Voltage3']*$row['Current3']*$row['PF3']; ?></td>

        
        <td style="text-align:center;color:orange;"><?php echo $row['Voltage1']*$row['Current1']*$row['PF1']+$row['Voltage2']*$row['Current2']*$row['PF2']+$row['Voltage3']*$row['Current3']*$row['PF3']; ?></td>
        <td style="text-align:center;color:green;"><?php echo $row['Energy']/1000; ?></td>
       <td style="text-align:center;color:LightGray;">  <?php  echo $row['time']; ?></td>
       </tr>
    <?php } ?>
    
  </tbody>
  </table>
    </div>
    </div>


    
<!-- HTML for line diagram-->
</div> 
<!-- Display the chart -->
    <div  id="curve_chart" style="text-align:center; width: 1375px; height: 500px;"></div>
<div>


<?php

// Connecting to the Database
require_once "database.php";
$query = "SELECT * FROM device1";
$result = $conn->query($query);

// Step 2: Format data for Chart.js
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row['Power']; // Change 'your_column' to the actual column name you want to plot
}
$conn->close();
?>
<br>






<div style="text-align:center;">
<?php
require 'database.php';

// Retrieve the latest voltage and current values from the database
$sql = "SELECT Voltage1, Status FROM device1 ORDER BY time DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $voltage = $row['Voltage1'];
    $CO = $row['Status'];

    // Check for overvoltage or overcurrent conditions
    $status1 = "Normal Condition";
    if ($voltage > 290 && $CO > 10) {
        $status1 = "Both Over Voltage and Cover Opened";
    } elseif ($voltage > 290) {
        $status1 = "Over Voltage";
    } elseif ($CO > 10) {
        $status1 = "Cover Opened";
    }
//if ($voltage > 220){
//    echo '<p class="red-text">' . "Voltage: $voltage V<br>" . '</p>';
//} else
//echo '<p class="green-text">' . "Voltage: $voltage V<br>" . '</p>';
//    echo "Tempering:$CO <br>";

    if ($CO >10||$voltage>290 ){
    echo '<h3 class="red-text">' .  "Status: $status1".'</h3>';
    }
    else 
    echo '<h3 class="green-text">' . "Status: $status1<br>" . '</h3>';

} else {
    echo "No data available";
}

$conn->close();
?>
</div>
<br>
<div style="text-align:center;">
        <a  href="control.php" class="btn btn-danger">Contron Page</a>
    </div>


<br>
<br>
<br>
<br>
<br>

<div class=" text-center"; style="color:yellow">
  <h1 class="display-6"; style="color:#CB2905">Thank You!</h1>
  <div style="text-align:center;">
        <a  href="logout.php" class="btn btn-warning">Logout</a>
    </div>
<br>

  <p>
    Having trouble? <a style="color:yellow;" href="https://www.facebook.com/AyerJeevan/">Contact us</a>
  </p>
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


