<?php
// ১. পাথ ঠিক করা হয়েছে (Relative path ব্যবহার করা হয়েছে)
require_once __DIR__ . '/../includes/config.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// ২. যদি আগে থেকেই লগইন করা থাকে তবে সরাসরি ড্যাশবোর্ডে পাঠাবে
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true){
    // এখানে /travel-blog/ বাদ দিয়ে সরাসরি dashboard.php দেওয়া হয়েছে
    header("Location: dashboard.php");
    exit;
}

$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // অ্যাডমিন ক্রেডেনশিয়াল (আপনার প্রয়োজন মতো পরিবর্তন করতে পারেন)
    $admin_username = 'admin';
    $admin_password = 'password123'; 

    if($username === $admin_username && $password === $admin_password){
        $_SESSION['admin_logged_in'] = true;
        
        // ৩. সাকসেসফুল লগইন হলে রিডাইরেক্ট পাথ ঠিক করা হয়েছে
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}

// লগআউট মেসেজ দেখানো
if(isset($_GET['logout']) && $_GET['logout'] == 1){
    $message = "You have successfully logged out.";
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login - Travel Memories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Admin Login</h2>

                    <?php if($message): ?>
                    <div class="alert alert-info py-2 text-center"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="../index.php" class="text-decoration-none text-muted">← Back to Home</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>