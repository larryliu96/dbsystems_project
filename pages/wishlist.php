<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	
 
 $id = $_SESSION['user_id'];
 $show_wishlist = $_POST['show_wishlist'];
 $sql0 = "SELECT item_id FROM Wishlist WHERE user_id = '$id'";
 $res0 = mysql_query($sql0);
 $results = array();
 
 if(mysql_num_rows($res0)) {
     while ($row0 = mysql_fetch_array($res0)) {
         $item_id =$row0['item_id'];

         $sql1 = "SELECT * FROM Product WHERE item_id = '$item_id'";
         $res1 = mysql_query($sql1);
         $row1 = mysql_fetch_array($res1);
         
         #$sql2 = "SELECT * FROM Product p, Historical h WHERE h.item_id = '$item_id' AND h.date = '2017-04-20' AND p.item_id = h.item_id)";
         
            $sql2 = "SELECT price FROM HistoricalData WHERE item_id = '$item_id' AND date = '2017-04-20'" ;
            $res2 = mysql_query($sql2);
            $row2 = mysql_fetch_array($res2);
            
            #$results[] = array('item_id' => $row['item_id'], 'item_name' => $row['item_name']);
            
            $sql3 = "SELECT * FROM Likes WHERE user_id = '$id' AND item_id = '$item_id'";
            $res3 = mysql_query($sql3);
            $like_status = 0;
            if(mysql_num_rows($res3)){
                $like_status = 1;
            }
            $sql4 = "SELECT * FROM Wishlist WHERE user_id = '$id' AND item_id = '$item_id'";
            $res4 = mysql_query($sql4);
            $wish_status = 0;
            if(mysql_num_rows($res4)){
                $wish_status = 1;
            }

         $results[] = array('item_id' => $row1['item_id'],
                    'item_name' => $row1['item_name'],
                    'item_url' => $row1['item_url'],
                    'item_rating' => $row1['item_rating'],
                    'img_url' => $row1['img_url'],
                    'item_description' => $row1['item_description'],
                    'item_price' => $row2['price'],
                    'like_status' => $like_status,
                    'wish_status' => $wish_status
                    );
     }
 }
 echo json_encode($results);


 /*$sql0 = "SELECT host_user_id FROM SharedWishlst
					WHERE host_user_id  = $id";
						
 $res0 = mysql_query($sql0);
 
 if(mysql_num_rows($res0))
 {       $item_id = mysql_fetch_object($res0)->item_id;

	 
	 $sql2 = "SELECT Wishlist.wishlist_id, Users.username, Product.item_name FROM SharedWishlst, Users, Wishlist, Product
						WHERE SharedWishlst.host_user_id  = $id AND
							Users.user_id = SharedWishlst.friends_user_id AND
							Wishlist.wishlist_id = SharedWishlst.wish_list_id AND
							Product.item_id = Wishlist.product_id
							ORDER BY Wishlist.wishlist_id";
						
						
						
	 						
	 $res2 = mysql_query($sql2);
	 echo "<html><body><h3>Shared Wish List</h3>";
         echo "<table><tr><th>Wishlist ID</th><th>Friend's Username</th><th>Product Name</th></tr>";
	 
	 while ($row = mysql_fetch_array($res2))
	 {
	 	//echo $row['Product.item_name'];
	 	//echo "Item1";
                echo "<tr>";

	 	echo "<td>" . $row[0] . "</td>";
	 	//echo " ";
	 	//echo $row['HistoricalData.date'];
	 	//echo "Date";
	 	echo "<td>" . $row[1] . "</td>";
	 	//echo " ";
	 	//echo $row['HistoricalData.price'];
	 	//echo "Price";
		echo "<td>" . $row[2] . "</td>";
                //echo "<td>" . $row[3] . "</td>";
                //echo "<td>" . $row[4] . "</td>";
               
                echo "</tr>";

	 	echo "<br/>";
	 }

	 echo "</table></body></html>";
 }
 else
 {
 	echo "<html> <body>
 		You do not have any shared wish list.
 	     </body> </html>";
 } */
 
 
  mysql_close($link);
?>
