<!DOCTYPE html>
<html>
<head>
    <title>Energy Unit Converter</title>
    <style>
        *
        {
            font-family: FootLight MT Light;
        }
        body {
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image:url("units.jpg");
        }

        .container {
            color:white;
            background-color: rgba(0,0,0, 0.5); 
            backdrop-filter: blur(10px);
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top:100px;
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        .input-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="number"], select {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #result {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Energy Unit Converter</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="inputValue">Input Value:</label>
                <input type="number" name="inputValue" id="inputValue" required>
            </div>
            <div class="input-group">
                <label for="inputUnit">Input Unit:</label>
                <select name="inputUnit" id="inputUnit">
                    <option value="joule">Joule</option>
                    <option value="kilowattHour">Kilowatt-hour</option>
                    <option value="calorie">Calorie</option>
                </select>
            </div>
            <div class="input-group">
                <label for="outputUnit">Output Unit:</label>
                <select name="outputUnit" id="outputUnit">
                    <option value="joule">Joule</option>
                    <option value="kilowattHour">Kilowatt-hour</option>
                    <option value="calorie">Calorie</option>
                </select>
            </div>
            <button type="submit" name="convert">Convert</button>
        </form>
        
        <p id="result">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['convert'])) {
                $inputValue = (float) $_POST['inputValue'];
                $inputUnit = $_POST['inputUnit'];
                $outputUnit = $_POST['outputUnit'];

               
                $joulesPerKilowattHour = 3600000;
                $caloriesPerJoule = 0.239006;
                $outputValue = $inputValue;

                
                switch ($inputUnit) {
                    case "joule":
                        if ($outputUnit === "kilowattHour") {
                            $outputValue = $inputValue / $joulesPerKilowattHour;
                        } elseif ($outputUnit === "calorie") {
                            $outputValue = $inputValue * $caloriesPerJoule;
                        }
                        break;
                    case "kilowattHour":
                        if ($outputUnit === "joule") {
                            $outputValue = $inputValue * $joulesPerKilowattHour;
                        } elseif ($outputUnit === "calorie") {
                            $outputValue = $inputValue * $joulesPerKilowattHour * $caloriesPerJoule;
                        }
                        break;
                    case "calorie":
                        if ($outputUnit === "joule") {
                            $outputValue = $inputValue / $caloriesPerJoule;
                        } elseif ($outputUnit === "kilowattHour") {
                            $outputValue = $inputValue / ($joulesPerKilowattHour * $caloriesPerJoule);
                        }
                        break;
                }

                echo "Result: " . number_format($outputValue, 2) . " " . $outputUnit;
            }
            ?>
        </p>
    </div>
</body>
</html>