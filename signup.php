<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if you have a different username
$password = ""; // Change if you have a database password
$dbname = "dressable_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO design_user (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Designer registered successfully!');</script>";
        echo "<script>window.location.href = 'desgin.html';</script>"; // Redirect after successful registration
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fbc2eb, #a18cd1);
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .signup-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 380px;
        }

        .signup-box h3 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .signup-box label {
            display: block;
            text-align: left;
            margin: 15px 0 8px;
            font-weight: 600;
        }

        .signup-box input {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 7px;
            background: #f2f2f2;
            font-size: 1.1rem;
            outline: none;
        }

        .signup-box input:focus {
            background: #fff;
        }

        .btn-primary {
            background: #6c63ff;
            color: #fff;
            padding: 12px;
            width: 90%;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }
    </style>
</head>
<body>
    <div class="signup-box">
        <h3>Designer Signup</h3>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter Username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>

            <button type="submit" class="btn-primary">Register</button>
        </form>
    </div>



    </body>
</html>