<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "arpit";
$dbname = "energy_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT username FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $username = $row['username'];
} else {

    header('Location: login.php');
    exit();
}


if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
            *
            {
                font-family: Footlight MT Light;
            }
            body {
                font-family: Arial, sans-serif;
                background-image: url("dash.jpg");
                background-size: cover;
                display: flex;
                background-attachment: fixed;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                color: white;
            }
            .dashboard-container {
                color: white;
                background-color: rgba(0, 0, 0, 0.5); 
                backdrop-filter: blur(10px); 
                -webkit-backdrop-filter: blur(10px);
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                width: 350px;
                text-align: center;
                margin-top: 175px;
            }
            h2 {
                color: white;
                margin-bottom: 20px;
            }
            p {
                font-size: 16px;
                line-height: 1.5;
                color: white;
                margin-bottom: 20px;
            }
            .importance-text {
                font-style: italic;
                color: #ccc;
                margin-bottom: 30px;
            }
            .btn {
                background-color: #007bff; 
                color: white; 
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                margin: 10px;
                text-decoration: none;
                display: inline-block;
                width: 80%; 
            }
            .btn:hover { background-color: #0056b3; }
            .logout-btn {
                margin-top: 30px;
                background-color: #f44336; 
                color: white;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                text-decoration: none;
                display: inline-block;
            }
            .logout-btn:hover { background-color: #d32f2f; }

    </style>
</head>
<body>

    
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p class="importance-text">
            Energy is one of the most important resources in the modern world. It powers our homes, fuels industries, and drives technological progress. By tracking and using energy efficiently, we can create a sustainable future for generations to come.
        </p>

      
        <a href="track.php" class="btn">Track Usage and Display Statistics</a><br>
        <a href="progress.php" class="btn">See Company Energy Consumption</a><br>
        <a href="threshold.php" class="btn">Set Company Energy Usage Threshold</a><br>
        <a href="select_tips.php" class="btn">Sustainable Energy Usage Tips</a><br>
        <a href="billcalculator.php" class="btn">Energy Bill Calculation</a><br>
        <a href="unitconversion.php" class="btn">Energy Unit Conversions</a><br>
        <a href="dash.php?logout=true" class="logout-btn">Logout</a>
    </div>

</body>
</html>
