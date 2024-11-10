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

$registration_message = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $registration_message = "<p><center>Username must contain only alphabets.</center></p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registration_message = "<p><center>Invalid email format.</center></p>";
    } else {
        $check_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $registration_message = "<p><center>Username or email already exists. Please choose another.</center></p>";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if ($conn->query($sql) === TRUE) {
                $registration_message = "<p><center>Registration successful! You can now <a href='login.php'>login</a>.</center></p>";
            } else {
                $registration_message = "<p>Error: " . $conn->error . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            font-family: Footlight MT Light;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: url("registrationlogin.jpeg");
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
        .message {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Register</h2>
        <form method="POST" action="registration.php">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="register" value="Register">
        </form>
    </div>

    <?php if (!empty($registration_message)) { ?>
        <div class="message"><?php echo $registration_message; ?></div>
    <?php } ?>

</body>
</html>
