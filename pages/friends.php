<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

  $id = $_SESSION['user_id'];
  $friend=$_POST["friend_uname"];
  $action =$_POST["action"];
  
  $sql="SELECT user_id FROM Users WHERE username='$friend'";
  $res = mysql_query($sql);
  $user_found = mysql_num_rows($res);
  $row = mysql_fetch_object($res);
  $friend_id = $row->user_id;
 
 
  if($user_found){
  	if($action == "add"){
  		$sql1="SELECT * FROM Friends WHERE (host_id='$id' AND friend_id='$friend_id') OR (host_id='$friend_id' AND friend_id = '$id')";
	  	$res1 = mysql_query($sql1);
	  	if(mysql_num_rows($res1)){
	  	    	 echo "User is already a friend";
	  	 }
	  	 else{
	  	    $sql2="INSERT INTO Friends (host_id, friend_id) VALUES ('$id', '$friend_id')";
	  		$res2 = mysql_query($sql2);
	  		if(mysql_affected_rows() < 0){
	  			echo "Friend Add Error";
	  		}
	  		else{
	  			echo "Friend Add Success";
	  		}
	  	 }
  	}
  	if($action == "remove"){
  		$sql3="DELETE FROM Friends WHERE (host_id='$id' AND friend_id='$friend_id') OR (host_id='$friend_id' AND friend_id = '$id')";
	  	$res3 = mysql_query($sql3);
	  	if(mysql_affected_rows() > 0){
	  		echo "User is removed from friends list";
	  	}
	  	else{
	  		echo "Friend Remove Failure";
	  	}
  	}
  }
  else{
    echo "Friend not found";
  }
  mysql_close($link);
?>
