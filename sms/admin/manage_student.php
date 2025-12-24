<?php
$conn = mysqli_connect("localhost", "root", "", "student");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_student'])) {
    $name = trim($_POST['name']);
    $class_arm_id = intval($_POST['class_arm_id']);

    if (!empty($name) && $class_arm_id > 0) {
        $name = mysqli_real_escape_string($conn, $name);

        $sql = "INSERT INTO students (name, class_arm_id) VALUES ('$name', $class_arm_id)";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Error adding student: " . mysqli_error($conn));
        }
    } else {
        echo "<p style='color:red;'>Please enter a valid name and select a class arm.</p>";
    }
}

// Delete student
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $sql = "DELETE FROM students WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error deleting student: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h2, h3 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"], select {
            padding: 8px; width: 200px; font-size: 16px; margin-right: 10px;
        }
        button {
            padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        table {
            border-collapse: collapse; width: 100%; background: white;
        }
        th, td {
            border: 1px solid #ccc; padding: 10px; text-align: left;
        }
        th { background: #333; color: white; }
        a { color: red; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>Manage Students</h2>

<form method="POST" action="">
    <input type="text" name="name" placeholder="Student Name" required>
    <select name="class_arm_id" required>
        <option value="">Select Class Arm</option>
        <?php
        // Get class arms for dropdown
        $arms = mysqli_query($conn, "SELECT id, name FROM class_arms ORDER BY name ASC");
        if ($arms) {
            while ($arm = mysqli_fetch_assoc($arms)) {
                echo "<option value='{$arm['id']}'>" . htmlspecialchars($arm['name']) . "</option>";
            }
        } else {
            echo "<option value=''>No class arms found</option>";
        }
        ?>
    </select>
    <button type="submit" name="add_student">Add Student</button>
</form>

<h3>Students List</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Class Arm</th>
        <th>Action</th>
    </tr>
    <?php
    // Select students with their class arm names
    $sql = "SELECT s.id, s.name, ca.name AS class_arm FROM students s
            LEFT JOIN class_arms ca ON s.class_arm_id = ca.id
            ORDER BY s.id ASC";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($student = mysqli_fetch_assoc($result)) {
            $id = $student['id'];
            $name = htmlspecialchars($student['name']);
            $classArm = htmlspecialchars($student['class_arm'] ?? 'N/A');
            echo "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$classArm</td>
                    <td><a href='?delete=$id' onclick='return confirm(\"Delete this student?\")'>Delete</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Error loading students: " . mysqli_error($conn) . "</td></tr>";
    }
    ?>
</table>
    <button><a href="admin_dashboard.php">BACK</a></button>
</body>
</html>
