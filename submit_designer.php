<?php
// Database Configuration
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = "user_management"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing
    $full_name = mysqli_real_escape_string($conn, $_POST['designer-name']); // Updated field name
    $place = mysqli_real_escape_string($conn, $_POST['designer-place']);
    $address = mysqli_real_escape_string($conn, $_POST['designer-address']);
    $email = mysqli_real_escape_string($conn, $_POST['designer-email']);
    $phone = mysqli_real_escape_string($conn, $_POST['designer-phone']);

    // File Upload Handling
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Initialize variables for uploaded images
    $profile_image = $_FILES['profile-image']['name'];
    $poster_image = $_FILES['poster-image']['name'];
    
    // Initialize an array for work images
    $work_images = [];
    $work_image_count = count($_FILES['work-images']['name']); // Count work images

    // Move uploaded files
    if (move_uploaded_file($_FILES["profile-image"]["tmp_name"], $target_dir . basename($profile_image)) &&
        move_uploaded_file($_FILES["poster-image"]["tmp_name"], $target_dir . basename($poster_image))) {

        // Move work images
        for ($i = 0; $i < $work_image_count; $i++) {
            $work_image_name = $_FILES['work-images']['name'][$i];
            if (move_uploaded_file($_FILES["work-images"]["tmp_name"][$i], $target_dir . basename($work_image_name))) {
                $work_images[] = $work_image_name; // Store the uploaded work image names
            }
        }

        // Insert into database using prepared statements
        $sql = "INSERT INTO designers (username, password, full_name, place, address, email, phone, profile_image, poster_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $username, $password, $full_name, $place, $address, $email, $phone, $profile_image, $poster_image);

        if ($stmt->execute()) {
            $designer_id = $stmt->insert_id; // Get the last inserted designer ID
            $stmt->close();

            // Insert work images into work_images table
            foreach ($work_images as $image) {
                $sql_work_images = "INSERT INTO work_images (designer_id, image_path) VALUES (?, ?)";
                $stmt_work = $conn->prepare($sql_work_images);
                $stmt_work->bind_param("is", $designer_id, $image);
                $stmt_work->execute();
                $stmt_work->close();
            }

            $conn->close();
            header("Location: logo4.php"); // Redirect to login page after signup
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "File upload failed!";
    }
}
?>