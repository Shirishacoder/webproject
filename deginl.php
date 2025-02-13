<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Signup</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fbc2eb, #a18cd1);
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        form {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #3c6eaf;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            color: #4a70b0;
        }
        input[type="text"], input[type="email"], input[type="tel"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #5a85e8;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #3c6eaf;
        }
    </style>
</head>
<body>
    <form id="signup-form" action="" method="POST" enctype="multipart/form-data">
        <h2>Designer Portfolio</h2>
        <div class="form-group">
            <label for="designer-name">Designer Name:</label>
            <input type="text" id="designer-name" name="designer-name" required>
        </div>
        <div class="form-group">
            <label for="designer-place">Place:</label>
            <input type="text" id="designer-place" name="designer-place" required>
        </div>
        <div class="form-group">
            <label for="designer-address">Address:</label>
            <input type="text" id="designer-address" name="designer-address" required>
        </div>
        <div class="form-group">
            <label for="designer-email">Email:</label>
            <input type="email" id="designer-email" name="designer-email" required>
        </div>
        <div class="form-group">
            <label for="designer-phone">Phone Number:</label>
            <input type="tel" id="designer-phone" name="designer-phone" required>
        </div>
        <div class="form-group">
            <label for="profile-image">Upload Profile Image:</label>
            <input type="file" id="profile-image" name="profile-image" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="poster-image">Upload Poster Image:</label>
            <input type="file" id="poster-image" name="poster-image" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="work-images">Upload Work Images:</label>
            <input type="file" id="work-images" name="work-images[]" accept="image/*" multiple required>
        </div>
        <button type="submit">Submit</button>
    </form>
<script>
    document.getElementById('signup-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Collect form data
        const designerName = document.getElementById('designer-name').value;
        const designerPlace = document.getElementById('designer-place').value;
        const designerAddress = document.getElementById('designer-address').value;
        const designerEmail = document.getElementById('designer-email').value;
        const designerPhone = document.getElementById('designer-phone').value;

        // Read and encode images as Base64
        const profileImage = document.getElementById('profile-image').files[0];
        const posterImage = document.getElementById('poster-image').files[0];
        const workImages = document.getElementById('work-images').files;

        const reader = new FileReader();

        // Helper to handle multiple image uploads
        const encodeImages = (fileList, callback) => {
            let imagesEncoded = [];
            let count = 0;

            Array.from(fileList).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = () => {
                    imagesEncoded[index] = reader.result;
                    count++;
                    if (count === fileList.length) callback(imagesEncoded);
                };
                reader.readAsDataURL(file);
            });
        };

        reader.onload = () => {
            const profileImageBase64 = reader.result;
            const posterReader = new FileReader();
            posterReader.onload = () => {
                const posterImageBase64 = posterReader.result;

                encodeImages(workImages, (workImagesBase64) => {
                    // Save data to localStorage
                    localStorage.setItem('designerName', designerName);
                    localStorage.setItem('designerPlace', designerPlace);
                    localStorage.setItem('designerAddress', designerAddress);
                    localStorage.setItem('designerEmail', designerEmail);
                    localStorage.setItem('designerPhone', designerPhone);
                    localStorage.setItem('profileImage', profileImageBase64);
                    localStorage.setItem('posterImage', posterImageBase64);
                    localStorage.setItem('workImages', JSON.stringify(workImagesBase64));

                    // Redirect to deginsp.html
                    window.location.href = 'deginsp.php';
                });
            };
            posterReader.readAsDataURL(posterImage);
        };
        reader.readAsDataURL(profileImage);
    });
</script>
</body>
</html>
