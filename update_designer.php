<?php
session_start();
if (!isset($_SESSION['designer_id'])) {
    die(json_encode(["status" => "error", "message" => "Unauthorized access. Please login."]));
}

// Database Configuration
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "user_management"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Get the input data
$data = json_decode(file_get_contents("php://input"), true);
$designer_id = $data['id'];
$full_name = $data['full_name'];
$place = $data['place'];
$email = $data['email'];
$address = $data['address'];

// Update designer's details in the database
$sql = "UPDATE designers SET full_name = ?, place = ?, email = ?, address = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $full_name, $place, $email, $address, $designer_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update details."]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
