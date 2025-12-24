<?php
include "db.php";
if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $update = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'";
    
    $sql = mysqli_query($conn, $update);
    if ($sql) {
        header('location:read.php');
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>	*{
    padding: 0;
    margin: 0;
}
body{
   background-color: antiquewhite; 
}
form{
    margin-left: 30%;  
     width: 30vw;
    height: 30vh;
    margin-top: 90px;
    background-color: gray;
    
}
input{
    margin-left: 30%;
    margin-top: 8px;
}
</style>
</head>
<body>
<form action="update.php" method="POST">
 
    <input type="hidden" name="id" value="1"> 
    
    <input type="text" name="name" placeholder="name"><br>
    <input type="text" name="email" placeholder="email"><br>
    <input type="password" name="password" placeholder="password"><br>
    <input type="submit" name="submit" value="submit"> 
<button><a href="read.php">cancer</a></button>
</form>
</body>
</html>
