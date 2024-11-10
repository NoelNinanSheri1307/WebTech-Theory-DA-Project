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


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header('Location: dash.php');
            exit();
        } else {
            echo "<p>Invalid password!</p>";
        }
    } else {
        echo "<p>No user found with this email. Please register first.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        *
        {
            font-family: Footlight MT Light;
        }
        body {
            
            background-size:cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .video-background 
        {
            object-fit: cover;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.5); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 { color: #333; }
        input { 
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover { background-color: #45a049; }
        p { margin-top: 10px; }
        a { color: #4CAF50; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <video autoplay muted loop class="video-background">
        <source src="login .mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="login" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

</body>
</html>
