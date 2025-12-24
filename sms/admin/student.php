<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo "Please login as a student to access this page.";
    exit();
}


$conn = mysqli_connect("localhost", "root", "", "student");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$user_id = $_SESSION['user_id'];
$query = "SELECT name, email FROM students WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f2f2f2;
        }
        h2 {
            color: #333;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        a.button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            margin-top: 10px;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h2>

<div class="card">
    <h3>Your Information</h3>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
</div>

<div class="card">
    <h3>What would you like to do?</h3>
    <ul>
        <li><a class="button" href="view_results.php">View My Results</a></li>
        <li><a class="button" href="my_messages.php">View Messages</a></li>
        <li><a class="button" href="update_profile.php">Update Profile</a></li>
        <li><a class="button" href="logout.php">Logout</a></li>
    </ul>
</div>

</body>
</html>
