<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: role_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if ($new_password) {
        $update_sql = "UPDATE students SET name='$new_name', email='$new_email', password='$new_password' WHERE id=$user_id";
    } else {
        $update_sql = "UPDATE students SET name='$new_name', email='$new_email' WHERE id=$user_id";
    }

    if (mysqli_query($conn, $update_sql)) {
        $success = "Profile updated successfully.";
        $_SESSION['name'] = $new_name;
    } else {
        $error = "Error updating profile.";
    }
}

// Get current user info
$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$user_id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Dashboard</title>
  <style>
    body {
      font-family: Arial;
      background-color: #0f0f0f;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: #1e1e2f;
      padding: 20px 30px;
      border-radius: 10px;
      width: 350px;
    }
    h2 {
      text-align: center;
      color: #00ccff;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border: none;
      border-radius: 5px;
    }
    input[type="submit"] {
      background-color: #00ccff;
      color: white;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #0099cc;
    }
    .msg {
      text-align: center;
      margin: 10px 0;
      color: limegreen;
    }
    .error {
      text-align: center;
      margin: 10px 0;
      color: red;
    }
    a {
      color: #00ccff;
      text-decoration: none;
      display: block;
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<form method="POST">
  <h2>Update Your Profile</h2>
  <?php if ($success) echo "<div class='msg'>$success</div>"; ?>
  <?php if ($error) echo "<div class='error'>$error</div>"; ?>
  <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
  <input type="password" name="password" placeholder="New Password (optional)">
  <input type="submit" value="Update">
  <a href="<?= $role == 'admin' ? 'admin_dashboard.php' : ($role == 'teacher' ? 'teacher_dashboard.php' : 'student.php') ?>">Back to Dashboard</a>
</form>

</body>
</html>
