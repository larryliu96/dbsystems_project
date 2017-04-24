<?php
  $tablename = "HistoricalData";

  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

 $results = array();
 $product_name = $_POST['product_name'];
 if ($product_name == ""){
     return $results;
 }
 $id = $_SESSION['user_id'];
 $search_name = '%' . $product_name . '%';
 

 $sql0 = "SELECT item_id, item_name, item_url, img_url FROM Product WHERE item_name LIKE '$search_name'";
 $res0 = mysql_query($sql0);
 while ($row = mysql_fetch_array($res0)){
     $results[] = array('item_id' => $row['item_id'],
                    'item_name' => $row['item_name'],
                    'item_url' => $row['item_url'],
                    'img_url' => $row['img_url']
                    );
 }
 echo json_encode($results);
 
 /*
 if(mysql_num_rows($res0))
 {       $item_id = mysql_fetch_object($res0)->item_id;

	 
	 $sql2 = "SELECT Product.item_name, HistoricalData.date, MIN(HistoricalData.price), AVG(HistoricalData.price), MAX(HistoricalData.price) FROM Product, HistoricalData
						WHERE Product.item_name = '$product_name'
						AND HistoricalData.item_id = Product.item_id";
	 						
	 $res2 = mysql_query($sql2);
	 echo "<html><body><h3>Product's Price Information in History</h3>";
         echo "<table><tr><th>Product</th><th>Date</th><th>Minimum Price</th><th>Average Price</th><th>Maximum Price</th></tr>";
	 
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
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
               
                echo "</tr>";

	 	echo "<br/>";
	 }

	 echo "</table></body></html>";
	 
	 // Plot
	 $sql = "SELECT * FROM $tablename WHERE item_id = $item_id";
         if (!$result = mysql_query($sql)) {
             echo "Error: Our query failed to execute and here is why: <br/>";
             echo "Query: " . $sql . "<br/>";
             echo "Error_number: " . $link->errno . "<br/>";
             echo "Error: " . $link->error . "<br/>";
             //exit;
         }

         //echo "Get data from table successfully";
         //echo "<br/>";

         $json_data = array();
         $fp = fopen('/home/dbsystems/public_html/data/histodata.js', 'w');
         fwrite($fp, "var jsondata =");
         //echo 'var jsondata = ';
		
         // $row = $result->fetch_assoc()
         // $row = mysql_fetch_array($result)
         while ($row = mysql_fetch_array($result))
         {
             //echo $row['item_id'] . ": " . $row['date'] . " -> " . $row['price'] . "<br/>";

	     $json_row['date'] = $row['date'];
	     $json_row[$row['item_id']] = $row['price'];	
			
	     array_push($json_data, $json_row);
         }
	
        $jsonstr = json_encode($json_data) . ";";
        //echo $jsonstr;
        fwrite($fp, $jsonstr);

        $codestr = "$(function(){

        Morris.Area({
        element: 'morris-area-chart',
        data: jsondata,
        xkey: 'date',
        ykeys: [$item_id],
        labels: ['Camera'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
        });});";

        //echo $codestr;
        fwrite($fp, $codestr);

        fclose($fp);
 }
 else
 {
 	echo "<html> <body>
 		Sorry, could not find product history
 	     </body> </html>";
 }*/
 
 
  mysql_close($link);
?>
