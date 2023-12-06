<?php
include('db_connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password_hash'];

        // Verify the hashed password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $row['user_id'];  // Set user_id in the session

            if ($row['user_type'] == 'admin') {
                // Redirect admin users to the admin dashboard
                header("Location: admindashboard.php");
            } else {
                // Redirect non-admin users to the profile page
                header("Location: profile.php");
            }

            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    } else {
        $loginError = "Invalid username or password.";
    }
}

// Move the header outside the condition
if (isset($loginError)) {
    echo "<p class='error'>$loginError</p>";
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme='dark'>
<head>
    <link rel="stylesheet" href="/CollegeProjects/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel='stylesheet' href="/bootstrap-5.3.2-dist/css/bootstrap.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body class="bg-dark text-light">
<?php include('header.php'); ?>
    <div class="login-container">
    <div class="login-form">
        <h2 class="mb-4">Login</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control bg-dark text-light" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control bg-dark text-light" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="mt-3 text-center">
            <p>Don't have an account? <a href='register.php'>Register</a></p>
        </div>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
