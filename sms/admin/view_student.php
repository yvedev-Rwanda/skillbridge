<?php
session_start();
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $class_id = (int)$_POST["class_id"];
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $check = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO students (name, email, password, class_id, role) 
                             VALUES ('$name', '$email', '$password', $class_id, 'student')");
        $success = "Student added successfully!";
    } else {
        $error = "Email already exists!";
    }
}


$classes = mysqli_query($conn, "SELECT * FROM classes");

$students = mysqli_query($conn, "
    SELECT students.*, classes.class_name 
    FROM students 
    LEFT JOIN classes ON students.class_id = classes.id
    WHERE students.role = 'student'
    ORDER BY students.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Students</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            color: #222;
        }
        .container {
            width: 90%;
            margin: 30px auto;
        }
        h2 {
            color: #0066cc;
        }
        form {
            background: #e9f1f8;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        input, select {
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            width: 250px;
        }
        input[type="submit"] {
            width: auto;
            background-color: #0066cc;
            color: white;
            border: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #dddddd;
        }
        .success { color: green; }
        .error { color: red; }
        button{
            background:green;   
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Management</h2>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <h3>All Students</h3>
        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
            </tr>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($students)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['class_name']) ?: "Not Assigned" ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button><a href="teacher_dashboard.php">#dashboard</a></button>
    </div>
</body>
</html>
