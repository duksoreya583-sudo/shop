<?php
session_start();
include 'db.php';

// បើកាលណាគេបាន Login រួចហើយ មិនបាច់ឱ្យមកទំព័រនេះទៀតទេ
if (isset($_SESSION['user_id'])) {
    header("Location: shop.php");
    exit();
}

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all fields! (សូមបំពេញព័ត៌មានឱ្យគ្រប់)";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters! (លេខសម្ងាត់ត្រូវមានយ៉ាងតិច ៦ខ្ទង់)";
    } else {
        // ពិនិត្យមើលថាតើមាន Username ឬ Email នេះហើយឬនៅ
        $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($check_user) > 0) {
            $error = "Username or Email already exists! (ឈ្មោះ ឬ អ៊ីមែលនេះមានគេប្រើរួចហើយ)";
        } else {
            // ធ្វើការ Hash លេខសម្ងាត់ដើម្បីសុវត្ថិភាពខ្ពស់
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                $success = "Registration successful! You can login now. (ចុះឈ្មោះជោគជ័យ!)";
            } else {
                $error = "Something went wrong! Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ចុះឈ្មោះគណនី</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff5eb; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .auth-container { width: 100%; max-width: 400px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); }
        h2 { text-align: center; color: #ff7a00; margin-bottom: 20px; }
        label { font-weight: 600; font-size: 14px; color: #155724; }
        input { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        input:focus { border-color: #ff7a00; outline: none; }
        .btn-auth { width: 100%; background: #ff7a00; color: white; border: none; padding: 12px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-auth:hover { background: #e56d00; }
        .msg-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; text-align: center; font-size: 14px; margin-bottom: 15px; border: 1px solid #f5c6cb; }
        .msg-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; text-align: center; font-size: 14px; margin-bottom: 15px; border: 1px solid #c3e6cb; }
        p { text-align: center; font-size: 14px; margin-top: 15px; color: #666; }
        a { color: #ff7a00; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>Create Account</h2>
    
    <?php if(!empty($error)): ?>
        <div class="msg-error"><?= $error; ?></div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="msg-success"><?= $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username (ឈ្មោះអ្នកប្រើប្រាស់)</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Email Address (អ៊ីមែល)</label>
        <input type="email" name="email" placeholder="Enter email" required>

        <label>Password (លេខសម្ងាត់)</label>
        <input type="password" name="password" placeholder="Min 6 characters" required>

        <button type="submit" name="register" class="btn-auth">Register Now</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>