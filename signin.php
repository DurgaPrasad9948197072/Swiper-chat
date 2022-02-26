<?php
  session_start();

include_once 'database.php';

if(isset($_POST['save']))
{	 
	 $name = $_POST['email'];
	 $password = $_POST['password'];
$result = mysqli_query($conn,"SELECT username, email FROM users WHERE email = '$name' and password = '$password'");

if ($result && mysqli_num_rows($result) > 0) {
    // Login
	
	  while ($row    = mysqli_fetch_array($result))
            {
				
       $title = $row['email'];
    
			 
            }
			
			$_SESSION['email'] =  $title;
	 header("Location: index.php");
	 
} else {
    // Failed!
	
  $_SESSION['error'] = "email or password incorrect!";
   header("Location: sign-in.php");
}

}