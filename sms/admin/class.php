    <?php
session_start();
include "db.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
$role = $_SESSION['role'];
$user_name = $_SESSION['name'];

if ($role === "admin" && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['class_name'])) {
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);

    $check = mysqli_query($conn, "SELECT * FROM classes WHERE class_name = '$class_name'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO classes (class_name) VALUES ('$class_name')");
        $success = "Class added successfully!";
    } else {
        $error = "Class already exists!";
    }
}

$classes = mysqli_query($conn, "SELECT * FROM classes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classes</title>
    <style>
        body {
            background-color: #101010;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 50px auto;
        }
        h1 {
            color: #00ccff;
        }
        .form-box {
            margin-bottom: 20px;
            background: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
        }
        input[type="text"] {
            padding: 8px;
            width: 250px;
            border-radius: 4px;
            border: none;
        }
        input[type="submit"] {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            margin-left: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        table {
            width: 100%;
            background-color: #1f1f1f;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background-color: #444;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Classes List</h1>
    <p>Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong> (<?php echo $role; ?>)</p>

    <?php if ($role === "admin"): ?>
        <div class="form-box">
            <form method="POST" action="">
                <label>Add New Class:</label>
                <input type="text" name="class_name" required>
                <input type="submit" value="Add">
            </form>
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </div>
    <?php endif; ?>

    <table>
        <tr>
            <th>#</th>
            <th>Class Name</th>
        </tr>
        <?php $count = 1; while ($row = mysqli_fetch_assoc($classes)): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo htmlspecialchars($row['class_name']); ?></td>
            </tr>
        <?php endwhile; ?>
       
    </table>
    <button><a href="admin_dashboard.php">back</a></button>
</div>
</body>
</html>
