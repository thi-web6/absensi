<?php
session_start();
include 'config.php';

// Jika form login disubmit
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Periksa username dan password di database
    $sql = "SELECT id FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, md5($password)); // Menggunakan MD5 untuk hash password
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: admin.php'); // Redirect ke admin.php setelah login berhasil
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

// Jika pengguna sudah login, redirect ke admin.php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }

        .login-container h1 {
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
            width: 100%;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            background: #f7f7f7;
            border: none;
            border-radius: 5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        .input-group label {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 16px;
            color: #666;
            pointer-events: none;
            transition: 0.3s;
        }

        .input-group input:focus,
        .input-group input:valid {
            background: #e7e7e7;
        }

        .input-group input:focus + label,
        .input-group input:valid + label {
            top: -20px;
            left: 10px;
            font-size: 14px;
            color: #6e8efb;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background: #6e8efb;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        input[type="submit"]:hover {
            background: #5a79da;
            transform: scale(1.05);
        }

        input[type="submit"]:active {
            background: #4a68c8;
            transform: scale(1);
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
            color: #888;
        }

        .message a {
            color: #6e8efb;
            text-decoration: none;
            font-weight: bold;
        }

        .message a:hover {
            text-decoration: underline;
        }

        .links {
            margin-top: 20px;
            font-size: 14px;
        }

        .links a {
            color: #6e8efb;
            text-decoration: none;
            transition: 0.3s;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" name="login" value="Login">
        </form>
        <div class="message">
            
        </div>
    </div>
</body>
</html>
