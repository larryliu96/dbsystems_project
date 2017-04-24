<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

 $item_id = $_POST['item_id']; 
 
 $sql = "SELECT * FROM Product p, Likes l WHERE p.item_id = l.item_id AND item_id = '$item_id'";
 $res = mysql_query($sql);
 $results = array();
 while ($row = mysql_fetch_array($res)){
     $results[] = array('item_name' => $row['item_name'],
                        'item_url' => $row['item_url'],
                        'img_url' => $row['img_url']
                        );
 }
 echo json_encode($results);
 //echo $id;
 mysql_close($link);
?>
