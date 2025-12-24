<?php
$conn = mysqli_connect("localhost", "root", "", "student");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$today = date('Y-m-d');


$class_arm_id = isset($_GET['class_arm_id']) ? intval($_GET['class_arm_id']) : 1;

if (isset($_POST['submit_attendance'])) {
    $statuses = $_POST['status']; 

    foreach ($statuses as $student_id => $status) {
        $student_id = intval($student_id);
        $status = mysqli_real_escape_string($conn, $status);

      
        $check = mysqli_query($conn, "SELECT * FROM attendance WHERE student_id=$student_id AND date='$today'");
        if (mysqli_num_rows($check) > 0) {
          
            mysqli_query($conn, "UPDATE attendance SET status='$status' WHERE student_id=$student_id AND date='$today'");
        } else {
        
            mysqli_query($conn, "INSERT INTO attendance (student_id, date, status) VALUES ($student_id, '$today', '$status')");
        }
    }
    echo "<p style='color:green;'>Attendance recorded successfully for $today.</p>";
}


$students_result = mysqli_query($conn, "SELECT id, name FROM students WHERE class_arm_id = $class_arm_id ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f0f2f5; }
        h2 { color: #333; }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        select {
            padding: 6px;
            font-size: 14px;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<h2>Mark Attendance for Class Arm ID: <?php echo $class_arm_id; ?> (Date: <?php echo $today; ?>)</h2>

<form method="POST" action="">
    <table>
        <tr>
            <th>Student Name</th>
            <th>Status</th>
        </tr>
        <?php if ($students_result && mysqli_num_rows($students_result) > 0): ?>
            <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td>
                        <select name="status[<?php echo $student['id']; ?>]" required>
                            <option value="">--Select--</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Late">Late</option>
                        </select>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="2">No students found in this class arm.</td></tr>
        <?php endif; ?>
    </table>

    <button type="submit" name="submit_attendance">Submit Attendance</button>
</form>

</body>
</html>
