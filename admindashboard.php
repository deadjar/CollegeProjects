<?php
include('db_connection.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme='dark'>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <!-- Users Information Table -->
        <h2>Users Information</h2>
        <table class="table">
            <thead>
                <tr>
                    <!-- Add table headers based on your user_information table columns -->
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display user_information data
                // Modify the SQL query based on your table structure
                $sql = "SELECT * FROM user_information";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . $row['id'] . '</th>';
                    echo '<td>' . $row['first_name'] . '</td>';
                    echo '<td>' . $row['last_name'] . '</td>';
                    // Add more columns as needed
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Users Table -->
        <h2>Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <!-- Add table headers based on your users table columns -->
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">User Type</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display users data
                // Modify the SQL query based on your table structure
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . $row['user_id'] . '</th>';
                    echo '<td>' . $row['username'] . '</td>';
                    echo '<td>' . $row['user_type'] . '</td>';
                    // Add more columns as needed
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Mentorship Table -->
        <h2>Mentorship</h2>
        <table class="table">
            <thead>
                <tr>
                    <!-- Add table headers based on your mentorship table columns -->
                    <th scope="col">#</th>
                    <th scope="col">Mentor ID</th>
                    <th scope="col">Mentee ID</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display mentorship data
                // Modify the SQL query based on your table structure
                $sql = "SELECT * FROM mentorship";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . $row['id'] . '</th>';
                    echo '<td>' . $row['mentor_id'] . '</td>';
                    echo '<td>' . $row['mentee_id'] . '</td>';
                    // Add more columns as needed
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
