<?php

$conn = mysqli_connect("localhost", "root", "", "student");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['add_arm'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $name = mysqli_real_escape_string($conn, $name);
        $query = "INSERT INTO class_arms (name) VALUES ('$name')";
        mysqli_query($conn, $query);
    }
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $query = "DELETE FROM class_arms WHERE id = $id";
    mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Class Arms</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8;
    margin: 20px;
    color: #333;
}

h2, h3 {
    color: #2c3e50;
}

form {
    margin-bottom: 20px;
}

input[type="text"] {
    padding: 8px;
    width: 250px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus {
    border-color: #007BFF;
    outline: none;
}

button {
    padding: 8px 15px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #007BFF;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

a {
    color: #e74c3c;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
    <h2>Manage Class Arms</h2>


    <form method="POST" action="">
        <input type="text" name="name" placeholder="Enter Class Arm (e.g. Class A)" required>
        <button type="submit" name="add_arm">Add Class Arm</button>
    </form>

    <h3>List of Class Arms</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Arm Name</th>
            <th>Action</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM class_arms ORDER BY id ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td><a href='?delete={$row['id']}' onclick='return confirm(\"Delete this class arm?\")'>Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
      <button><a href="admin_dashboard.php">back</a></button>
</body>
</html>
