<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <style>
*{
    padding: 0;
    margin: 0;
}
body{
   background-color: antiquewhite; 
}
table{
    margin-left: 30%;  
     width: 45vw;
    height: 6px;
    margin-top: 90px;
    background-color: gray;
    
}
button{
    margin-left: 30%;  
   
   
    
}
    </style>
</head>
<body>
    <table border="2">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>password</th>
            <th>action</th>
        </tr>
        <?php
        
      include "db.php";
        $sql = "SELECT * FROM users";
        $sql = mysqli_query($conn, $sql);

        if ($sql){
            
            while ($row = mysqli_fetch_assoc($sql)) {
                echo "<tr>";
                echo "<td>" . ($row['id']) . "</td>";
                echo "<td>" . ($row['name']) . "</td>";
                echo "<td>" . ($row['email']) . "</td>";
                echo "<td>" . ($row['password']) . "</td>";
                echo "<td>".
                "<a href='delete.php?id=".$row['id']."'>delete</a>"
                ." ".
                "<a href='update.php?id=".$row['id']."'>update</a>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }

        mysqli_close($conn);
        ?>
    
    </table>
    <button><a href="index.php">signup</a></button>
</body>
</html>
