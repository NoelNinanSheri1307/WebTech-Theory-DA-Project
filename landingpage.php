<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Consumption Monitoring</title>
    <style>
        *
        {
            font-family:Footlight MT Light;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image:url("landingpage.jpeg");
            background-size:cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            width: 350px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        
        h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #555;
        }
        h1,p{color:black;}

        
        .btn {
            background-color:chocolate;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn:active {
            background-color: #3e8e41;
        }

       
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 2em;
            }

            p {
                font-size: 16px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

  
    <div class="container">
        <h1>Energy Consumption Monitoring</h1>
        <p>Welcome to the Energy Monitoring System. Manage and track your energy usage efficiently.</p>
        
        
        <a href="registration.php" class="btn">Register</a>
        <a href="login.php" class="btn">Login</a>
    </div>

</body>
</html>
