

<?php
session_start();
include 'database.php';
$result_array = array();

$id = $_SESSION['id'];
		$chatheader = mysqli_query($conn,"SELECT fid, uid, followid, date, blocked, blocked_id, request_id,
(SELECT r.username  FROM users r WHERE r.id =l.uid ) as usernames,
(SELECT r.imgurl  FROM users r WHERE r.id =l.uid ) as image
FROM follow l
WHERE request_id ='$id'");
   

          
            while ($rowdata = mysqli_fetch_array($chatheader))
            {
				
			array_push($result_array, $rowdata);
		 				
                
            }
		
echo json_encode($result_array);
?>