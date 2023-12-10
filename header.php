<?php
$isLoggedIn = isset($_SESSION['user_id']);

$logoutUrl = 'logout.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body data-bs-theme='dark'>
    <div class="">
        <header class="d-flex flex-wrap align-items-left justify-content-left justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="home.php" class="d-inline-flex link-body-emphasis text-decoration-none">
                    <h3>College Projects</h3>
                </a>
            </div>
    
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="home.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="#" class="nav-link px-2">Features</a></li>
                <li><a href="#" class="nav-link px-2">Projects</a></li>
                <li><a href="#" class="nav-link px-2">About</a></li>
            </ul>
    
            <div class="col-md-3 text-end">
                <?php if ($isLoggedIn) : ?>
                    <div class="btn-group">
                        <a href='<?php echo $logoutUrl; ?>' type="button" class="btn btn-outline-primary me-2">Logout</a>
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="#">Settings</a>
                        </div>
                    </div>
                <?php else : ?>
                    <a href='login.php' type="button" class="btn btn-outline-primary me-2">Login</a>
                    <a href='register.php' type="button" class="btn btn-primary">Sign-up</a>
                <?php endif; ?>
            </div>
        </header>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
