<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $advisorId = $_POST['advisor_id'];
    $updatedExpertise = $_POST['expertise'];
    $updatedAvailability = $_POST['availability'];
    $updatedIntroduction = $_POST['introduction'];
    $updatedAdvisorName = $_POST['advisor_name'];

    $updateSql = "UPDATE advisorship SET expertise = ?, availability = ?, introduction = ?, advisor_name = ? WHERE advisor_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $updatedExpertise, $updatedAvailability, $updatedIntroduction, $updatedAdvisorName, $advisorId);

    if ($updateStmt->execute()) {
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "Error updating advisor information: " . $updateStmt->error;
    }

    $updateStmt->close();
}
?>
