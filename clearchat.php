<?php
session_start();
include "database.php";
$ids = $_SESSION['idheader'];
$id = $_SESSION['id'];
if(isset($_POST['clearchat']))
{
 
$sql1 = "DELETE FROM chat WHERE sender_id = '$id' and reciver_id = '$ids' or sender_id ='$ids' and reciver_id = '$id'";

if(mysqli_query($conn, $sql1)){
    echo "Records was deleted successfully.";
} else {
    echo "ERROR: Could not able to execute $sql1. " 
                            . mysqli_error($conn);
}  
}
?>

<?php

include "database.php";
$ids = $_SESSION['idheader'];
$id = $_SESSION['id'];
$blocked = "1";
if(isset($_POST['Block']))
{
 
$sql2 = "UPDATE follow SET  blocked='$blocked', blocked_id='$id'  WHERE uid='$id' and followid ='$ids' ";

if(mysqli_query($conn, $sql2)){
    echo "Records was deleted successfully.";
	$sql3 = "UPDATE follow SET  blocked='$blocked', blocked_id='$id'  WHERE uid='$ids' and followid ='$id' ";

if(mysqli_query($conn, $sql3)){
    echo "Records was deleted successfully.";
	
} else {
    echo "ERROR: Could not able to execute $sql3. " 
                            . mysqli_error($conn);
}
} else {
    echo "ERROR: Could not able to execute $sql2. " 
                            . mysqli_error($conn);
}
}  
?>
<?php

include "database.php";
$ids = $_SESSION['idheader'];
$id = $_SESSION['id'];
$blocked = "0";
if(isset($_POST['UNBlock']))
{
 
$sql4 = "UPDATE follow SET  blocked='$blocked', blocked_id=''  WHERE uid='$id' and followid ='$ids' ";

if(mysqli_query($conn, $sql4)){
    echo "Records was deleted successfully.";
	$sql5 = "UPDATE follow SET  blocked='$blocked', blocked_id=''  WHERE uid='$ids' and followid ='$id' ";

if(mysqli_query($conn, $sql5)){
    echo "Records was deleted successfully.";
	
} else {
    echo "ERROR: Could not able to execute $sql5. " 
                            . mysqli_error($conn);
}
} else {
    echo "ERROR: Could not able to execute $sql4. " 
                            . mysqli_error($conn);
}
}  
?>

<?php

include "database.php";
$ids = $_SESSION['idheader'];
$id = $_SESSION['id'];
if(isset($_POST['Deletecontact']))
{
 
$sql6 = "DELETE FROM `follow` WHERE uid='$id' and followid = '$ids'";

if(mysqli_query($conn, $sql6)){
    echo "Records was deleted successfully.";
} else {
    echo "ERROR: Could not able to execute $sql6. " 
                            . mysqli_error($conn);
}  
}
?>
<?php

if(isset($_POST['sendingids']))
{
 
 $reqid=$_POST['id'];
 $reqidfid=$_POST['id2'];
$_SESSION['requestid'] =  $reqid;
$_SESSION['requestidfid'] =  $reqidfid;


}


?>
<?php

include "database.php";
 $id = $_SESSION['id'];
 $reqids = $_SESSION['requestid'];
 $requestidfid = $_SESSION['requestidfid'];
if(isset($_POST['followback']))
{
 
$sql = "INSERT INTO `follow`( uid, followid) VALUES ('$id','$reqids')";
}
if(mysqli_query($conn, $sql)){
    echo "Record was updated successfully.";
	$sql8 = "UPDATE follow SET  request_id=''  WHERE fid='$requestidfid'";

if(mysqli_query($conn, $sql8)){
    echo "Records was deleted successfully.";
	unset($_SESSION['requestid']);
	unset($_SESSION['requestidfid']);
} else {
    echo "ERROR: Could not able to execute $sql8. " 
                            . mysqli_error($conn);
}
} else {
    echo "ERROR: Could not able to execute $sql. " 
                            . mysqli_error($conn);
}

?>