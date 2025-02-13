<?php
session_start(); // Ensure this is at the top before any HTML output

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: degin.html"); // Redirect to user dashboard
            exit();
        } else {
            echo "<script>alert('Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
    $stmt->close();
}

// Designer Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['designer_login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['designer_username']);
    $password = $_POST['designer_password'];

    $sql = "SELECT * FROM designers WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['designer_id'] = $row['id'];
            $_SESSION['designer_name'] = $row['full_name'];
            header("Location: deginsp.php"); // Redirect to designer page
            exit();
        } else {
            echo "<script>alert('Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('Designer not found!');</script>";
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
    <title>User Login</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }

        /* Body Styling with Animated Background */
        body {
            height: 100vh;
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fbc2eb, #a18cd1);
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container for Login Forms */
        .container {
            display: flex;
            gap: 60px;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Card-Like Login Box */
        .login-box {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            animation: slideUp 1s ease;
            transition: transform 0.3s ease;
        }

        .login-box:hover {
            transform: scale(1.05);
        }

        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-box h3 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Input Fields */
        .login-box label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: 600;
            color: #555;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #f2f2f2;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .login-box input:focus {
            background: #fff;
            box-shadow: 0 0 8px #6c63ff;
        }

        /* Buttons */
        .btn-primary {
            background: #6c63ff;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #564fcc;
        }

        .btn-secondary {
            display: inline-block;
            margin-top: 10px;
            color: #6c63ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .btn-secondary:hover {
            color: #564fcc;
            text-decoration: underline;
        }

        /* Forgot Password and Sign-Up Links */
        .extra-links {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .extra-links a {
            color: #6c63ff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h3>User Login</h3>
            <!-- User Login Form -->
            <form method="POST" action="">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
                <button type="submit" name="user_login" class="btn-primary">Sign In</button> <!-- Added name attribute -->
                <div class="extra-links">
                    <a href="#">Forgot Password?</a>
                    <a href="login3.php" class="btn-secondary">Sign Up</a>
                </div>
            </form>
        </div>

        <div class="login-box">
            <h3>Designer Login</h3>
            <!-- Designer Login Form -->
            <form method="POST" action="">
                <label for="designer-username">Username</label>
                <input type="text" id="designer-username" name="designer_username" placeholder="Enter Username" required>
                <label for="designer-password">Password</label>
                <input type="password" id="designer-password" name="designer_password" placeholder="Enter Password" required>
                <button type="submit" name="designer_login" class="btn-primary">Sign In</button>
                <div class="extra-links">
                    <a href="#">Forgot Password?</a>
                    <a href="desgin.php" class="btn-secondary">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

    <script>
        function redirectToSignUp() {
            window.location.href = "login3.php";
        }

        function redirectToSignUp1() {
            window.location.href = "signup.php";
        }

        function handleLogin(isDesigner) {
            // Get input values
            const username = isDesigner
                ? document.getElementById("designer-username").value
                : document.getElementById("username").value;

            const password = isDesigner
                ? document.getElementById("designer-password").value
                : document.getElementById("password").value;

            // Save username and role to localStorage
            localStorage.setItem("username", username);
            localStorage.setItem("role", isDesigner ? "Designer" : "User");

            // Redirect based on role
            if (isDesigner) {
                window.location.href = "deginsp.html"; // Redirect to designer-specific page
            } else {
                window.location.href = "degin.html"; // Redirect to user-specific page
            }

            return false; // Prevent default form submission behavior
        }
    </script>
</body>
</html>