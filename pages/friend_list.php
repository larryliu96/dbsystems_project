<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');

 $id = $_SESSION['user_id'];
  
 $sql0 = "SELECT friend_id FROM Friends WHERE host_id=$id UNION SELECT host_id FROM Friends WHERE friend_id='$id'";
 $res0 = mysql_query($sql0);
 $results = array();
 #echo "<html><body>";
 while ($row0 = mysql_fetch_array($res0)){
        $friend_id = $row0['friend_id'];
        
        $sql1 = "SELECT username FROM Users WHERE user_id = '$friend_id'";
        $res1 = mysql_query($sql1);
        $row1 = mysql_fetch_array($res1);
        $u_name = $row1['username'];
        
        $results[] = array('id' => $friend_id, 
                    'u_name' => $u_name);
 }
 echo json_encode($results);
 /*
 while( $row = mysql_fetch_array($res, MYSQL_NUM)){
 	$fid = $row[0]; 	
 	$sql1 = "SELECT username FROM Users WHERE user_id='$fid'";
 	$res1 = mysql_query($sql1);
 	$urow = mysql_fetch_object($res1);
 	#echo "<form action='show_wishlist.php?id=$fid' method='post' target='_blank'>
 	#	<input class= 'btn btn-lg btn-success' name='btn' type='submit' value='$urow->username'/>
 	#      </form>
 	#      <br/>";
 	
 }
 */
 #echo "</body></html>";
 mysql_close($link);
?>
