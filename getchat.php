<?php 
///////////get chat data ////////////
session_start();
//include 'database.php';
//$result_arrays = array();
 $id = $_SESSION['id'];
if(isset($_POST['chatdata']))
{	 
	 $ids = $_POST['id'];
	 
 $_SESSION['id2'] =  $ids;
/*
$chatmessages  = "SELECT cid, sender_id, reciver_id,message,  
					(SELECT imgurl FROM users  WHERE id =chat.sender_id ) as image 
					FROM chat 
					WHERE sender_id = '$ids' and reciver_id = '$id'  or   sender_id = '$id' and reciver_id = '$ids' ORDER BY cid ASC";

				 $result5 = mysqli_query($conn,$chatmessages);
				  while ($recordchat = mysqli_fetch_array($result5))
            {
				//echo json_encode($row);
				//echo $record[] = $row;
			array_push($result_arrays, $recordchat);
		 				
                
            }
				
          echo json_encode($result_arrays);
		  */
}
?>