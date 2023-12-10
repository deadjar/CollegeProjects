<?php
include('db_connection.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_information_id'];
    $updatedFirstName = $_POST['first_name'];
    $updatedLastName = $_POST['last_name'];
    $updatedDOB = $_POST['date_of_birth'];
    $updatedGender = $_POST['gender'];
    $updatedEmail = $_POST['email'];
    $updatedAddress = $_POST['address'];
    $updatedAssignedAdvisor = $_POST['assigned_advisor'];
    $updatedPersonalBio = $_POST['personal_bio'];

    
    $updateSql = "UPDATE students_information SET first_name = ?, last_name = ?, date_of_birth = ?, gender = ?, email = ?, address = ?, assigned_advisor = ?, personal_bio = ? WHERE students_information_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssssssi", $updatedFirstName, $updatedLastName, $updatedDOB, $updatedGender, $updatedEmail, $updatedAddress, $updatedAssignedAdvisor, $updatedPersonalBio, $studentId);


    if ($updateStmt->execute()) {
        header("Location: admindashboard.php"); 
        exit();
    } else {
        echo "Error updating student information: " . $updateStmt->error;
    }

    $updateStmt->close();
}
?>

