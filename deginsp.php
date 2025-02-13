<?php
session_start();
if (!isset($_SESSION['designer_id'])) {
    die("Unauthorized access. Please login.");
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
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in designer's details
$designer_id = $_SESSION['designer_id'];
$sql = "SELECT * FROM designers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $designer_id);
$stmt->execute();
$result = $stmt->get_result();
$designer = $result->fetch_assoc();

// Close statement
$stmt->close();

// Fetch designer's work images
$work_images = [];
$sql = "SELECT image_path FROM work_images WHERE designer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $designer_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $work_images[] = $row['image_path'];
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
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #d3b89e, #f7ede2);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
.image-container {
    position: relative;
    display: inline-block;
    margin: 10px;
}

.image-container img {
    width: 130px;
    height: 120px;
    border-radius: 5px;
    display: block;
}

.delete-btn {
    position: absolute;
    top: 5px;
    right: 4px;
    background-color:white;
    color: white;
    border: none;
    padding: 5px;
    font-size: 8px;
    cursor: pointer;
    border-radius: 50%;
width:8%;
}

.container {
            max-width: 800px;
            margin: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
        }
        .container1 {
            max-width: 1200px;
            margin: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
        }

.container:hover {
    transform: scale(1.01);
}
header {
    width: 98.5%;
    background-color: #f8f9fa;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.header-right {
    display: flex;
    align-items: center;
}

header img {
    height: 60px;
    margin-left: 15px;
}

header h2 {
    font-size: 18px;
    margin: 0;
    color: #333;
}

.logout-btn {
    padding: 8px 15px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 10px;
    font-size: 14px;
    transition: background 0.3s ease-in-out;
}

.logout-btn:hover {
    background-color: #cc0000;
}


button {
    padding: 10px 15px;
    background: #ff7f50;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}

button:hover {
    background: #ff6347;
    transform: scale(1.05);
}

/* Profile Section */
.profile-box .poster-box {
   flex: 1;
            padding: 10px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            max-width: 600px;
            height: 500px;
            margin: 0;
}

.profile-img{
align:center;
width: 6cm;
            height: 6cm;
            border-radius: 50%;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.poster-img {
     width: 100%;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 80%;
}

.profile-img:hover, .poster-img:hover {
    transform: scale(1.1);
}

/* Work Images */
.gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.gallery img {
    width: 250px;
    height: 250px;
    margin: 10px;
    border-radius: 5px;
    object-fit: cover;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
}

.gallery img:hover {
    transform: scale(1.15);
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    padding-top: 80px;
}

.modal-content {
    background: white;
    margin: auto;
    padding: 20px;
    width: 50%;
    border-radius: 10px;
    box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
}
.profile-poster {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }


.close {
    float: right;
    font-size: 24px;
    cursor: pointer;
}

.close:hover {
    color: red;
}
 .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #333;
            margin: 0;
        }

/* Responsive */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 15px;
    }
    
    header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-img, .poster-img {
        width: 120px;
        height: 120px;
    }
    
    .modal-content {
        width: 80%;
    }
}
    </style>
</head>
<body>

<header>
        <img src="07Oct24_Anis_Free_Upload___1_-removebg-preview.png" alt="Logo">
    <div class="header-right">
        <h2>Welcome, <?php echo htmlspecialchars($designer['full_name']); ?>!</h2>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>
</header>

<div class="container">
    <div class="header">
            <h2>Designer Information</h2>
        </div>

        <!-- Profile and Poster Section -->
        <div class="profile-poster">
    <div class="profile-box">
        <h3>Profile Details</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($designer['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($designer['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($designer['phone']); ?></p>
        <p><strong>Place:</strong> <?php echo htmlspecialchars($designer['place']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($designer['address']); ?></p>
        <h3>Profile Photo</h3>
        <img src="uploads/<?php echo htmlspecialchars($designer['profile_image']); ?>" class="profile-img" alt="Profile Image" id="profileImage">
        <input type="file" accept="image/*" onchange="previewProfileImage(event)">
        <button class="edit-button" onclick="openModal()">Edit Details</button>
        </div>
        <div class="poster-box">
            <h2>Designer Poster <span class="edit-button" onclick="editPoster()"></span></h2>
            <h3>Poster Image</h3>
            <img src="uploads/<?php echo htmlspecialchars($designer['poster_image']); ?>" class="poster-img" alt="Poster Image">

            <input type="file" id="edit-poster" class="edit-fields" accept="image/*" onchange="updatePoster()">

        </div>
    </div>
</div>
<div class="container1">

    <div class="work-section">
        <h3>Work Images</h3>
        <form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="work_image" accept="image/*" required>
    <button type="submit">Upload Work Image</button>
</form>

<div class="gallery">
    <?php foreach ($work_images as $image): ?>
        <div class="image-container">
            <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Work Image">
            <button class="delete-btn" onclick="deleteImage('<?php echo htmlspecialchars($image); ?>')">❌</button>
        </div>
    <?php endforeach; ?>
</div>
    </div >
</div>

     <!-- Modal for Editing Details -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Your Details</h2>
        <form id="editForm">
            <label for="editName">Full Name:</label>
            <input type="text" id="editName" value="<?php echo htmlspecialchars($designer['full_name']); ?>" required>

            <label for="editPlace">Place:</label>
            <input type="text" id="editPlace" value="<?php echo htmlspecialchars($designer['place']); ?>" required>

            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" value="<?php echo htmlspecialchars($designer['email']); ?>" required>

            <label for="editAddress">Address:</label>
            <textarea id="editAddress" required><?php echo htmlspecialchars($designer['address']); ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

</div>
<script>
document.getElementById("uploadForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("upload_work.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            let img = document.createElement("img");
            img.src = "uploads/" + data.image_path;
            img.alt = "Work Image";
            img.classList.add("work-img");

            document.getElementById("workGallery").appendChild(img);
            alert("Image uploaded successfully!");
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
function deleteImage(imagePath) {
    if (confirm("Are you sure you want to delete this image?")) {
        fetch("delete_work.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "image_path=" + encodeURIComponent(imagePath)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("Image deleted successfully!");
                location.reload();  // Refresh the page to reflect the changes
            } else {
                alert("Error: " + data.message);
            }
        });
    }
}

    function previewProfileImage(event) {
        const image = document.getElementById('profileImage');
        image.src = URL.createObjectURL(event.target.files[0]);
    }

    function updatePoster() {
        const posterInput = document.getElementById('edit-poster');
        const posterImg = document.querySelector('.poster-img');
        posterImg.src = URL.createObjectURL(posterInput.files[0]);
    }
function openModal() {
    document.getElementById("myModal").style.display = "block";

    document.getElementById("editForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const designerId = <?php echo $designer['id']; ?>; // Get designer ID from PHP
        const updatedData = {
            id: designerId,
            full_name: document.getElementById('editName').value,
            place: document.getElementById('editPlace').value,
            email: document.getElementById('editEmail').value,
            address: document.getElementById('editAddress').value,
        };

        fetch("update_designer.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(updatedData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("Details updated successfully!");
                closeModal(); // Close modal after successful update
                location.reload(); // Reload the page to see updated details
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    });
}
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
function logout() {
    window.location.href = 'lab1.php'; // Redirects to logout page
}

       // Add AJAX functionality for adding work images and other interactions as needed
</script>
</body>
</html>
