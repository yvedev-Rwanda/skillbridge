<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tchat_db");
if (!$conn) die("DB Error: " . mysqli_connect_error());

function esc($c, $s) { return mysqli_real_escape_string($c, trim($s)); }

$error = "";
if (isset($_POST['login'])) {
    $username = esc($conn, $_POST['username']);
    $password = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
    if ($res && mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Tchat</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: #fff;
            padding: 30px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
            width: 90%;
            max-width: 400px;
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
        }

        .form-box button {
            width: 100%;
            padding: 12px;
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-box button:hover {
            background: #1a5cd8;
        }

        .form-box p {
            text-align: center;
            margin-top: 15px;
        }

        .form-box a {
            color: #2575fc;
            text-decoration: none;
        }

        .form-box a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Login</h2>
    <?php if ($error): ?><p class="error"><?=htmlspecialchars($error)?></p><?php endif; ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>No account? <a href="signup.php">Register here</a></p>
</div>
</body>
</html>
