<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

 $id = $_SESSION['user_id']; 
 $sql = "SELECT user_id, item_id, time FROM UserSearchHistory WHERE user_id = '$id' ORDER BY time DESC LIMIT 10";
 $res = mysql_query($sql);
 echo "<html>
 	<body>";
 while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
 	$item_id = $row['item_id'];
 	$sql1 = "SELECT item_name FROM Product WHERE item_id = '$item_id'";
 	$res1 = mysql_query($sql1);
 	$row1 = mysql_fetch_object($res1);
 	
 	echo $row1->item_name;
 	echo " ";
 	echo $row['time'];
 	echo "<br/>";
 }
 echo "</body>
 	</html>";
  mysql_close($link);
?>
