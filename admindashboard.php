<?php
include('db_connection.php');
session_start();

$sql_users = "SELECT * FROM users";
$sql_students = "SELECT * FROM students_information";
$sql_advisors = "SELECT * FROM advisorship";

$result_users = $conn->query($sql_users);
$result_students = $conn->query($sql_students);
$result_advisors = $conn->query($sql_advisors);

if (isset($_GET['delete_student'])) {
    $studentIdToDelete = $_GET['delete_student'];

    $deleteSql = "DELETE FROM students_information WHERE students_information_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $studentIdToDelete);

    if ($deleteStmt->execute()) {
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "Error deleting student: " . $deleteStmt->error;
    }

    $deleteStmt->close();
}


if (isset($_GET['delete_advisor'])) {
    $advisorIdToDelete = $_GET['delete_advisor'];

    
    $deleteAdvisorSql = "DELETE FROM advisorship WHERE advisor_id = ?";
    $deleteAdvisorStmt = $conn->prepare($deleteAdvisorSql);
    $deleteAdvisorStmt->bind_param("i", $advisorIdToDelete);

    if ($deleteAdvisorStmt->execute()) {
    
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "Error deleting advisor: " . $deleteAdvisorStmt->error;
    }

    $deleteAdvisorStmt->close();
}


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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
while ($row = $result_students->fetch_assoc()) {
    $studentId = $row['students_information_id'];
    echo "<tr>
            <td>{$row['students_information_id']}</td>
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
            <td>
    <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editStudentModal{$studentId}'>Edit</button>

    <div class='modal fade' id='editStudentModal{$studentId}' tabindex='-1' role='dialog' aria-labelledby='editStudentModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='editStudentModalLabel'>Edit Student</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form action='edit_student.php' method='post'>
                        <input type='hidden' name='student_information_id' value='{$studentId}'/>

                        <div class='form-group'>
                            <label for='first_name'>First Name:</label>
                            <input type='text' id='first_name' name='first_name' class='form-control' value='{$row['first_name']}'>
                        </div>
                        <div class='form-group'>
                            <label for='last_name'>Last Name:</label>
                            <input type='text' id='last_name' name='last_name' class='form-control' value='{$row['last_name']}'>
                        </div>
                        <div class='form-group'>
                             <label for='date_of_birth'>Date Of Birth:</label>
                            <input type='text' id='date_of_birth' name='date_of_birth' class='form-control' value='{$row['date_of_birth']}'>
                        </div>
                        <div class='form-group'>
                            <label for='gender'>Gender:</label>
                            <input type='text' id='gender' name='gender' class='form-control' value='{$row['gender']}'>
                        </div>
                        <div class='form-group'>
                            <label for='email'>Email:</label>
                            <input type='text' id='email' name='email' class='form-control' value='{$row['email']}'>
                        </div>
                        <div class='form-group'>
                            <label for='address'>Address:</label>
                            <input type='text' id='address' name='address' class='form-control' value='{$row['address']}'>
                        </div>
                        <div class='form-group'>
                            <label for='assigned_advisor'>Assigned Advisor:</label>
                            <input type='text' id='assigned_advisor' name='assigned_advisor' class='form-control' value='{$row['assigned_advisor']}'>
                        </div>
                        <div class='form-group'>
                            <label for='personal_bio'>Personal Bio:</label>
                            <input type='text' id='personal_bio' name='personal_bio' class='form-control' value='{$row['personal_bio']}'>
                        </div>

                        <button type='button' class='btn btn-danger' data-dismiss='modal' onclick='confirmDeleteStudent({$studentId})'>Delete User</button>

                        
                        <div class='modal fade' id='confirmDeleteModal{$studentId}' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='confirmDeleteModalLabel'>Confirm Deletion</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        Are you sure you want to delete this user?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                                        <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type='submit' class='btn btn-primary'>Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</td>
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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAdvisorModal">
            Add Advisor
        </button>
        <div class="modal fade" id="addAdvisorModal" tabindex="-1" role="dialog" aria-labelledby="addAdvisorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAdvisorModalLabel">Add Advisor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="process_add_advisor.php" method="post">
                            <div class="form-group">
                                <label for="expertise">Expertise:</label>
                                <input type="text" class="form-control" id="expertise" name="expertise" required>
                            </div>
                            <div class="form-group">
                                <label for="availability">Availability:</label>
                                <input type="text" class="form-control" id="availability" name="availability" required>
                            </div>
                            <div class="form-group">
                                <label for="introduction">Introduction:</label>
                                <textarea class="form-control" id="introduction" name="introduction" rows="3"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="advisor_name">Advisor Name:</label>
                                <input type="text" class="form-control" id="advisor_name" name="advisor_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Advisor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Advisor ID</th>
                        <th>Expertise</th>
                        <th>Introduction</th>
                        <th>Advisor Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = $result_advisors->fetch_assoc()) {
                            $advisorId = $row['advisor_id'];
                            echo "<tr>
                                    <td>{$row['advisor_id']}</td>
                                    <td>{$row['expertise']}</td>
                                    <td>{$row['introduction']}</td>
                                    <td>{$row['advisor_name']}</td>
                                    <td>
                                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editAdvisorModal{$advisorId}'>
                                            Edit
                                        </button>
                                        <div class='modal fade' id='editAdvisorModal{$advisorId}' tabindex='-1' role='dialog' aria-labelledby='editAdvisorModalLabel{$advisorId}' aria-hidden='true'>
                                            <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='editAdvisorModalLabel{$advisorId}'>Edit Advisor</h5>
                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                            <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <form action='edit_advisor.php' method='post'>
                                                            <input type='hidden' name='advisor_id' value='{$advisorId}'>
                                                            <div class='form-group'>
                                                                <label for='expertise'>Expertise:</label>
                                                                <input type='text' id='expertise' name='expertise' class='form-control' value='{$row['expertise']}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='availability'>Availability:</label>
                                                                <input type='text' id='availability' name='availability' class='form-control' value='{$row['availability']}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='introduction'>Introduction:</label>
                                                                <textarea id='introduction' name='introduction' class='form-control' required>{$row['introduction']}</textarea>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='advisor_name'>Advisor Name:</label>
                                                                <input type='text' id='advisor_name' name='advisor_name' class='form-control' value='{$row['advisor_name']}' required>
                                                            </div>
                                                            <button type='submit' class='btn btn-primary'>Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href='admindashboard.php?delete_advisor={$row['advisor_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>

    <script>
    function confirmDeleteStudent(studentId) {
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
            window.location.href = 'admindashboard.php?delete_student=' + studentId;
        }
    }
</script>                    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>