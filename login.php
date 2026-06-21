<?php
session_start();
include 'db.php';



$error = "";

if (isset($_POST['login'])) {
    $username_email = mysqli_real_escape_string($conn, trim($_POST['username_email']));
    $password       = trim($_POST['password']);

    if (empty($username_email) || empty($password)) {
        $error = "Please fill in all fields!";
    } else {
        // អនុញ្ញាតឱ្យអ្នកប្រើប្រាស់ចូលគណនីតាមរយៈ Username ក៏បាន ឬ Email ក៏បាន
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'");
        
        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);
            
            // ផ្ទៀងផ្ទាត់លេខសម្ងាត់ដែលបានបំប្លែង (Hashed Password)
            if (password_verify($password, $user['password'])) {
                // បង្កើត Session ទុកសម្គាល់ថាបាន Login រួចរាល់
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password! (លេខសម្ងាត់មិនត្រឹមត្រូវទេ)";
            }
        } else {
            $error = "Account not found! (មិនមានគណនីនេះទេ)";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ចូលប្រើប្រាស់</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff5eb; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .auth-container { width: 100%; max-width: 400px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); }
        h2 { text-align: center; color: #ff7a00; margin-bottom: 20px; }
        label { font-weight: 600; font-size: 14px; color: #555; }
        input { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        input:focus { border-color: #ff7a00; outline: none; }
        .btn-auth { width: 100%; background: #ff7a00; color: white; border: none; padding: 12px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-auth:hover { background: #e56d00; }
        .msg-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; text-align: center; font-size: 14px; margin-bottom: 15px; border: 1px solid #f5c6cb; }
        p { text-align: center; font-size: 14px; margin-top: 15px; color: #666; }
        a { color: #ff7a00; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>Login to Store</h2>
    
    <?php if(!empty($error)): ?>
        <div class="msg-error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username or Email</label>
        <input type="text" name="username_email" placeholder="Enter username or email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit" name="login" class="btn-auth">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>