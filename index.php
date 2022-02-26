<?php
  session_start();
//echo $_SESSION['email'];
if($_SESSION['email']==null){
	 header("Location: sign-in.php");
}else{
	
}
////////////// get user details //////////
		include "database.php";
		
		$sessionname = $_SESSION['email'];
		$result = mysqli_query($conn,"SELECT id, username, email, password, imgurl, location FROM users  WHERE email = '$sessionname'");
   

          
            while ($row = mysqli_fetch_array($result))
            {
			 $id = $row['id'];
             $username = $row['username'];
			 $email = $row['email'];
			 $password = $row['password'];
			 $imgurl = $row['imgurl'];
			 $location = $row['location'];
			
			
                
            }
		 $_SESSION['id'] =  $id;
		
//////////get friends list //////////////////
    $sql    = "SELECT l.id, l.username, l.email, l.imgurl, l.location
 FROM users l
WHERE l.id NOT IN ('$id')";

            $result1 = mysqli_query($conn,$sql) or die(mysqli_error());
            while ($row1    = mysqli_fetch_array($result1))
            {
				  //$userid = $row1['id'];
				$record[] = $row1;
            
            }

/////////// get folloers data //////////
		  $follow   = "SELECT fid, uid, followid, date FROM follow WHERE uid = $id";

            $result2 = mysqli_query($conn,$follow) or die(mysqli_error());
           
			 while ($row2    = mysqli_fetch_array($result2))
											{
											
													  $followid	=  $row2['followid'];
													 $fid	=  $row2['fid'];
												//$records[] = $row2;
											}
?>

								

<?php
	
	///////////// get chat list //////////////////

				 $chat  = "SELECT l.fid, l.uid, l.followid, l.date,l.blocked,blocked_id,
			(SELECT r.username  FROM users r WHERE r.id =l.followid ) as usernames,
			(SELECT r.imgurl  FROM users r WHERE r.id =l.followid ) as image,
            (SELECT c.message FROM chat c WHERE c.reciver_id = l.followid and c.sender_id = $id   ORDER BY c.cid DESC   LIMIT 1  ) as messages
			FROM follow l
			WHERE uid =  $id";

            $result3 = mysqli_query($conn,$chat) or die(mysqli_error());
            while ($row3    = mysqli_fetch_array($result3))
            {
				$chatid	=  $row3['fid'];
				$recordss[] = $row3;
            
            }
	
	////////////////// messages /////////////
	/*SELECT c.cid, c.sender_id, c.reciver_id,c.message, c.time,
(SELECT r.imgurl  FROM users r WHERE r.id =C.sender_id ) as image
FROM chat c
WHERE c.sender_id = 3 or c.sender_id = 6 ORDER BY  c.cid ASC*/

	
?>
<script>
								
									 var x1 = localStorage.getItem("chatid");
									
									</script>
									
									<?php
	$chatids = "<script>document.write(x1);</script>";
		 
	$chatdatalist = [];
	
		$chatmessages  = "SELECT cid, sender_id, reciver_id,message,  
					(SELECT imgurl FROM users  WHERE id =chat.sender_id ) as image 
					FROM chat 
					WHERE sender_id = '$chatids' and reciver_id = '$id'  or   sender_id = '$id' and reciver_id = '$chatids' ORDER BY cid ASC";

				 $result5 = mysqli_query($conn,$chatmessages);
				if(mysqli_num_rows($result5)>0)
				{
				$recordchat=mysqli_fetch_array($result5);
				echo $cid	=  $recordchat['message'];
				 $chatdatalist[] = $recordchat;
            
				}
          
		
	
			?>
<script type="text/javascript">
var userid=<?php echo json_encode($id); ?>;
</script>
<script>
								function chatid(id1){
									
									  localStorage.setItem("chatid", id1);
						

										 $.ajax
										 ({
										  type:'post',
										  url:'getdata.php',
										  data:{
											chathead:'chathead',
										   id:id1,

										  },
										  success: function(res){  
				/*var result= $.parseJSON(res); 

           
         
          
            $.each( result, function( key, value ) { 
              
				idchat = value['id'];  
              string = value['username'];  
              avatars = value['imgurl'];  
			  console.log(avatars);
			  document.getElementById("avatar").src = avatars;
			  document.getElementById("avataremty").src = avatars;
			  document.getElementById("dataemty").innerHTML = string;
                     
                  }); 

               
					
              $("#data").html(string);  */
			//  $('#avatar').html(imagstring);
																	 
				}
				});
				///// get mssgd for each user ////////		 
									 $.ajax
										 ({
										  type:'post',
										  url:'getchat.php',
										  data:{
											chatdata:'chatdata',
										   id:id1,

										  },
										  success: function(res){  
										/*
										var resultss= $.parseJSON(res); 
											stringschat = "";
										 $.each( resultss, function( key, value ) { 

										  if(value['sender_id']== userid){
											 console.log("equal",value['sender_id']);
											 console.log("equal-message",value['message']);
										  stringschat += "<div class='message me'><div class='text-main'><div class='text-group me'><div class='text me'><p>"+value['message']+"</p></div></div><span>11:32 AM</span></div></div>";  
										  }else{
											  console.log("notequal",value['sender_id']);
											  console.log("notequal-message",value['message']);
										  stringschat += "<div class='message'><img class='avatar-md' src='"+value['image']+"' data-placement='top' title='Keith' alt='avatar'><div class='text-main'><div class='text-group'><div class='text'><p>"+value['message']+"</p></div></div><span>09:46 AM</span></div></div>";  

										  }				  
										}); 
										   

										
										  $('#chatcontent').html(stringschat);
												*/										 
											}


										 });
						location.reload();
								}
</script>
								
<script>
								

function sendmessage(){
	var element = document.getElementById("mssg").value;
console.log("idchat",idchat);

 $.ajax
 ({
  type:'post',
  url:'insert.php',
  data:{
	sendmessage:'sendmessage',
   fid:idchat,
   mssg:element
  },
  success: function(res){  
                         
                    }


 });
 
}

</script>
	
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Swipe – The Simplest Chat Platform</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="dist/img/favicon.png" type="image/png" rel="icon">
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js" ></script>
		<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="index.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js" ></script>
  <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script type="text/javascript"> 

       $("document").ready(function(){ 

          $.ajax({ 

            method: "GET", 
            
            url: "livechat.php",

          }).done(function( data ) { 

		var resultss= $.parseJSON(data); 
											stringschat = "";
										 $.each( resultss, function( key, value ) { 

										  if(value['sender_id']== userid){
											  var time = new Date(value['time']);
											console.log(time.toLocaleTimeString());
											 
										  stringschat += "<div class='message me'><div class='text-main'><div class='text-group me'><div class='text me'><p>"+value['message']+"</p></div></div><span>"+time.toLocaleTimeString()+"</span></div></div>";  
										  }else{
											   var time = new Date(value['time']);
											console.log(time.toLocaleTimeString());
											 
										  stringschat += "<div class='message'><img class='avatar-md' src='"+value['image']+"' data-placement='top' title='Keith' alt='avatar'><div class='text-main'><div class='text-group'><div class='text'><p>"+value['message']+"</p></div></div><span>"+time.toLocaleTimeString()+"</span></div></div>";  

										  }				  
										}); 
										   

										
										  $('#chatcontent').html(stringschat);
																				
           }); 
       
    }); 
    </script> 
<script type="text/javascript"> 

       $("document").ready(function(){ 

          $.ajax({ 

            method: "GET", 
            
            url: "livechatheader.php",

          }).done(function( data ) { 

	var result= $.parseJSON(data); 

           
         
          
            $.each( result, function( key, value ) { 
              
				idchat = value['id'];  
              string = value['username'];  
              avatars = value['imgurl'];  
			  console.log(avatars);
			  document.getElementById("avatar").src = avatars;
			  document.getElementById("avataremty").src = avatars;
			  document.getElementById("dataemty").innerHTML = string;
                     
                  }); 

               
					
              $("#data").html(string);  
			//  $('#avatar').html(imagstring);
													
																				
           }); 
       
    }); 
    </script> 
	<script type="text/javascript"> 

       $("document").ready(function(){ 

          $.ajax({ 

            method: "GET", 
            
            url: "liveblocked.php",

          }).done(function( data ) { 

	var result= $.parseJSON(data); 

           
       
          stringsblock = "";
            $.each( result, function( key, value ) { 
		
		    if(value['blocked_id']== null && value['blocked']== 0){
				 document.getElementById("blockedbutton").innerHTML = "<button class='dropdown-item' onclick='return Block();' ><i class='material-icons' >block</i>Block Contact</button>";
				 document.getElementById("disable").innerHTML = "";
			 }else if(value['blocked_id']!= userid && value['blocked']== 1){
				document.getElementById("blockedbutton").innerHTML = "<button class='dropdown-item' disabled><i class='material-icons' >block</i>block Contact</button>"; 
				document.getElementById("disable").innerHTML = "disabled";
			 }	

			 if(value['blocked']== 1 && value['blocked_id']== userid){							 
			 stringsblock += "<form class='position-relative w-100'><textarea class='form-control' id='mssg' placeholder='Messaging unavailable' rows='1' disabled></textarea><button class='btn emoticons' disabled><i class='material-icons'>insert_emoticon</i></button><button type='submit' class='btn send'  disabled><i class='material-icons'>send</i></button></form><label><input type='file' disabled><span class='btn attach d-sm-block d-none'><i class='material-icons'>attach_file</i></span></label> "; 
			 document.getElementById("blockedbutton").innerHTML = "<button class='dropdown-item' onclick='return UNBlock();'><i class='material-icons' >block</i>Unblock Contact</button>";
			 }else{								   						 
			 stringsblock += "<form class='position-relative w-100'><textarea class='form-control' id='mssg' placeholder='Start typing for reply...' rows='1' id='disable'></textarea><button class='btn emoticons'><i class='material-icons'>insert_emoticon</i></button><button type='submit' class='btn send' onclick='return sendmessage();'><i class='material-icons'>send</i></button></form><label><input type='file'><span class='btn attach d-sm-block d-none'><i class='material-icons'>attach_file</i></span></label>";
			 document.getElementById("blockedbutton").innerHTML = "<button class='dropdown-item' onclick='return Block();'><i class='material-icons' >block</i>Block Contact</button>";
			
			 }	
		   
            }); 

               
					
            $("#blocked").html(stringsblock);  
		
													
																				
           }); 
       
    }); 
    </script> 
	
	<script type="text/javascript"> 

       $("document").ready(function(){ 

          $.ajax({ 

            method: "GET", 
            
            url: "liverequest.php",

          }).done(function( data ) { 

	var result= $.parseJSON(data); 

           
          stringrequest = "";
          
            $.each( result, function( key, value ) { 
              console.log(value['fid']);
				
                     if(value['fid']==null){
						 console.log("id",value['fid']);
						 stringrequest += "";
					 }else{
						  avatarsreq = value['image'];
						  namereq = value['usernames'];
						 console.log("id",value['fid']);
						 stringrequest += "<a href='#list-request' class='filterDiscussions all unread single' id='list-request-list' data-toggle='list' role='tab' onclick='return sendingids("+value['uid']+","+value['fid']+");' ><img class='avatar-md' src='"+value['image']+"' data-toggle='tooltip' data-placement='top' title='Louis' alt='avatar'><div class='status'><i class='material-icons offline'>fiber_manual_record</i></div><div class='new bg-gray'><span>?</span></div><div class='data'><h5>"+value['usernames']+"</h5><span>"+value['date']+"</span><p>Hi  I'd like to add you as a contact.</p></div></a>";
					  document.getElementById("avatarreq").src = avatarsreq;
					  document.getElementById("avatarreq2").src = avatarsreq;
					  	  document.getElementById("namereq").innerHTML = namereq;
					  	  document.getElementById("namereq2").innerHTML = namereq;
					 }
                  }); 

               
					
              $("#requestdatafetch").html(stringrequest);  
													
																				
           }); 
       
    }); 
    </script>
	</head>
	<body>
	<?php

 // Using database connection file here
$ids = $_SESSION['id'];

if(isset($_POST["upload"]))
{
    $var1 = rand(1111,9999);  // generate random number in $var1 variable
    $var2 = rand(1111,9999);  // generate random number in $var2 variable
	
    $var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
    $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

    $fnm = $_FILES["image"]["name"];    // get the image name in $fnm variable
    $dst = "./uploads/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
    $dst_db = "uploads/".$var3.$fnm; // storing image path into the database with 32 characters hex number and file name

    move_uploaded_file($_FILES["image"]["tmp_name"],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name
	$firstName = $_POST['firstName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$location = $_POST['location'];

	
    $check = mysqli_query($conn,"UPDATE users SET imgurl='$dst_db', username='$firstName', email='$email', password='$password', location='$location'  WHERE id='$ids'");  // executing insert query
		
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
		<main>
			<div class="layout">
				<!-- Start of Navigation -->
				<div class="navigation">
					<div class="container">
						<div class="inside">
							<div class="nav nav-tab menu">
								<button class="btn"><img class="avatar-xl" src="<?php echo   $imgurl ?>" alt="avatar"></button>
								<a href="#members" data-toggle="tab"><i class="material-icons">account_circle</i></a>
								<a href="#discussions" data-toggle="tab" class="active"><i class="material-icons active">chat_bubble_outline</i></a>
								<a href="#notifications" data-toggle="tab" class="f-grow1"><i class="material-icons">notifications_none</i></a>
								<button class="btn mode"><i class="material-icons">brightness_2</i></button>
								<a href="#settings" data-toggle="tab"><i class="material-icons">settings</i></a>
								<a class="btn power" href="sign-in.php"><i class="material-icons">power_settings_new</i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Navigation -->
				<!-- Start of Sidebar -->
				<div class="sidebar" id="sidebar">
					<div class="container">
						<div class="col-md-12">
							<div class="tab-content">
								<!-- Start of Contacts -->
								<div class="tab-pane fade" id="members">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="people" placeholder="Search for people...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
										<button class="btn create" data-toggle="modal" data-target="#exampleModalCenter"><i class="material-icons">person_add</i></button>
									</div>
									<div class="list-group sort">
										<button class="btn filterMembersBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterMembersBtn" data-toggle="list" data-filter="online">Online</button>
										<button class="btn filterMembersBtn" data-toggle="list" data-filter="offline">Offline</button>
									</div>						
									<div class="contacts">
										<h1>Contacts</h1>
										<div class="list-group" id="contacts" role="tablist">
										<?php 
										foreach ($record as $row) {
											 $userid = $row['id'];
											 
											 
											 
											// $followids	= $followid ;
									
									
											 
										   echo '<a href="#" class="filterMembers all online contact" data-toggle="list">';
										   echo '<img class="avatar-md" src="'. $row['imgurl'].'" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">';
										   echo '<div class="status"><i class="material-icons online">fiber_manual_record</i></div>';
										   echo '<div class="data">';
										   echo '<h5>'. $row['username'] .'</h5>';
										   echo '<p>Sofia, Bulgaria</p>';
										   echo '</div>';
										   echo '<div class="person-add" >';
										   
										    if(!isset($followid)){
												$frieds = "person_add";
												$followclik = "onclick=follow(".$userid.",".$ids.");";
											}else if($followid==$userid){
												
											 $frieds = "person";
											$followclik = "onclick=unfollow(".$fid.",".$ids.");";					
											 }else{
											$frieds = "person_add";
											$followclik = "onclick=follow(".$userid.",".$ids.");";
											} 
											
										   echo '<i class="material-icons" '.$followclik.'>'.$frieds.'</i>';
										   echo '</div>';
										   echo '</a>';
										}
										?>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Janette Dalton</h5>
													<p>Sofia, Bulgaria</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-1.jpg" data-toggle="tooltip" data-placement="top" title="Michael" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Michael Knudsen</h5>
													<p>Washington, USA</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Lean Avent</h5>
													<p>Shanghai, China</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-2.jpg" data-toggle="tooltip" data-placement="top" title="Mariette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Mariette Toles</h5>
													<p>Helena, Montana</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-3.jpg" data-toggle="tooltip" data-placement="top" title="Harmony" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Harmony Otero</h5>
													<p>Indore, India</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all offline contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Keith Morris</h5>
													<p>Chisinau, Moldova</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all offline contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Louis Martinez</h5>
													<p>Vienna, Austria</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all offline contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-3.jpg" data-toggle="tooltip" data-placement="top" title="Ryan" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Ryan Foster</h5>
													<p>Oslo, Norway</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all offline contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-4.jpg" data-toggle="tooltip" data-placement="top" title="Mildred" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Mildred Bennett</h5>
													<p>London, United Kingdom</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
										</div>
									</div>
								</div>
								<!-- End of Contacts -->
								<!-- Start of Discussions blocked-->
								<div id="discussions" class="tab-pane fade active show">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
										<button class="btn create" data-toggle="modal" data-target="#startnewchat"><i class="material-icons">create</i></button>
									</div>
									<div class="list-group sort">
										<button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="read">Read</button>
										<button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="unread">Unread</button>
									</div>						
									<div class="discussions">
										<h1>Discussions</h1>
										<div class="list-group" id="chats" role="tablist">
										<?php	
									 if(!isset($chatid)){
												  
										}else{
										foreach ($recordss as $row) {
										
									$followid_id	=  $row['followid'];
									$messages	=  $row['messages'];
										 if(!isset($messages)){
												$chekmssg = "empty";
											}else{
												$chekmssg = "chat";
											}
											 
											
											echo '<a href="#list-'.$chekmssg.'" onclick="return chatid('.$followid_id.');" class="filterDiscussions all read single" id="list-'.$chekmssg.'-list2" data-toggle="list" role="tab" >';
											echo'<img class="avatar-md" src="'. $row['image'] .'" data-toggle="tooltip" data-placement="top" title="'. $row['usernames'] .'" alt="avatar">';
											echo'<div class="status">';
											echo'<i class="material-icons offline">fiber_manual_record</i>';
											echo '</div>';
											echo'<div class="data">';
											echo '<h5>'. $row['usernames'] .'</h5>';
											echo '<span>5 mins</span>';
											if($row['blocked_id'] == $row['uid'] || $row['blocked_id'] == $row['followid'])
											{
												$viewmessage = "Blocked";
											}else{
												
											 if(!isset($messages)){
												 $viewmessage = "chat not started yet";
											 }else{
												$viewmessage = $row['messages']; 
										
											}
											}
											echo '<p>'.$viewmessage.'</p>';
											echo'</div>';
											echo'</a>';	
											  }
											
										}
										
										?>
										
										<div id="requestdatafetch"></div>
											<a href="#list-empty" class="filterDiscussions all unread single active" id="list-empty-list2" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="new bg-yellow">
													<span>+7</span>
												</div>
												<div class="data">
													<h5>Janette Dalton</h5>
													<span>Mon</span>
													<p>A new feature has been updated to your account. Check it out...</p>
												</div>
											</a>									
											<a href="#list-empty" class="filterDiscussions all unread single" id="list-empty-list" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-1.jpg" data-toggle="tooltip" data-placement="top" title="Michael" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="new bg-pink">
													<span>+10</span>
												</div>
												<div class="data">
													<h5>Michael Knudsen</h5>
													<span>Sun</span>
													<p>How can i improve my chances of getting a deposit?</p>
												</div>
											</a>									
											<a href="#list-chat" class="filterDiscussions all read single" id="list-chat-list2" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Lean Avent</h5>
													<span>Tus</span>
													<p>Hey Chris, could i ask you to help me out with variation...</p>
												</div>
											</a>
											<a href="#list-empty" class="filterDiscussions all read single" id="list-empty-list2" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-2.jpg" data-toggle="tooltip" data-placement="top" title="Mariette" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Mariette Toles</h5>
													<span>5 mins</span>
													<p>By injected humour, or randomised words which...</p>
												</div>
											</a>
											<a href="#list-chat" class="filterDiscussions all read single" id="list-chat-list3" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-3.jpg" data-toggle="tooltip" data-placement="top" title="Harmony" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Harmony Otero</h5>
													<span>Mon</span>
													<p>No more running out of the office at 4pm on Fridays!</p>
												</div>
											</a>
											<a href="#list-empty" class="filterDiscussions all read single" id="list-empty-list3" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Keith Morris</h5>
													<span>Fri</span>
													<p>All your favourite books at your reach! We are now mobile.</p>
												</div>
											</a>
											<a href="#list-request" class="filterDiscussions all unread single" id="list-request-list" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="new bg-gray">
													<span>?</span>
												</div>
												<div class="data">
													<h5>Louis Martinez</h5>
													<span>Feb 10</span>
													<p>Hi Keith, I'd like to add you as a contact.</p>
												</div>
											</a>
											<a href="#list-empty" class="filterDiscussions all read single" id="list-empty-list4" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-3.jpg" data-toggle="tooltip" data-placement="top" title="Ryan" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Ryan Foster</h5>
													<span>Feb 9</span>
													<p>Dear Deborah, your Thai massage is today at 5pm.</p>
												</div>
											</a>
											<a href="#list-chat" class="filterDiscussions all unread single" id="list-chat-list5" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-4.jpg" data-toggle="tooltip" data-placement="top" title="Mildred" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="new bg-green">
													<span>+9</span>
												</div>
												<div class="data">
													<h5>Mildred Bennett</h5>
													<span>Thu</span>
													<p>Unfortunately your session today has been cancelled!</p>
												</div>
											</a>
										</div>
									</div>
								</div>
								<!-- End of Discussions -->
								<!-- Start of Notifications -->
								<div id="notifications" class="tab-pane fade">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="notice" placeholder="Filter notifications...">
											<button type="button" class="btn btn-link loop"><i class="material-icons filter-list">filter_list</i></button>
										</form>
									</div>
									<div class="list-group sort">
										<button class="btn filterNotificationsBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterNotificationsBtn" data-toggle="list" data-filter="latest">Latest</button>
										<button class="btn filterNotificationsBtn" data-toggle="list" data-filter="oldest">Oldest</button>
									</div>						
									<div class="notifications">
										<h1>Notifications</h1>
										<div class="list-group" id="alerts" role="tablist">
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Janette has accepted your friend request on Swipe.</p>
													<span>Oct 17, 2018</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-1.jpg" data-toggle="tooltip" data-placement="top" title="Michael" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Michael, you have a new friend suggestion today.</p>
													<span>Jun 21, 2018</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-2.jpg" data-toggle="tooltip" data-placement="top" title="Mariette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Mariette have just sent you a new message.</p>
													<span>Feb 15, 2018</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Louis has a birthday today. Wish her all the best.</p>
													<span>Mar 23, 2018</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-3.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Harmony has accepted your friend request on Swipe.</p>
													<span>Jan 5, 2018</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all oldest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Keith have just sent you a new message.</p>
													<span>Dec 22, 2017</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all oldest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Michael, you have a new friend suggestion today.</p>
													<span>Nov 29, 2017</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all oldest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-3.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Ryan have just sent you a new message.</p>
													<span>Sep 31, 2017</span>
												</div>
											</a>
											<a href="#" class="filterNotifications all oldest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/avatars/avatar-male-4.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Mildred has a birthday today. Wish him all the best.</p>
													<span>Jul 19, 2017</span>
												</div>
											</a>
										</div>
									</div>
								</div>
								<!-- End of Notifications -->
								<!-- Start of Settings -->


								<div class="tab-pane fade" id="settings">			
									<div class="settings">
										<div class="profile">
											<img class="avatar-xl" src="<?php echo   $imgurl ?>" alt="avatar">
											<h1><a href="#"><?php echo   $username ?></a></h1>
											<span><?php echo   $email ?></span>
											<div class="stats">
												<div class="item">
													<h2>122</h2>
													<h3>Fellas</h3>
												</div>
												<div class="item">
													<h2>305</h2>
													<h3>Chats</h3>
												</div>
												<div class="item">
													<h2>1538</h2>
													<h3>Posts</h3>
												</div>
											</div>
										</div>
										
										<div class="categories" id="accordionSettings">
											<h1>Settings</h1>
											<!-- Start of My Account -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<i class="material-icons md-30 online">person_outline</i>
													<div class="data">
														<h5>My Account</h5>
														<p>Update your profile details</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
													<div class="content">
														
														<form method="post" enctype="multipart/form-data">
														<div class="upload">
															<div class="data">
															
															<img class="avatar-xl" src="<?php echo   $imgurl ?>" alt="image">
																<label>
																	<input type="file"  name="image">
																	<span class="btn button" >Upload avatar</span>
																</label>
															</div>
															<p>For best results, use an image at le	ast 256px by 256px in either .jpg or .png format!</p>
														</div>
															<div class="parent">
																<div class="field">
																	<label for="firstName">Full name <span>*</span></label>
																	<input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name" value="<?php echo   $username ?>" >
																</div>
																
															</div>
															<div class="field">
																<label for="email">Email <span>*</span></label>
																<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" value="<?php echo   $email ?>" >
															</div>
															<div class="field">
																<label for="password">Password</label>
																<input type="password" class="form-control" id="password" name="password" placeholder="Enter a new password" value="<?php echo   $password ?>" >
															</div>
															<div class="field">
																<label for="location">Location</label>
																<input type="text" class="form-control" id="location" name="location" placeholder="Enter your location" value="<?php echo   $location ?>" >
															</div>
															<button class="btn btn-link w-100" href="delete.php?id=<?php echo $ids ?>">Delete Account</button>
															<input type="submit" class="btn button w-100" name="upload" value="upload">
														</form>
													</div>
												</div>
											</div>
											<!-- End of My Account  -->
											<!-- Start of Chat History -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
													<i class="material-icons md-30 online">mail_outline</i>
													<div class="data">
														<h5>Chats</h5>
														<p>Check your chat history</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="history">
															<p>When you clear your conversation history, the messages will be deleted from your own device.</p>
															<p>The messages won't be deleted or cleared on the devices of the people you chatted with.</p>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="same-address">
																<label class="custom-control-label" for="same-address">Hide will remove your chat history from the recent list.</label>
															</div>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="save-info">
																<label class="custom-control-label" for="save-info">Delete will remove your chat history from the device.</label>
															</div>
															<button type="submit" class="btn button w-100">Clear blah-blah</button>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Chat History -->
											<!-- Start of Notifications Settings -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
													<i class="material-icons md-30 online">notifications_none</i>
													<div class="data">
														<h5>Notifications</h5>
														<p>Turn notifications on or off</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Desktop Notifications</h5>
																<p>You can set up Swipe to receive notifications when you have new messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Unread Message Badge</h5>
																<p>If enabled shows a red badge on the Swipe app icon when you have unread messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Taskbar Flashing</h5>
																<p>Flashes the Swipe app on mobile in your taskbar when you have new notifications.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Notification Sound</h5>
																<p>Set the app to alert you via notification sound when you have unread messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Vibrate</h5>
																<p>Vibrate when receiving new messages (Ensure system vibration is also enabled).</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Turn On Lights</h5>
																<p>When someone send you a text message you will receive alert via notification light.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Notifications Settings -->
											<!-- Start of Connections -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
													<i class="material-icons md-30 online">sync</i>
													<div class="data">
														<h5>Connections</h5>
														<p>Sync your social accounts</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionSettings">
													<div class="content">
														<div class="app">
															<img src="dist/img/integrations/slack.svg" alt="app">
															<div class="permissions">
																<h5>Skrill</h5>
																<p>Read, Write, Comment</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/dropbox.svg" alt="app">
															<div class="permissions">
																<h5>Dropbox</h5>
																<p>Read, Write, Upload</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/drive.svg" alt="app">
															<div class="permissions">
																<h5>Google Drive</h5>
																<p>No permissions set</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/trello.svg" alt="app">
															<div class="permissions">
																<h5>Trello</h5>
																<p>No permissions set</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Connections -->
											<!-- Start of Appearance Settings -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
													<i class="material-icons md-30 online">colorize</i>
													<div class="data">
														<h5>Appearance</h5>
														<p>Customize the look of Swipe</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Turn Off Lights</h5>
																<p>The dark mode is applied to core areas of the app that are normally displayed as light.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round mode"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Appearance Settings -->
											<!-- Start of Language -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
													<i class="material-icons md-30 online">language</i>
													<div class="data">
														<h5>Language</h5>
														<p>Select preferred language</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="language">
															<label for="country">Language</label>
															<select class="custom-select" id="country" required>
																<option value="">Select an language...</option>
																<option>English, UK</option>
																<option>English, US</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Language -->
											<!-- Start of Privacy & Safety -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingSeven" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
													<i class="material-icons md-30 online">lock_outline</i>
													<div class="data">
														<h5>Privacy & Safety</h5>
														<p>Control your privacy settings</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSeven" aria-labelledby="headingSeven" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Keep Me Safe</h5>
																<p>Automatically scan and delete direct messages you receive from everyone that contain explict content.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>My Friends Are Nice</h5>
																<p>If enabled scans direct messages from everyone unless they are listed as your friend.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Everyone can add me</h5>
																<p>If enabled anyone in or out your friends of friends list can send you a friend request.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Friends of Friends</h5>
																<p>Only your friends or your mutual friends will be able to send you a friend reuqest.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Data to Improve</h5>
																<p>This settings allows us to use and process information for analytical purposes.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Data to Customize</h5>
																<p>This settings allows us to use your information to customize Swipe for you.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Privacy & Safety -->
											<!-- Start of Logout -->
											<div class="category">
												<a href="sign-in.php" class="title collapsed">
													<i class="material-icons md-30 online">power_settings_new</i>
													<div class="data">
														<h5>Power Off</h5>
														<p>Log out of your account</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
											</div>
											<!-- End of Logout -->
										</div>
									</div>
								</div>
								<!-- End of Settings -->
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
				<!-- Start of Add Friends -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Add your friends</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form>
									<div class="form-group">
										<label for="user">Username:</label>
										<input type="text" class="form-control" id="user" placeholder="Add recipient..." required>
										<div class="user" id="contact">
											<img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
											<h5>Keith Morris</h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="welcome">Message:</label>
										<textarea class="text-control" id="welcome" placeholder="Send your welcome message...">Hi Keith, I'd like to add you as a contact.</textarea>
									</div>
									<button type="submit" class="btn button w-100">Send Friend Request</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Add Friends -->
				<!-- Start of Create Chat -->
				<div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Start new chat</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form>
									<div class="form-group">
										<label for="participant">Recipient:</label>
										<input type="text" class="form-control" id="participant" placeholder="Add recipient..." required>
										<div class="user" id="recipient">
											<img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
											<h5>Keith Morris</h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="topic">Topic:</label>
										<input type="text" class="form-control" id="topic" placeholder="What's the topic?" required>
									</div>
									<div class="form-group">
										<label for="message">Message:</label>
										<textarea class="text-control" id="message" placeholder="Send your welcome message...">Hmm, are you friendly?</textarea>
									</div>
									<button type="submit" class="btn button w-100">Start New Chat</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Create Chat -->
				
			
				

				
				<div class="main">
					<div class="tab-content" id="nav-tabContent">
						<!-- Start of Babble -->
						<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat1">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
											
												<a href="#"><img class="avatar-md" id="avatar" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top"  alt="avatar"></a>
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#" id="data">unknown</a></h5>
													<span>Active now</span>
												</div>
												
												<button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="1"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="1"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item" onclick="return Clearchat();"><i class="material-icons">clear</i>Clear Chat History</button>
														<div id="blockedbutton"></div>
														<!--<button class="dropdown-item" onclick="return Block();"><i class="material-icons" >block</i>Block Contact</button>-->
														<button class="dropdown-item" onclick="return Deletecontact();"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="content" id="content">
									<div class="container">
										<div class="col-md-12">
										<!--	<div class="date">
												<hr>
												<span>Yesterday</span>
												<hr>
											</div>-->
											
												<?php	
									 /*
										foreach ((array)$chatdatalist as $rowss) {
										
								echo	$sender_idchat	=  $rowss['sender_id'];
								echo	$reciver_idchat	=  $rowss['reciver_id'];
										 if($sender_idchat==$id){
												echo '<div class="message me">';
												echo '<div class="text-main">';
												echo '<div class="text-group me">';
												echo '<div class="text me">';
												echo '<p>'.$rowss['message'].'</p>';
												echo '</div>';
												echo '</div>';
												echo '<span>11:32 AM</span>';
												echo '</div>';
												echo '</div>';
											}else{
												echo '<div class="message">';
												echo '<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">';
												echo '<div class="text-main">';
												echo '<div class="text-group">';
												echo '<div class="text">';
												echo '<p>'.$rowss['message'].'</p>';
												echo '</div>';
												echo '</div>';
												echo '<span>11:32 AM</span>';
												echo '</div>';
												echo '</div>';
											}
											 
											
										
											  }
										*/
										
										?> 
										<div id="chatcontent"></div> 
											
											<!--<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p>Can't wait! How are we coming along with the client?</p>
														</div>
													</div>
													<span>11:32 AM</span>
												</div>
											</div>
											<div class="message">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text">
															<p>Coming along nicely, we've got a draft for the client quarries completed.</p>
														</div>
													</div>
													<span>02:56 PM</span>
												</div>
											</div>
											<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p>Roger that boss!</p>
														</div>
													</div>
													<div class="text-group me">
														<div class="text me">
															<p>I have already started gathering some stuff for the mood boards, excited to start!</p>
														</div>
													</div>
													<span>10:21 PM</span>
												</div>
											</div>
											<div class="message">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text">
															<p>Great start guys, I've added some notes to the task. We may need to make some adjustments to the last couple of items - but no biggie!</p>
														</div>
													</div>
													<span>11:07 PM</span>
												</div>
											</div>
											<div class="date">
												<hr>
												<span>Today</span>
												<hr>
											</div>
											<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p>Well done all. See you all at 2 for the kick-off meeting.</p>
														</div>
													</div>
													<span>10:21 PM</span>
												</div>
											</div>
											<div class="message">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text">
															<div class="attachment">
																<button class="btn attach"><i class="material-icons md-18">insert_drive_file</i></button>
																<div class="file">
																	<h5><a href="#">Tenacy Agreement.pdf</a></h5>
																	<span>24kb Document</span>
																</div>
															</div>
														</div>
													</div>
													<span>11:07 PM</span>
												</div>
											</div>
											<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p>Hope you're all ready to tackle this great project. Let's smash some Brand Concept & Design!</p>
														</div>
													</div>
													<span><i class="material-icons">check</i>10:21 PM</span>
												</div>
											</div>
											<div class="message">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text typing">
															<div class="wave">
																<span class="dot"></span>
																<span class="dot"></span>
																<span class="dot"></span>
															</div>
														</div>
													</div>
												</div>
											</div>-->
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom" id="blocked">
											<!--<form class="position-relative w-100">
												<textarea class="form-control" id="mssg" placeholder="Start typing for reply..." rows="1"></textarea>
												<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
												<button type="submit" class="btn send" onclick="return sendmessage();"><i class="material-icons">send</i></button>
											</form>-->
											
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<div class="call" id="call1">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="1"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat2">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" id="avataremty" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#" id="dataemty">Lean Avent</a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="2"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="2"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages">
												<i class="material-icons md-48">forum</i>
												<p>Seems people are shy to start the chat. Break the ice send the first message.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" id="mssg" placeholder="Start typing for reply..." rows="1"></textarea>
												<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
												<button type="submit" class="btn send" onclick="return sendmessage();"><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<div class="call" id="call2">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-2.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="2"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-request" role="tabpanel" aria-labelledby="list-request-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat3">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" id="avatarreq" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top"  alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#" id="namereq">Louis Martinez</a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block disabled d-none" disabled><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages request">
												<a href="#"><img class="avatar-xl" id="avatarreq2" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<h5><span id="namereq2"></span> would like to add you as a contact. <span>Hi I'd like to add you as a contact.</span></h5>
												<div class="options">
													<button class="btn button" onclick="followback();"><i class="material-icons">check</i></button>
													<button class="btn button"onclick="cancelback();"><i class="material-icons">close</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Messaging unavailable" rows="1" disabled></textarea>
												<button class="btn emoticons disabled" disabled><i class="material-icons">insert_emoticon</i></button>
												<button class="btn send disabled" disabled><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file" disabled>
												<span class="btn attach disabled d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
						</div>
						<!-- End of Babble -->
					</div>
				</div>
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/swipe.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
				
		<script>
			function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
			scrollToBottom(document.getElementById('content'));
		</script>
		<?php mysqli_close($conn);  // close connection ?>
	</body>

</html>