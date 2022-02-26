<?php
  session_start();
include_once 'database.php';
if(isset($_POST['save']))
{	 
	 $first_name = $_POST['name'];
	 $last_name = $_POST['email'];
	 $city_name = $_POST['password'];
	 $sql = "INSERT INTO users (username,email,password)
	 VALUES ('$first_name','$last_name','$city_name')";
	 if (mysqli_query($conn, $sql)) {
		//echo "New record created successfully !";
		  
			 $_SESSION['email'] = $last_name;
		 header("Location: index.php");
		   
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}
?>