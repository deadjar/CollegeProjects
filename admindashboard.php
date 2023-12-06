<?php
include('db_connection.php');
session_start();

$sql_users = "SELECT * FROM users";
$sql_students = "SELECT * FROM students_information";
$sql_advisors = "SELECT * FROM advisorship";

$result_users = $conn->query($sql_users);
$result_students = $conn->query($sql_students);
$result_advisors = $conn->query($sql_advisors);
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
    <div class="row">
        <div class="col-md-13">
            <h3>Student Information</h3>
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Profile Picture</th>
                            <th>Assigned Advisor</th>
                            <th>Personal Bio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result_students->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['first_name']}</td>
                                    <td>{$row['last_name']}</td>
                                    <td>{$row['date_of_birth']}</td>
                                    <td>{$row['gender']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['address']}</td>
                                    <td>{$row['profile_picture']}</td>
                                    <td>{$row['assigned_advisor']}</td>
                                    <td>{$row['personal_bio']}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>                
        <div class="col-md-9">
            <h3>Advisorship</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Advisor ID</th>
                            <th>Expertise</th>
                            <th>Introduction</th>
                            <th>Advisor Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result_advisors->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['advisor_id']}</td>
                                    <td>{$row['expertise']}</td>
                                    <td>{$row['introduction']}</td>
                                    <td>{$row['advisor_name']}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
