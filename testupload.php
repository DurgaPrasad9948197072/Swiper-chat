
<!DOCTYPE html>
<html>
<head>
  <title>Store and retrieve image from database in PHP</title>
</head>
<body>

<?php

include "database.php"; // Using database connection file here
 $id = "3";
if(isset($_POST["submit"]))
{
    $var1 = rand(1111,9999);  // generate random number in $var1 variable
    $var2 = rand(1111,9999);  // generate random number in $var2 variable
	
    $var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
    $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

    $fnm = $_FILES["image"]["name"];    // get the image name in $fnm variable
    $dst = "./uploads/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
    $dst_db = "uploads/".$var3.$fnm; // storing image path into the database with 32 characters hex number and file name

    move_uploaded_file($_FILES["image"]["tmp_name"],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name
	
    $check = mysqli_query($conn,"UPDATE users SET imgurl='$dst_db' WHERE id='$id'");  // executing insert query
		
    if($check)
    {
    	echo '<script type="text/javascript"> alert("Data Inserted Seccessfully!"); </script>';  // alert message
    }
    else
    {
    	echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
?>

<h2>Insert Data</h2>

<form method="post" enctype="multipart/form-data">
  <table border="2">
   
    <tr>
      <td>Select Image</td>
      <td><input type="file" name="image" Required></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="submit" value="Upload"></td>			
    </tr>
  </table>
</form>

<hr/>

<h2>All Records</h2>

<table border="2">
  <tr>
    <td>Sr.No.</td>
   
    <td>Images</td>
  </tr>

<?php

$records = mysqli_query($conn,"select * from users"); // fetch data from database

while($data = mysqli_fetch_array($records))
{
?>
  <tr>
    <td><?php echo $data['id']; ?></td>

    <td><img src="<?php echo $data['imgurl']; ?>" width="100" height="100"></td>
  </tr>	
<?php
}
?>

</table>

<?php mysqli_close($conn);  // close connection ?>

</body>
</html>