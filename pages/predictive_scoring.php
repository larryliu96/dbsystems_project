<?php
  $tablename = "HistoricalData";

  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

 $results = array();
 $results[] = array('item_id','date','price');
 $item_name = $_GET['item_name'];
 $item_id = $_GET['item_id'];
 echo $item_name;
 echo " - ";
 echo $item_id;
 if ($item_name == ""){
     echo $results;
 }
 $id = $_SESSION['user_id'];
 $search_name = '%' . $product_name . '%';
 

 $sql0 = "SELECT date, price FROM HistoricalData WHERE item_id = $item_id ";
 $res0 = mysql_query($sql0);
 while ($row = mysql_fetch_array($res0)){
     $results[] = array($item_id,$row['date'],$row['price']
                    );
 }
 $fp = fopen('../cgi-bin/virtualenv-15.1.0/myVE/bin/HistoricalData.csv', 'w');
 foreach($results as $line){
     fputcsv($fp, $line);
  }
  fclose($fp);

$command = 'cd ../cgi-bin/virtualenv-15.1.0/myVE/bin && ./python predictive_scoring.py > log';
$last_line = system($command, $retval);

// Printing additional info
    echo "<html> 
            <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'>
            <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
            <script src='//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'></script>
            <script src='//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js'></script>
            <link href='../vendor/morrisjs/morris.css' rel='stylesheet'>
    
            <body>
                <div id='predict' style='height: 250px;'></div>
            </body> 
            <script src='../data/data.js'></script>
        </html>";


 
 mysql_close($link);
?>
