<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Energy Conservation Tips</title>
    <style>
        *
        {
            font-family:Footlight MT Light;
        }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            color: #fff;
            overflow: hidden;
        }
        .video-background {
            object-fit: cover;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            top: 50%;
            transform: translateY(-50%);
        }
        h1 {
            color: #2ec4b6;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.1em;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button-home {
            background-color: #3498db;
        }
        .button-home:hover {
            background-color: #2980b9;
        }
        .button-company {
            background-color: #27ae60;
        }
        .button-company:hover {
            background-color: #1e8449;
        }
    </style>
</head>
<body>
   
    <video autoplay muted loop class="video-background">
        <source src="n.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

  
    <div class="container">
        <h1>Select Your Preference</h1>
        <p>Choose which set of energy conservation tips you would like to view:</p>
        <div class="button-container">
            <a href="home_energy_tips.php" class="button button-home">Home Usage Tips</a>
            <a href="company_energy_tips.php" class="button button-company">Company Consumption Tips</a>
        </div>
    </div>
</body>
</html>
