<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Basic client-side validation (you can enhance this with more checks)
    if (empty($username) || empty($password) || empty($firstName) || empty($lastName) || empty($dob) || empty($gender) || empty($email) || empty($address)) {
        echo "Please fill in all required fields.";
    } else {
        // Check if the username already exists
        $checkSql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            echo "Username '$username' is already taken. Please choose another username.";
        } else {
            // Hash the password before storing it in the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Handle profile picture upload and get the file name
            $profilePictureName = uploadProfilePicture();

            // Use prepared statement to prevent SQL injection
            $insertUserSql = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
            $stmt = $conn->prepare($insertUserSql);
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                // Get the user_id of the newly inserted user
                $userId = $stmt->insert_id;

                // Insert additional details into students_information table
                $insertDetailsSql = "INSERT INTO students_information (user_id, first_name, last_name, date_of_birth, gender, email, address, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertDetailsSql);
                $stmt->bind_param("isssssss", $userId, $firstName, $lastName, $dob, $gender, $email, $address, $profilePictureName);

                if ($stmt->execute()) {
                    echo "Registration successful! You can now <a href='home.php'>login</a>.";
                    // Redirect to login page after a few seconds
                    header("refresh:5;url=home.php");
                } else {
                    echo "Error during registration.";
                }
            } else {
                echo "Error during registration.";
            }

            $stmt->close();
        }
    }
}

function uploadProfilePicture() {
    $targetDirectory = "profile_pictures/";
    $targetFile = $targetDirectory . basename($_FILES["profile_picture"]["name"]);

    // Check if a file was uploaded successfully
    if ($_FILES["profile_picture"]["error"] != UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        exit();
    }

    // Validate file type and size
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    $maxFileSize = 5 * 1024 * 1024;  // 5 MB

    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
        exit();
    }

    if ($_FILES["profile_picture"]["size"] > $maxFileSize) {
        echo "File size exceeds the limit (5 MB).";
        exit();
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
        return basename($_FILES["profile_picture"]["name"]);
    } else {
        echo "Error uploading file.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href="/bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css">
    <title>Register</title>
</head>
<body class="bg-dark text-light">
<?php include('header.php'); ?>
<div class="register-form container-md">
    <div class="register-form container-md">
        <h2 class="mb-4">Register</h2>
        <form class='row g-3' action="" method="post" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control bg-dark text-light" required>
            </div>
            <div class="col-md-6">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control bg-dark text-light" required>
            </div>
            <div class="col-6">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control bg-dark text-light" required>
            </div>
            <div class="col-6">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control bg-dark text-light" required>
            </div>
            <div class="col-6">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" class="form-control bg-dark text-light" required>
            </div>
            <div class="col-md-6">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" class="form-control bg-dark text-light" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control bg-dark text-light" required>
            </div>
            <div class="form-group col-md-6">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control bg-dark text-light" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" class="form-control-file bg-dark text-light" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Simple JavaScript for client-side validation -->
<script>
    document.querySelector('form').onsubmit = function() {
        var password = document.getElementById('password').value;
        var confirm_password = document.getElementById('confirm_password').value;

        if (password !== confirm_password) {
            alert('Passwords do not match. Please confirm your password.');
            return false;
        }
    };
</script>

</body>
</html>