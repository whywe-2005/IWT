<?php
session_start();
include('db_config.php');

$error = '';
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Set your admin credentials
    $admin_user = "kabir";
    $admin_pass = "1212"; // change to a strong password

    if($username === $admin_user && $password === $admin_pass){
        $_SESSION['admin_logged_in'] = true;
        header("Location: view.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; }
        .login-box { width:300px; margin:100px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 0 10px #aaa; }
        input { width:100%; padding:10px; margin:5px 0; border-radius:5px; border:1px solid #ccc; }
        button { width:100%; padding:10px; background:gold; border:none; border-radius:5px; cursor:pointer; }
        button:hover { background:orange; }
        .error { color:red; text-align:center; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin Login</h2>
    <?php if($error){ echo "<p class='error'>$error</p>"; } ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>