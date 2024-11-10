<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "arpit";
$dbname = "energy_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appliance_rates = [
    "Air Conditioner" => 10, 
    "Refrigerator" => 5,
    "Washing Machine" => 7,
    "Microwave" => 8,
    "TV" => 3,
    "Lights" => 2,
    "Heater" => 12,
    "Fan" => 1,
    "Computer" => 6,
    "Car" => 15
];

$consumption_values = array_fill_keys(array_keys($appliance_rates), 0);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['track_usage'])) {
    $user = $_POST['username'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    foreach ($appliance_rates as $appliance => $rate) {
        if (isset($_POST['devices']) && in_array($appliance, $_POST['devices'])) {
            $hours_used = $_POST[$appliance . "_hours"];
            if (is_numeric($hours_used)) {
                $consumption_values[$appliance] = $hours_used * $rate;
            }
        }
    }

    $total_consumption = array_sum($consumption_values);

    $stmt = $conn->prepare("INSERT INTO energy_consumption 
        (username, date, description, air_conditioner_consumption, refrigerator_consumption, washing_machine_consumption,
        microwave_consumption, tv_consumption, lights_consumption, heater_consumption, fan_consumption, computer_consumption, 
        car_consumption, total_consumption) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssddddddddddd", $user, $date, $description, 
            $consumption_values['Air Conditioner'], $consumption_values['Refrigerator'], 
            $consumption_values['Washing Machine'], $consumption_values['Microwave'], 
            $consumption_values['TV'], $consumption_values['Lights'], $consumption_values['Heater'], 
            $consumption_values['Fan'], $consumption_values['Computer'], 
            $consumption_values['Car'], $total_consumption);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            $_SESSION['username'] = $user;
            header("Location: display.php?username=" . urlencode($user) . "&message=" . urlencode("Energy usage recorded successfully for $user!"));
            exit;
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Database error: Could not prepare statement.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Energy Usage</title>
    <style>
        * {
    font-family: Footlight MT Light;
    color: black; 
    margin: 0;  
    padding: 0; 
}

body {
    font-family: Arial, sans-serif;
    background-image: url("track.jpeg");
    background-attachment: fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    color: black; 
}

.form-container {
    color: black; 
    background-color: rgba(255, 255, 255, 0.5); 
    backdrop-filter: blur(10px); 
    -webkit-backdrop-filter: blur(10px);
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 67%;
    padding: 20px;
    box-sizing: border-box;
    text-align: center;
    margin-top: 350px; 
}

h2 {
    color: black; 
    margin-bottom: 20px;
}

input[type="text"],
input[type="date"],
textarea,
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    color: black; 
}

label {
    font-size: 14px;
    color: black; 
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    width: 100%;
}

input[type="checkbox"] {
    margin-right: 15px;
    transition:ease-in-out 0.3s;
}

.submit-btn {
    background-color:rgba(106, 63, 30, 0.759);
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    box-sizing: border-box;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: black;
}

.hours-input {
    display: none;
    margin: 5px 0;
    text-align: left;
}

.message {
    color: #d9534f;
    margin-top: 10px;
}

input[type="checkbox"]:hover {
    background-color: #e0e0e0;
    transition: background-color 0.3s ease-in-out;
}

label:hover {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    cursor: pointer;
    padding: 5px;
    transition:ease-in-out 0.3s;
}
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Track Energy Usage</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter username" required><br>
            <input type="date" name="date" required><br>
            <textarea name="description" placeholder="Description (optional)"></textarea><br>

            <h3>Devices/Appliances Used</h3>
            <?php foreach ($appliance_rates as $appliance => $rate) { ?>
                <label>
                    <input type="checkbox" name="devices[]" value="<?php echo $appliance; ?>" 
                    onclick="toggleHoursInput('<?php echo $appliance; ?>')"> 
                    <?php echo $appliance; ?> (<?php echo $rate; ?> kWh/hr)
                </label><br>
                <div id="<?php echo $appliance; ?>_hours_input" class="hours-input">
                    <label for="<?php echo $appliance; ?>_hours">Enter hours:</label>
                    <input type="number" id="<?php echo $appliance; ?>_hours" name="<?php echo $appliance; ?>_hours" min="0">
                </div>
            <?php } ?>

            <input type="submit" name="track_usage" value="Submit" class="submit-btn">
        </form>
        <?php if ($message) echo "<p class='message'>$message</p>"; ?>
    </div>

    <script>
        function toggleHoursInput(appliance) {
            var checkbox = document.querySelector("input[name='devices[]'][value='" + appliance + "']");
            var hoursInput = document.getElementById(appliance + "_hours_input");
            hoursInput.style.display = checkbox.checked ? "block" : "none";
        }
    </script>
</body>
</html>
