<?php
    $tablename = "HistoricalData";
    session_start();
    $link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db('dbsystems_test');
    	
    $item_id = $_GET['item_id'];
    
    
    
    $item_name = $_GET['item_name'];
    $id = $_SESSION['user_id'];
    echo $item_name;
    echo " - ";
    echo $item_id;
    
    $sql0 = "SELECT * FROM HistoricalData WHERE item_id = '$item_id'";
    $res0 = mysql_query($sql0);
    
    $results = array();
    $fp = fopen('/home/dbsystems/public_html/data/histodata.js', 'w');
    fwrite($fp, "var jsondata =");
         
    while ($row = mysql_fetch_array($res0)){
        /*$results[] = array('date' => $row['date'],
                    'price' => (double)$row['price']
                    );*/
                  
        $json_row['date'] = $row['date'];
        $json_row[$row['item_id']] = $row['price'];	
        array_push($results, $json_row);
    }
    $jsonstr = json_encode($results) . ";";
    #$jsonstr = json_encode($results);
    #echo $jsonstr;
    fwrite($fp, $jsonstr);
    
       
    echo "<html> 
            <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'>
            <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
            <script src='//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'></script>
            <script src='//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js'></script>
            <link href='../vendor/morrisjs/morris.css' rel='stylesheet'>
    
            <body>
                <div id='myfirstchart' style='height: 250px;'></div>
            </body> 
            <script src='../data/histodata.js'></script>
        </html>";
        
    $codestr = "$(function(){
        Morris.Area({
        element: 'myfirstchart',
        data: jsondata,
        xkey: 'date',
        ykeys: [$item_id],
        labels: ['price'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
        });});";

    fwrite($fp, $codestr);
    fclose($fp);
 
    mysql_close($link);
 
?>
