<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "student");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add new term
if (isset($_POST['add_term'])) {
    $term_name = trim($_POST['term_name']);
    $year = intval($_POST['year']);

    if (!empty($term_name) && $year > 0) {
        $term_name = mysqli_real_escape_string($conn, $term_name);

        // Insert new term with is_active default 0
        $sql = "INSERT INTO terms (term_name, year, is_active) VALUES ('$term_name', $year, 0)";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Error adding term: " . mysqli_error($conn));
        }
    } else {
        echo "<p style='color:red;'>Please enter a valid term name and year.</p>";
    }
}

// Delete term
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $sql = "DELETE FROM terms WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error deleting term: " . mysqli_error($conn));
    }
}

if (isset($_GET['activate'])) {
    $id = intval($_GET['activate']);

    mysqli_query($conn, "UPDATE terms SET is_active = 0");

    $result = mysqli_query($conn, "UPDATE terms SET is_active = 1 WHERE id = $id");
    if (!$result) {
        die("Error activating term: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Terms</title>
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

<h2>Manage Terms</h2>

<form method="POST" action="">
    <input type="text" name="term_name" placeholder="Term Name (e.g. Term 1)" required>
    <input type="number" name="year" placeholder="Year (e.g. 2024)" required min="2000" max="2100">
    <button type="submit" name="add_term">Add Term</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Term Name</th>
        <th>Year</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM terms ORDER BY year DESC, term_name ASC");
    if ($result) {
        while ($term = mysqli_fetch_assoc($result)) {
            $id = $term['id'];
            $term_name = htmlspecialchars($term['term_name']);
            $year = $term['year'];
            $active = $term['is_active'] ? '<span class="active-term">Active</span>' : 'Inactive';

            echo "<tr>
                    <td>$id</td>
                    <td>$term_name</td>
                    <td>$year</td>
                    <td>$active</td>
                    <td>
                        <a href='?activate=$id' onclick='return confirm(\"Activate this term?\")'>Activate</a>
                        <a href='?delete=$id' onclick='return confirm(\"Delete this term?\")' style='color:red;'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Error loading terms: " . mysqli_error($conn) . "</td></tr>";
    }
    ?>
</table>
<button><a href="admin_dashboard.php">BACK</a></button>

</body>
</html>
