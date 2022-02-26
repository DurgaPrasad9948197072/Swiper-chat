<?php
session_start();
include "database.php";
 $id = $_SESSION['id'];
if(isset($_POST['follow']))
{
 $uid=$_POST['uid'];
 $fid=$_POST['fid'];


$sql = "INSERT INTO `follow`( uid, followid, request_id) VALUES (' $uid','$fid','$fid')";
}
if(mysqli_query($conn, $sql)){
    echo "Record was updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " 
                            . mysqli_error($conn);
}



if(isset($_POST['unfollow']))
{
 $uid=$_POST['uid'];
 $fid=$_POST['fid'];


$sql1 = "delete from follow where fid=$fid";
}
if(mysqli_query($conn, $sql1)){
    echo "Record was deleted successfully.";
} else {
    echo "ERROR: Could not able to execute $sql1. " 
                            . mysqli_error($conn);
}  




if(isset($_POST['sendmessage']))
{

 $fid=$_POST['fid'];
 $mssg=$_POST['mssg'];


$sql2 = "INSERT INTO `chat`( `sender_id`, `reciver_id`,`message`) VALUES ('$id','$fid','$mssg')";
}
if(mysqli_query($conn, $sql2)){
	
	
    echo "Record was updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql2. " 
                            . mysqli_error($conn);
}
?>





