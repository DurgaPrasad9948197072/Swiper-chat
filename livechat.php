<?php
session_start();
include 'database.php';
$id = $_SESSION['id'];
$ids = $_SESSION['id2'];
$result_arrays = array();
$chatmessages  = "SELECT cid, sender_id, reciver_id,message,time,  
					(SELECT imgurl FROM users  WHERE id =chat.sender_id ) as image 
					FROM chat 
					WHERE sender_id = '$ids' and reciver_id = '$id'  or   sender_id = '$id' and reciver_id = '$ids' ORDER BY cid ASC";

				 $result5 = mysqli_query($conn,$chatmessages);
				  while ($recordchat = mysqli_fetch_array($result5))
            {
				//echo json_encode($row);
				//echo $record[] = $row;
				// $time = $recordchat['time'];
				// $date = new DateTime($time);
				//echo $date->format('h:i:s a') ;
			array_push($result_arrays, $recordchat);
		 				
                
            }
				
          echo json_encode($result_arrays);
?>
