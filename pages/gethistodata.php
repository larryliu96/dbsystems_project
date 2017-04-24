<?php

    // define variables and functions
    $servername = "webhost.engr.illinois.edu";
    $username = "dbsystems_hanjinh2";
    $password = "hanjinh2";
    $dbname = "dbsystems_test";
    $tablename = "HistoricalData";

    // connect to database
    $link = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        echo "Connect to database successfully!<br/>";
    }

    // Get data
    $item_id = 5167;
    $sql = "SELECT * FROM $tablename WHERE item_id = $item_id";
    if (!$result = $link->query($sql)) {
        echo "Error: Our query failed to execute and here is why: <br/>";
        echo "Query: " . $sql . "<br/>";
        echo "Error_number: " . $link->errno . "<br/>";
        echo "Error: " . $link->error . "<br/>";
    }

    echo "Get data from table successfully";
    echo "<br/>";

    $json_data = array();
    //$fp = fopen('/home/dbsystems/public_html/data/histodata1.js', 'w');
    //fwrite($fp, "var jsondata =");
    echo 'var jsondata = ';
		
    // $row = $result->fetch_assoc()
    // $row = mysql_fetch_array($result)
    while ($row = $result->fetch_assoc())
    {
        //echo $row['item_id'] . ": " . $row['date'] . " -> " . $row['price'] . "<br/>";

	$json_row['date'] = $row['date'];
	$json_row[$row['item_id']] = $row['price'];	
			
	array_push($json_data, $json_row);
    }
	
    $jsonstr = json_encode($json_data) . ";";
    echo $jsonstr;
    //fwrite($fp, $jsonstr);

    echo "<br/>test<br/>";

    $tablename1 = 'Product';
    $sql1 = "SELECT item_name FROM Product WHERE item_id = $item_id";
    $res0 = mysql_query($sql1);
    
    if(mysql_num_rows($res0))
    {
    	//$item_id = mysql_fetch_object($res0)->item_id;

    	echo "query succeeded<br/>";
    	//while ($row = mysql_fetch_array($res0)))
    	//{
        //    echo $row[0];
       	//}
    } else {
        echo "no result";
    }

    /*if (!$result1 = $link->query($sql)) {
        echo "Error: Our query failed to execute and here is why: <br/>";
        echo "Query: " . $sql . "<br/>";
        echo "Error_number: " . $link->errno . "<br/>";
        echo "Error: " . $link->error . "<br/>";
    } else {
        echo "query succeeded<br/>";
    }

    while ($row = mysql_fetch_array($result1))
    {   
        $item_name = $row['item_id'];
    } 


    echo $item_name;

    $codestr = "$(function(){

    Morris.Area({
        element: 'morris-area-chart',
        data: jsondata,
        xkey: 'date',
        ykeys: [$item_id],
        labels: [$item_name],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });});";

    echo $codestr;
    fwrite($fp, $codestr);

    fclose($fp);
		
    $result->close();
	
    // close connection
    mysqli_free_result($result);
    mysqli_close($link);*/
?>