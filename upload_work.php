<?php
session_start();
if (!isset($_SESSION['designer_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit;
}

$designer_id = $_SESSION['designer_id'];

$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (!empty($_FILES["work_image"]["name"])) {
    $fileName = basename($_FILES["work_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allowed file types
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES["work_image"]["tmp_name"], $targetFilePath)) {
            // Database connection
            $conn = new mysqli("localhost", "root", "", "user_management");
            if ($conn->connect_error) {
                die(json_encode(["status" => "error", "message" => "Database connection failed"]));
            }

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO work_images (designer_id, image_path) VALUES (?, ?)");
            $stmt->bind_param("is", $designer_id, $fileName);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "image_path" => $fileName]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database insertion failed"]);
            }
            $stmt->close();
            $conn->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Image upload failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid file format"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No file uploaded"]);
}
?>
