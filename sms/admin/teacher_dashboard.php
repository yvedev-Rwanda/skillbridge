<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: white;
        }
        .container {
            padding: 30px;
        }
        .card {
            background-color: #1f1f1f;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border: 1px solid #333;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?> (Teacher)</h1>
    </div>

    <div class="container">
        <div class="card">
            <h2>Your Responsibilities</h2>
            <ul>
                <li>View assigned class and students</li>
                <li> Mark student attendance</li>
                <li> Input student grades/results</li>
                <li> View subjects assigned</li>
                <li> Send messages or feedback</li>
                <li> Update profile/password</li>
            </ul>
        </div>

        <div class="card">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="view_student.php" style="color: #4db8ff;">View Students</a></li>
                <li><a href="mark_attendance.php" style="color: #4db8ff;">Mark Attendance</a></li>
                <li><a href="enter_results.php" style="color: #4db8ff;">Enter Results</a></li>
                <li><a href="assigned_classes.php" style="color: #4db8ff;">View Assigned Classes</a></li>
                <li><a href="send_message.php" style="color: #4db8ff;">Send Message</a></li>
                <li><a href="update_profile.php" style="color: #4db8ff;">Update Profile</a></li>
            </ul>
        </div>

        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
