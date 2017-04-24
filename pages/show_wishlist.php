<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

 $id = $_POST['id']; 
 $sql = "SELECT item_name, item_url, img_url FROM Product p, Wishlist w WHERE w.user_id = '$id' AND p.item_id= w.item_id";
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
