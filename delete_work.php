<?php
session_start();
if (!isset($_SESSION['designer_id'])) {
    die(json_encode(["status" => "error", "message" => "Unauthorized access."]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image_path'])) {
    $designer_id = $_SESSION['designer_id'];
    $image_path = $_POST['image_path'];

    $conn = new mysqli("localhost", "root", "", "user_management");
    if ($conn->connect_error) {
        die(json_encode(["status" => "error", "message" => "Database connection failed."]));
    }

    // Check if the image belongs to the logged-in user
    $stmt = $conn->prepare("SELECT id FROM work_images WHERE designer_id = ? AND image_path = ?");
    $stmt->bind_param("is", $designer_id, $image_path);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die(json_encode(["status" => "error", "message" => "Image not found or unauthorized deletion."]));
    }

    // Delete image from database
    $stmt = $conn->prepare("DELETE FROM work_images WHERE designer_id = ? AND image_path = ?");
    $stmt->bind_param("is", $designer_id, $image_path);
    $stmt->execute();
    
    // Delete image from server
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    echo json_encode(["status" => "success", "message" => "Image deleted successfully."]);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
