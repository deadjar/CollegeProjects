<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

$userId = $_SESSION['user_id'];

function handleFileUpload($fileKey, $columnName, $fileType) {
    global $userId, $conn;

    if (isset($_FILES[$fileKey])) {
        $file = $_FILES[$fileKey];
        $originalFileName = $file['name'];
        $timestamp = time();
        $uniqueFileName = "{$userId}_{$timestamp}_{$fileType}.pdf";
        $filePath = "student_documents/{$uniqueFileName}";

        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            
            $sqlUpdate = "UPDATE student_docs SET $columnName = '$filePath' WHERE user_id = '$userId'";

            if ($conn->query($sqlUpdate)) {
                
                header("Location: profile.php");
                exit();
            } else {
                
                echo "Error updating $fileType: " . $conn->error;
            }
        } else {
            
            echo "Error uploading $fileType file.";
        }
    } else {
        
        echo "No $fileType file uploaded.";
    }
}


handleFileUpload('resume', 'student_resume', 'resume');


handleFileUpload('cover_letter', 'student_cover_letter', 'cover letter');


handleFileUpload('projects', 'student_projects', 'projects');
?>
