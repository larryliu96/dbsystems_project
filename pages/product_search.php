<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	
 $results = array();
 
 $product_name = $_POST['product_name'];
 $id = $_SESSION['user_id'];
 $min = $_POST['min'];
 $max = $_POST['max'];
 $filter = $_POST['filter'];
 $most_popular = 0;

 if ($product_name == ""){
     return $results;
 }
 if ($min == ""){
     $min = 0;
 }
 if ($max == ""){
     $max = 9999999;
 }
 if ($filter == ""){
     $filter = "DESC";
 }
 if ($filter == "LIKE"){
     $most_popular = 1;
 }
 //echo $filter;
 
 $search_string = '%' . $product_name . '%';

 if ($most_popular == 1){
     #$sql0 = "SELECT h.price, h.item_id FROM HistoricalData h, Likes l WHERE h.item_id IN (SELECT p.item_id FROM Product p WHERE p.item_name LIKE '$search_string') 
     #   AND price >= '$min' AND price <= '$max' AND h.date = '2017-04-20' GROUP BY item_id ORDER BY COUNT(item_id) ";
    
    #  $sql0 = "SELECT * FROM HistoricalData h LEFT JOIN(SELECT l.item_id, COUNT(*) AS post_count FROM Likes l GROUP BY l.item_id) AS p on h.item_id = p.item_id ORDER BY p.post_count DESC";  
    
    $sql0 = "SELECT h.price, h.item_id, COUNT(DISTINCT l.item_id) AS post_count 
            FROM HistoricalData h LEFT JOIN Likes l ON h.item_id = l.item_id 
            WHERE h.price >= '$min' AND h.price <= '$max' AND h.date = '2017-04-20' AND h.item_id 
            IN (SELECT item_id FROM Product WHERE item_name LIKE '$search_string')
            GROUP BY h.item_id ORDER BY `post_count` DESC LIMIT 50";
 }
 else{
    $sql0 = "SELECT price, item_id FROM HistoricalData WHERE item_id IN (SELECT item_id FROM Product WHERE item_name LIKE '$search_string') 
            AND price >= '$min' AND price <= '$max' AND date = '2017-04-20' ORDER BY price $filter "; 
 }
 
 // gets item_ids that match search string, filtered by price
 $res0 = mysql_query($sql0);

 
 if(mysql_num_rows($res0)){
     while ($row0 = mysql_fetch_array($res0)){
        $item_id = $row0['item_id'];
        
        $sql1 = "SELECT item_id, item_name, item_url, item_rating, img_url, item_description, item_path FROM Product WHERE item_id = '$item_id'";
        $res1 = mysql_query($sql1);
        $row1 = mysql_fetch_array($res1);

        $sql2 = "SELECT * FROM Likes WHERE user_id = '$id' AND item_id = '$item_id'";
        $res2 = mysql_query($sql2);
        $like_status = 0;
        if(mysql_num_rows($res2)){
            $like_status = 1;
        }
        $sql3 = "SELECT * FROM Wishlist WHERE user_id = '$id' AND item_id = '$item_id'";
        $res3 = mysql_query($sql3);
        $wish_status = 0;
        if(mysql_num_rows($res3)){
            $wish_status = 1;
        }
        $sql4 = "SELECT * FROM UserProductScore WHERE user_id = '$id' AND item_id = '$item_id'";
        $res4 = mysql_query($sql4);
        $user_rating = 0;
        if(mysql_num_rows($res4)){
            $row4 = mysql_fetch_array($res4);
            $user_rating = $row4['item_score'];
        }
        $results[] = array('item_id' => $row1['item_id'],
                'item_name' => $row1['item_name'],
                'item_url' => $row1['item_url'],
                'item_rating' => $row1['item_rating'],
                'img_url' => $row1['img_url'],
                'item_description' => $row1['item_description'],
                'item_path' => $row1['item_path'],
                'item_price' => $row0['price'],
                'like_status' => $like_status,
                'wish_status' => $wish_status,
                'user_rating' => $user_rating
                );
    }
 }
 echo json_encode($results);
 mysql_close($link);
?>
