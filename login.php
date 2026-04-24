<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $data = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if (mysqli_num_rows($data) > 0) {
        $_SESSION['login'] = true;
        header("Location: index.php");
    } else {
        echo "<script>alert('Login gagal');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login PetCare</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Card login */
.login-card {
    width: 350px;
    padding: 30px;
    border-radius: 20px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    color: white;
    animation: fadeIn 0.6s ease-in-out;
}

/* Input */
.form-control {
    border-radius: 10px;
    border: none;
}

/* Button */
.btn-login {
    border-radius: 10px;
    background: #4f46e5;
    border: none;
    transition: 0.3s;
}

.btn-login:hover {
    background: #3730a3;
}

/* Icon input */
.input-group-text {
    border-radius: 10px 0 0 10px;
    background: white;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px);}
    to { opacity: 1; transform: translateY(0);}
}
</style>

</head>

<body>

<div class="login-card">

    <h3 class="text-center mb-3">🐾 PetCare</h3>
    <p class="text-center mb-4">Silakan login ke sistem</p>

    <form method="POST">

        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button name="login" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </button>

    </form>

</div>

</body>
</html>