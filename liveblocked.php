<?php
session_start();
include 'database.php';
$id = $_SESSION['id'];
$ids = $_SESSION['id2'];
$result_arrays = array();
$chatmessages  = "SELECT `fid`, `uid`, `followid`, `date`, `blocked`, `blocked_id` FROM `follow` WHERE uid = '$id' and followid ='$ids'";

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