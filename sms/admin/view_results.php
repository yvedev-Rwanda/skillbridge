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

$student_id = $_SESSION['user_id'];

$query = "
    SELECT r.score, r.term, r.year, s.name AS subject_name
    FROM results r
    JOIN subjects s ON r.subject_id = s.id
    WHERE r.student_id = $student_id
    ORDER BY r.year DESC, r.term DESC, s.name ASC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even){
            background-color: #f2f2f2;
        }
        a.button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>My Results</h2>

<?php if ($result && mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>Subject</th>
            <th>Score</th>
            <th>Term</th>
            <th>Year</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
            <td><?php echo htmlspecialchars($row['score']); ?></td>
            <td><?php echo htmlspecialchars($row['term']); ?></td>
            <td><?php echo htmlspecialchars($row['year']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No results found.</p>
<?php endif; ?>

<a class="button" href="student.php">Back to Dashboard</a>

</body>
</html>
