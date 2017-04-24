<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');

 $post_req = $_POST['garbage'];
 $id = $_SESSION['user_id'];
 
 $sql = "SELECT item_id, price FROM HistoricalData WHERE date = CURDATE()";
 $res = mysql_query($sql);
 $sale_arr = array(0.9, 0.85, 0.75, 0.7);
 
 $fp = fopen('/home/dbsystems/public_html/pages/historical_data.txt', 'w');

 if (mysql_num_rows($res)){
	while ($row = mysql_fetch_object($res)){
		$item_id = $row->item_id;
		$price = $row->price; # is this row or res??
		for ($month = 0; $month < 6; $month++){

			$op = ($item_id/($month + 1)) % 10;
			
			if ($op == 0){
				for ($i = 1; $i <= 30; $i++){
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else {
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
						$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 1) {
				for ($i = 1; $i <= 30; $i++){
					if ($i % 8 == 0 || $i%9 ==0 || $i%5 ==0){
						$price = round($price * rand(98, 100)/100, 2);
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else{
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 2) {
				for ($i = 1; $i <= 30; $i++){
					if ($i % 8 == 0 || $i%9 ==0 || $i%5 ==0){
						$price = round($price * rand(95, 100)/100, 2);
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else {
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 3) {
				for ($i = 1; $i <= 30; $i++){
					if ($i < 10){
						if ($i % 4 == 0 || $i%3 ==0){
							$price = round($price * rand(98, 100)/100, 2);
						}
					}
					else{
						if ($i % 5 == 0 || $i%6 ==0){
							$price = round($price * rand(93, 100)/100, 2);
						}
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else {
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 4) {
				for ($i = 1; $i <= 30; $i++){
					if ($i % 8 == 0 || $i%9 ==0 || $i%5 ==0){
						$price = round($price * rand(100, 102)/100, 2);
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else{
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 5) {
				for ($i = 1; $i <= 30; $i++){
					if ($i % 8 == 0 || $i%9 ==0 || $i%5 ==0){
						$price = round($price * rand(100, 105)/100, 2);
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else{
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 6) {
				for ($i = 1; $i <= 30; $i++){
					if ($i < 10){
						if ($i % 4 == 0 || $i%3 ==0){
							$price = round($price * rand(100, 107)/100, 2);
						}
					}
					else{
						if ($i % 5 == 0 || $i%6 ==0){
							$price = round($price * rand(100, 102)/100, 2);
						}
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else{
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}

			}
			elseif ($op == 7) {
				for ($i = 1; $i <= 30; $i++){
					if ($i % 4 ==0 || $i% 6 == 0 || $i % 9 == 0 || $i%5 == 0){
						$price = round($price * rand(97, 103)/100, 2);
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else {
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}

			}
			elseif ($op == 8) {
				for ($i = 1; $i <= 30; $i++){
					if ($i < 10){
						if ($i % 4 == 0 || $i%3 ==0){
							$price = round($price * rand(98, 100)/100, 2);
						}
					}
					else{
						if ($i % 5 == 0 || $i%6 ==0){
							$price = round($price * rand(93, 100)/100, 2);
						}
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else {
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
			elseif ($op == 9) {
				for ($i = 1; $i <= 30; $i++){
					if ($i % 4 ==0 || $i% 6 == 0 || $i % 9 == 0 || $i%5 ==0){
						$price = round($price * rand(97, 103)/100, 2);
					}
					$sale = rand(1, 60);
					if ($sale == 1){
						$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
						$sale_price = $price * $sale_arr[rand(0,3)];
						$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$sale_price')";
						$res2 = mysql_query($sql2);	
					}
					else{
    					$date = "DATE_SUB(CURDATE(), INTERVAL ($i+$month*30) DAY)";
    					$sql2 = "INSERT INTO HistoricalData (item_id, date, price) VALUES ('$item_id', $date, '$price')";
    					$res2 = mysql_query($sql2);
					}
				}
			}
		}
	}
 } 
fclose($fp);
mysql_close($link);

?>
