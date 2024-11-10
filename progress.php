<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress - Energy Consumption</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <style>
        *
        {
            font-family:Footlight MT Light;
            justify-content:center;
        }
        body {
            margin: 20px;
            background-color:silver;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 250px;
            margin-bottom: 5px;
        }
        
        input[type="text"], input[type="number"] {
            padding: 5px;
            width: 300px;
            margin-bottom: 15px;
            border-radius:25px;
        }

        input[type="submit"] {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<center>
    <h2>Enter Past 5 Years Energy Consumption</h2>
    <form method="post" action="progress.php">
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required><br><br>

    
        <?php 
            for ($i = 0; $i < 5; $i++) {
                $year = date("Y") - $i;
                echo "<label for='consumption_$year'>Consumption in $year (kWh):</label>";
                echo "<input type='number' step='0.01' id='consumption_$year' name='consumption[$year]' required><br><br>";
            }
        ?>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php

    $conn = new mysqli('localhost', 'root', 'arpit', 'energy_monitoring');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $years = [];
    $consumptions = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $company_name = $_POST['company_name'];
        $consumption_data = $_POST['consumption'];


        foreach ($consumption_data as $year => $consumption) {
            $stmt = $conn->prepare("INSERT INTO past_consumption (company_name, year, consumption_kwh) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $company_name, $year, $consumption);
            $stmt->execute();
            $stmt->close();
        }

        echo "<p>Data has been recorded successfully!</p>";
    }

    $query = "SELECT year, SUM(consumption_kwh) AS total_consumption FROM past_consumption GROUP BY year ORDER BY year";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $years[] = $row['year'];
        $consumptions[] = $row['total_consumption'];
    }

    $conn->close();
    ?>

    <h2>Progress Over the Years</h2>
    <?php if (!empty($years) && !empty($consumptions)): ?>
        <canvas id="progressChart" width="400" height="200"></canvas>
        <script>
            const ctx = document.getElementById('progressChart').getContext('2d');
            const progressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($years); ?>,
                    datasets: [{
                        label: 'Energy Consumption (kWh)',
                        data: <?php echo json_encode($consumptions); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    <?php else: ?>
        <p>No data to display. Please submit the form to view the progress chart.</p>
    <?php endif; ?><center>
</body>
</html>
