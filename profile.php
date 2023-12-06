    <?php
    include('db_connection.php');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: home.php");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $sqlUserInfo = "SELECT * FROM students_information WHERE user_id = '$userId'";
    $resultUserInfo = $conn->query($sqlUserInfo);
    $userInfo = $resultUserInfo->fetch_assoc();

    $sqlAdvisor = "SELECT a.advisor_name 
                FROM advisorship a
                JOIN students_information s ON a.advisor_id = s.assigned_advisor
                WHERE s.user_id = '$userId'";

    $resultAdvisor = $conn->query($sqlAdvisor);

    if ($resultAdvisor) {
        $advisor = $resultAdvisor->fetch_assoc();
    } else {
        echo "Error: " . $conn->error;
    }

    $sqlDocuments = "SELECT * FROM student_docs WHERE user_id = '$userId'";
    $resultDocuments = $conn->query($sqlDocuments);

    if ($resultDocuments) {
        $documents = $resultDocuments->fetch_assoc();
    } else {
        echo "Error fetching documents: " . $conn->error;
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
        <title>User Profile</title>
        <style>
            .profile-picture {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 50%;
            }
        </style>
    </head>

    <body>
        <?php include('header.php'); ?>
        <div class="container mt-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3 text-center">
                    <img src="profile_pictures/<?php echo $userInfo['profile_picture']; ?>" alt="Profile Picture"
                        class="img-fluid rounded profile-picture">
                </div>
                <div class="col-md-7">
                    <h2 class="mb-4">User Profile</h2>
                    <div class="row">
                        <div class="col-md-5">
                            <p><strong>First Name:</strong>
                                <?php echo $userInfo['first_name']; ?>
                            </p>
                            <p><strong>Last Name:</strong>
                                <?php echo $userInfo['last_name']; ?>
                            </p>
                            <p><strong>Date of Birth:</strong>
                                <?php echo $userInfo['date_of_birth']; ?>
                            </p>
                            <p><strong>Gender:</strong>
                                <?php echo $userInfo['gender']; ?>
                            </p>
                            <p><strong>Personal Bio:</strong><br>
                                <?php echo $userInfo['personal_bio']; ?>
                            </p>
                        </div>
                        <div class="col-md-7">
                            <p><strong>Email:</strong>
                                <?php echo $userInfo['email']; ?>
                            </p>
                            <p><strong>Address:</strong>
                                <?php echo $userInfo['address']; ?>
                            </p>
                            <?php if ($advisor) : ?>
                            <p><strong>Assigned Advisor:</strong>
                                <?php echo $advisor['advisor_name']; ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container grid">
            <div class="row justify-content-center">
                <div class="card col-md-6 mb-4 p-2 mr-2" style="width: 18rem;">
                    <h5>Resume</h5>
                    <?php if ($documents['student_resume']): ?>
                    <iframe src="<?php echo $documents['student_resume']; ?>"
                        title="student_resume"></iframe>
                    <?php else: ?>
                    <p>No resume uploaded.</p>
                    <?php endif; ?>
                </div>
                <div class="card col-md-6 mb-4 p-2 mr-2" style="width: 18rem;">
                    <h5>Cover Letter</h5>
                    <?php if ($documents['student_cover_letter']): ?>
                    <iframe src="<?php echo $documents['student_cover_letter']; ?>"
                        title="student_cover_letter"></iframe>
                    <?php else: ?>
                    <p>No cover letter uploaded.</p>
                    <?php endif; ?>
                </div>
                <div class="card col-md-6 mb-4 p-2 mr-2" style="width: 18rem;">
                    <h5>Projects</h5>
                    <?php if ($documents['student_projects']): ?>
                    <iframe src="<?php echo $documents['student_projects']; ?>"
                        title="student_projects"></iframe>
                    <?php else: ?>
                    <p>No projects uploaded.</p>
                    <?php endif; ?>
                </div>
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="resume" class="form-label">Resume:</label>
                    <input type="file" class="form-control" name="resume" id="resume">
                </div>
                <div class="mb-3">
                    <label for="cover_letter" class="form-label">Cover Letter:</label>
                    <input type="file" class="form-control" name="cover_letter" id="cover_letter">
                </div>
                <div class="mb-3">
                    <label for="projects" class="form-label">Projects:</label>
                    <input type="file" class="form-control" name="projects" id="projects">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>