<?php
$conn = mysqli_connect("localhost", "root", "", "student");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_teacher'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {

        $name = mysqli_real_escape_string($conn, $name);
        $query = "INSERT INTO teachers (name) VALUES ('$name')";
        mysqli_query($conn, $query);
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $query = "DELETE FROM teachers WHERE id = $id";
    mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html>
<head>
    
    <title>Manage Teachers</title>
     <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; }
        h2 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"], input[type="number"] {
            padding: 8px; width: 150px; margin-right: 10px; font-size: 16px;
        }
        button {
            padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background: #218838; }
        table {
            width: 100%; border-collapse: collapse; background: white;
        }
        th, td {
            border: 1px solid #ddd; padding: 10px; text-align: left;
        }
        th { background: #343a40; color: white; }
        a {
            color: #007bff; text-decoration: none; margin-right: 10px;
        }
        a:hover { text-decoration: underline; }
        .active-term {
            color: green; font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Manage Teachers</h2>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Enter Teacher Name" required>
        <button type="submit" name="add_teacher">Add Teacher</button>
    </form>

    <h3>List of Teachers</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Teacher Name</th>
            <th>Action</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM teachers ORDER BY id ASC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td><a href='?delete={$row['id']}' onclick='return confirm(\"Delete this teacher?\")'>Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
    <button><a href="admin_dashboard.php">BACK</a></button>
</body>
</html>
