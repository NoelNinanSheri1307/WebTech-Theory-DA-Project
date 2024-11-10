<?php

session_start();


$conn = new mysqli('localhost', 'root', 'arpit', 'energy_monitoring');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['set_threshold'])) {
    $company_name = $_POST['company_name'];
    $threshold = $_POST['threshold'];

   
    $stmt = $conn->prepare("INSERT INTO energy_threshold (company_name, threshold_kwh) VALUES (?, ?)");
    $stmt->bind_param("si", $company_name, $threshold);
    $stmt->execute();
    $stmt->close();

    $_SESSION['company_name'] = $company_name;

    echo "<p><center>Energy threshold has been set successfully!</center></p>";
}


if (isset($_POST['log_consumption'])) {
    $company_name = $_SESSION['company_name'];
    $consumption_date = $_POST['consumption_date'];
    $consumption_kwh = $_POST['consumption_kwh'];

    
    $query = "SELECT threshold_kwh FROM energy_threshold WHERE company_name = '$company_name'";
    $result = $conn->query($query);
    $threshold = 0;
    if ($row = $result->fetch_assoc()) {
        $threshold = $row['threshold_kwh'];
    }

    $stmt = $conn->prepare("INSERT INTO daily_consumption (company_name, consumption_date, consumption_kwh) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $company_name, $consumption_date, $consumption_kwh);
    $stmt->execute();
    $stmt->close();

    if ($consumption_kwh > $threshold) {
        echo "<p class='alert'>Alert: Your energy consumption for $consumption_date has exceeded the set threshold of $threshold kWh!</p>";
    } else {
        echo "<p><center>Energy consumption for $consumption_date logged successfully.</center></p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Consumption Alerts</title>
    <style>
        body 
        {
            font-family: FootLight MT Light;
            margin: 20px;
            background-image:url("threshold.jpg");
            background-size:cover;
        }
        form 
        {
            margin: 20px 0;
            width: 25%;
        }

        label
        {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="date"], input[type="submit"] {
            padding: 8px;
            margin: 5px 0 15px 0;
            width: 100%;
            box-sizing: border-box;
            border-radius: 25px;
        }

        input[type="submit"] {
            background-color:yellow;
            color: black;
            font-family:Footlight MT Light;
            border: none;
            cursor: pointer;
            border-radius: 25px;
        }

        input[type="submit"]:hover {
            background-color:chocolate;
        }

        .alert {
            color: red;
            font-weight: bold;
        }

    </style>
</head><center>
<body>
    
    <h2>Set Your Energy Consumption Threshold</h2>
    <form method="POST" action="threshold.php">
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required><br><br>

        <label for="threshold">Set Energy Threshold (kWh):</label>
        <input type="number" id="threshold" name="threshold" required><br><br>

        <input type="submit" name="set_threshold" value="Set Threshold">
    </form>

    <h2>Log Energy Consumption</h2>
    <?php if (isset($_SESSION['company_name'])): ?>
        <form method="POST" action="threshold.php">
            <label for="consumption_date">Date:</label>
            <input type="date" id="consumption_date" name="consumption_date" required><br><br>

            <label for="consumption_kwh">Energy Consumption (kWh):</label>
            <input type="number" id="consumption_kwh" name="consumption_kwh" required><br><br>

            <input type="submit" name="log_consumption" value="Log Consumption">
        </form>
    <?php else: ?>
        <p>Please set the energy threshold first.</p>
    <?php endif; ?>

</body><center>
</html>
