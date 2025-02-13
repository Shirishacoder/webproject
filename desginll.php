<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['designer_id'])) {
    header("Location: deginsp.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection
$servername = "localhost"; // Change if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = 'designer_portfolio'; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the designer's details from the database
$designer_id = $_SESSION['designer_id'];
$sql = "SELECT * FROM designers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $designer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the designer's details
    $designer = $result->fetch_assoc();
} else {
    echo "No designer found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        img {
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Designer Profile</h1>
    <h2><?php echo htmlspecialchars($designer['name']); ?></h2>
    <p>Email: <?php echo htmlspecialchars($designer['email']); ?></p>
    <p>Profile Details: <?php echo htmlspecialchars($designer['profile_details']); ?></p>
    
    <h3>Work Images Gallery</h3>
    <div>
        <?php
        // Assuming there's a column 'work_images' containing image paths as comma-separated values
        $images = explode(',', $designer['work_images']);
        foreach ($images as $image) {
            echo '<img src="' . htmlspecialchars($image) . '" alt="Designer Work">';
        }
        ?>
    </div>

    <a href="logout.php">Logout</a>
</body>
</html>
