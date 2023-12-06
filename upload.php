<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Display PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function handleFileUpload($fileKey, $columnName, $fileType) {
    global $userId, $conn;

    if (isset($_FILES[$fileKey])) {
        $file = $_FILES[$fileKey];
        $originalFileName = $file['name'];
        $timestamp = time();
        $uniqueFileName = "{$userId}_{$timestamp}_{$fileType}.pdf";
        $filePath = "student_documents/{$uniqueFileName}";

        echo "Debug: Original File Name: $originalFileName<br>";

        // Check for errors during file upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo "Error uploading $fileType file. Error code: " . $file['error'];
            return;
        }

        echo "Debug: Temporary File Name: {$file['tmp_name']}<br>";
        echo "Debug: Unique File Name: $uniqueFileName<br>";
        echo "Debug: File Path: $filePath<br>";

        // Check if the directory exists
        if (!is_dir('student_documents')) {
            mkdir('student_documents', 0777, true);
        }

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
