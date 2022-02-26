<?php
session_start();
//include 'database.php';
//$result_array = array();
if(isset($_POST['chathead']))
{	 
	 $id = $_POST['id'];
$_SESSION['idheader'] =  $id;

	/*	$chatheader = mysqli_query($conn,"SELECT id, username, email, password, imgurl, location FROM users  WHERE id = '$id'");
   

          
            while ($rowdata = mysqli_fetch_array($chatheader))
            {
				//echo json_encode($row);
				//echo $record[] = $row;
			array_push($result_array, $rowdata);
		 				
                
            }
		
echo json_encode($result_array);
*/
}
///////////get chat data ////////////


?>				
