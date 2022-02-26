

function follow(id1,id2){
	console.log(id1);
	console.log(id2);
	

 $.ajax
 ({
  type:'post',
  url:'insert.php',
  data:{
	follow:'follow',
   uid:id2,
   fid:id1
  },
  success: function(res){  
                         
                    }


 });
 
}


function unfollow(id1,id2){
	console.log(id1);
	console.log(id2);
	

 $.ajax
 ({
  type:'post',
  url:'insert.php',
  data:{
	unfollow:'unfollow',
   uid:id2,
   fid:id1
  },
  success: function(res){  
                         
                    }


 });
 
}


function Clearchat(){
	//console.log(id1);
	//console.log(id2);
	

 $.ajax
 ({
  type:'post',
  url:'clearchat.php',
  data:{
	clearchat:'clearchat',
   
  },
  success: function(res){  
                         
                    }


 });
 location.reload();
}


function Block(){
	//console.log(id1);
	//console.log(id2);
	
 $.ajax
 ({
  type:'post',
  url:'clearchat.php',
  data:{
	Block:'Block',
   
  },
  success: function(res){  
                         
                    }


 });
 location.reload();
}


function UNBlock(){
	//console.log(id1);
	//console.log(id2);
	
 $.ajax
 ({
  type:'post',
  url:'clearchat.php',
  data:{
	UNBlock:'UNBlock',
   
  },
  success: function(res){  
                         
                    }


 });
 location.reload();
}


function Deletecontact(){

	
 $.ajax
 ({
  type:'post',
  url:'clearchat.php',
  data:{
	Deletecontact:'Deletecontact',
   
  },
  success: function(res){  
                         
                    }


 });
 location.reload();
}



function followback(){

	
	
 $.ajax
 ({
  type:'post',
  url:'clearchat.php',
  data:{
	followback:'followback',
   
  },
  success: function(res){  
                         
                    }


 });
 location.reload();
}


function sendingids(id,id2){

	console.log(id);
	console.log(id2);

$.ajax
 ({
  type:'post',
  url:'clearchat.php',
  data:{
	sendingids:'sendingids',
   id:id,
   id2:id2
  },
  success: function(res){  
                         
                    }


 });
}

