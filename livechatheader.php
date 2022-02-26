<?php
session_start();
include 'database.php';
$result_array = array();

$ids = $_SESSION['idheader'];
		$chatheader = mysqli_query($conn,"SELECT id, username, email, password, imgurl, location FROM users  WHERE id = '$ids'");
   

          
            while ($rowdata = mysqli_fetch_array($chatheader))
            {
				
			array_push($result_array, $rowdata);
		 				
                
            }
		
echo json_encode($result_array);
?>