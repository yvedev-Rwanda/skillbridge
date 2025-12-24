<?php
include "db.php";
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #111;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            padding-top: 40px;
        }
        h1 {
            color: #00ccff;
            margin-bottom: 20px;
        }
        .card {
            background-color: #222;
            padding: 20px;
            margin: 10px 0;
            border-left: 5px solid #00ccff;
            border-radius: 8px;
        }
        a {
            color: #00ccff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout {
            margin-top: 30px;
        }
        .logout a {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?> (Admin)</h1>

        <div class="card">
            <h3><a href="class.php">Manage Classes</a></h3>
            <p>Create, view or edit school classes.</p>
        </div>

        <div class="card">
            <h3><a href="class_arms.php">Manage Class Arms</a></h3>
            <p>Create arms like Class A, Class B, etc.</p>
        </div>

        <div class="card">
            <h3><a href="Assign_teacher.php">Assign Teachers to Classes</a></h3>
            <p>Assign specific class and arm to a teacher.</p>
        </div>

        <div class="card">
            <h3><a href="manage_teacher.php">Manage Teachers</a></h3>
            <p>Add or remove teacher accounts.</p>
        </div>

        <div class="card">
            <h3><a href="manage_student.php">Manage Students</a></h3>
            <p>Register students and assign them to class arms.</p>
        </div>

        <div class="card">
            <h3><a href="term.php">Manage Terms</a></h3>
            <p>Create school terms, activate/deactivate current term.</p>
        </div>

        <div class="card logout">
            <h3><a href="logout.php">Logout</a></h3>
        </div>
    </div>
</body>
</html>
