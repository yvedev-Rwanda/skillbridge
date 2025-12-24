<?php
include "db.php";
if($_SERVER["REQUEST_METHOD"]== "POST"){

$name=$_POST["name"];
$email=$_POST["email"];
$password=$_POST["password"];
$select="INSERT INTO user(name,email,password) VALUES('$name','$email','$password')";
$sql=mysqli_query($conn,$select);
	if($sql){
	header('location:read.php');
	}	
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
	*{
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
	height: 4vh;
	border-radius: 2px;

      width: 120px;
      height: 20px;
      background-color: white;
	  border:green;
    }
	h1{
		margin-left: 30%;
		color:white;

	}
  </style>
</head>
<body>
  <div></div>
</body>
</html>

</head>
<body>
	<form action="index.php" method="POST">
		<h1>WELCOME</h1>
<input type="text" name="name" placeholder="name"><br>
<input type="text" name="email" placeholder="email"><br>
<input type="password" name="password" placeholder="password"><br>
<input type="submit" name="submit" value="submit"> 	 	

	</form>
</body>
</html>