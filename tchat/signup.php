<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tchat_db");
if (!$conn) die("DB Error: " . mysqli_connect_error());

function esc($c, $s) { return mysqli_real_escape_string($c, trim($s)); }

$error = "";
if (isset($_POST['register'])) {
    $username = esc($conn, $_POST['username']);
    $password = $_POST['password'];
    $location=$_POST['location'];
    $age=$_POST['age'];

    if (strlen($username) < 3 || strlen($password) < 4) {
        $error = "Username must be at least 3 chars, password at least 4 chars.";
    } else {
        $exists = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
        if (mysqli_num_rows($exists) > 0) {
            $error = "Username already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$hash')");
            if ($insert) {
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['username'] = $username;
                header("Location: login.php");
                exit;
            } else {
                $error = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Tchat App</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #2c3e50, #3498db);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .register-container {
      background: #ffffffdd;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input[type="text"],
    input[type="password"] {
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      transition: border 0.2s ease-in-out;
    }

    input:focus {
      outline: none;
      border-color: #3498db;
      box-shadow: 0 0 5px #3498db55;
    }

    button {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    button:hover {
      background-color: #2980b9;
    }

    p {
      text-align: center;
    }

    a {
      color: #2980b9;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .error {
      color: #e74c3c;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Create an Account</h2>
    <?php if ($error): ?><p class="error"><?=htmlspecialchars($error)?></p><?php endif; ?>
    <form method="post" action="">
      <input type="text" name="username" placeholder="Username" required minlength="3">
      <input type="password" name="password" placeholder="Password" required minlength="4">
      <input type="text" name="location" placeholder="Location" required minlength="4">
      <input type="text " name="age" placeholder="Age" required minlength="2">
      <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>
