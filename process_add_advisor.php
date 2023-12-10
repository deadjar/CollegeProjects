<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $expertise = $_POST['expertise'];
    $availability = $_POST['availability'];
    $introduction = $_POST['introduction'];
    $advisorName = $_POST['advisor_name'];

    
    $insertSql = "INSERT INTO advisorship (expertise, availability, introduction, advisor_name) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $expertise, $availability, $introduction, $advisorName);

    if ($stmt->execute()) {
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "Error adding advisor: " . $stmt->error;
    }

    $stmt->close();
}
?>
