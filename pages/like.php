<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	
  $id = $_SESSION['user_id'];
  $item_id=$_POST["item_id"];
 
  $sql0="SELECT * FROM Likes WHERE user_id ='$id' AND item_id ='$item_id'";
  $res0 = mysql_query($sql0);
  
  if(mysql_num_rows($res0)){
    $sql1="DELETE FROM Likes WHERE user_id = '$id' AND item_id ='$item_id'";
    $res1 = mysql_query($sql1);
    echo 0;
  }
  else{
    $sql2="INSERT INTO Likes (user_id, item_id) VALUES ('$id', '$item_id')";
    $res2 = mysql_query($sql2);
    echo 1;
  }
  mysql_close($link);
?>
