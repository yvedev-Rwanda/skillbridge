<?php
include "db.php";
if(isset($_GET['id'])){
    $userid = $_GET['id'];
    $delete="DELETE FROM users WHERE id=$userid";
    $result=mysqli_query($conn,$delete);
if($result){
    header("location:read.php");
}
else{
    die('you are swipped in programming').$userid;
}
}
?>