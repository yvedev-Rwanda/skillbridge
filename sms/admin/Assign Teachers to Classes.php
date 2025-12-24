<?php
$conn = mysqli_connect("localhost", "root", "", "student");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['assign_teacher'])) {
    $class_id = intval($_POST['class_id']);
    $teacher_id = intval($_POST['teacher_id']);

    $check = mysqli_query($conn, "SELECT * FROM teacher_assignments WHERE class_id = $class_id AND teacher_id = $teacher_id");
    if (mysqli_num_rows($check) == 0) {
        $insert = "INSERT INTO teacher_assignments (class_id, teacher_id) VALUES ($class_id, $teacher_id)";
        mysqli_query($conn, $insert);
    }
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM teacher_assignments WHERE id = $id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Teachers to Classes</title>
</head>
<body>
    <h2>Assign Teachers to Classes</h2>

    <form method="POST" action="">
        <select name="class_id" required>
            <option value="">Select Class</option>
            <?php
            $classes = mysqli_query($conn, "SELECT * FROM classes ORDER BY class_name ASC");
            while ($class = mysqli_fetch_assoc($classes)) {
                echo "<option value='{$class['id']}'>" . htmlspecialchars($class['class_name']) . "</option>";
            }
            ?>
        </select>

        <select name="teacher_id" required>
            <option value="">Select Teacher</option>
            <?php
            $teachers = mysqli_query($conn, "SELECT * FROM teachers ORDER BY name ASC");
            while ($teacher = mysqli_fetch_assoc($teachers)) {
                echo "<option value='{$teacher['id']}'>" . htmlspecialchars($teacher['name']) . "</option>";
            }
            ?>
        </select>

        <button type="submit" name="assign_teacher">Assign</button>
    </form>

    <h3>Current Assignments</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Class</th>
            <th>Teacher</th>
            <th>Action</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT ta.id, c.class_name, t.name FROM teacher_assignments ta 
            JOIN classes c ON ta.class_id = c.id 
            JOIN teachers t ON ta.teacher_id = t.id ORDER BY ta.id ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['class_name']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td><a href='?delete={$row['id']}' onclick='return confirm(\"Delete this assignment?\")'>Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
