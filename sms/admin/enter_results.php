<?php
$conn = mysqli_connect("localhost", "root", "", "student");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST['submit_result'])) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $score = $_POST['score'];
    $term = $_POST['term'];
    $year = $_POST['year'];


    $check = mysqli_query($conn, "SELECT * FROM results WHERE student_id = $student_id AND subject_id = $subject_id AND term = '$term' AND year = '$year'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Result already exists!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO results (student_id, subject_id, score, term, year) 
                  VALUES ($student_id, $subject_id, $score, '$term', $year)");

        $message = $insert ? "Result saved!" : "Error saving result.";
    }
}

$students = mysqli_query($conn, "SELECT id, name FROM students ORDER BY name ASC");


$subjects = mysqli_query($conn, "SELECT id, name FROM subjects ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Student Results</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    padding: 30px;
    margin: 0;
}

h2 {
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

form {
    background: #ffffff;
    max-width: 500px;
    margin: 0 auto;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    color: #444;
    font-weight: 600;
}

input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    transition: border 0.3s;
}

input:focus,
select:focus {
    border-color: #4a90e2;
    outline: none;
}

button {
    width: 100%;
    background-color: #4a90e2;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #357ab8;
}

.message {
    text-align: center;
    margin-bottom: 20px;
    padding: 10px;
    color: green;
    background: #e6f5ea;
    border-left: 5px solid #4CAF50;
    border-radius: 6px;
}
</style>
</head>
<body>

<h2>Enter Results</h2>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST">
    <label>Student:</label>
    <select name="student_id" required>
        <option value="">Select Student</option>
        <?php while ($s = mysqli_fetch_assoc($students)) {
            echo "<option value='{$s['id']}'>{$s['name']}</option>";
        } ?>
    </select>

    <label>Subject:</label>
    <select name="subject_id" required>
        <option value="">Select Subject</option>
        <?php while ($sub = mysqli_fetch_assoc($subjects)) {
            echo "<option value='{$sub['id']}'>{$sub['name']}</option>";
        } ?>
    </select>

    <label>Score:</label>
    <input type="number" name="score" min="0" max="100" required>

    <label>Term:</label>
    <select name="term" required>
        <option value="Term 1">Term 1</option>
        <option value="Term 2">Term 2</option>
        <option value="Term 3">Term 3</option>
    </select>

    <label>Year:</label>
    <input type="number" name="year" value="<?php echo date('Y'); ?>" required>

    <button type="submit" name="submit_result">Submit Result</button>
</form>

</body>
</html>
