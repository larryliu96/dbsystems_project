<?php
    session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

    // get the current user id
    $id = $_SESSION['user_id'];
    $garbage = $_POST['garbage'];
    $filepathforid = '/home/dbsystems/public_html/cgi-bin/UserProductRatingCurrentUserId.csv';
    //echo $garbage;

    // output the rating scores
    $sql0 = "SELECT user_id FROM UserProductScore WHERE user_id = '$id'";
    $res0 = mysql_query($sql0);
    $filepath0 = '/home/dbsystems/public_html/cgi-bin/UserProductRatingScore.csv';
    
    if(mysql_num_rows($res0))
    {    
        // output the current user id
        $file = fopen($filepathforid, "w");
        fputcsv($file,explode(',', $id));
        
        $file = fopen($filepath0,"w");
        //$item_id = mysql_fetch_object($res0)->item_id;
	    $sql2 = "SELECT user_id, item_id, item_score FROM UserProductScore";
	    $res2 = mysql_query($sql2);
	   
	    while ($row = mysql_fetch_array($res2))
	    {
    	 	$line = $row[2];
    	 	fputcsv($file,explode(',',$line));
	    }
	    fclose($file);
    }
    else
    {
        // if current user does not have history, output -1 as user id
        $file = fopen($filepathforid, "w");
        fputcsv($file,explode(',', -1));
    }
    
// -----------


    $sql1 = "SELECT DISTINCT user_id FROM UserProductScore";
	$res1 = mysql_query($sql1);
	$filepath1 = '/home/dbsystems/public_html/cgi-bin/UserProductRatingUserId.csv';
    
	if(mysql_num_rows($res1))
	{       
		$file = fopen($filepath1, "w");
		
		while ($row = mysql_fetch_array($res1))
	    {
	        fputcsv($file, explode(',', $row[0]));
	    }

		fclose($file);
		
	}
	else
	{
		echo "<html> <body>
			Sorry, could not find product history
			 </body> </html>";
	}
	
	
    $command = 'cd ~/public_html/cgi-bin && ./virtualenv-15.1.0/myVE/bin/python video_game_recommender_ex.py > 1';
    
    
    
    // retrieve item_ids from file instead of directly from python program
    // then get all item_ids from file, and use them to iterate through etc...
    
    
    $last_line = system($command, $retval);
 
    //echo $last_line; last line should be single item_id value

    $results[] = array();
    
    if ($file = fopen("../cgi-bin/recommender_results.txt", "r")) {
       while(!feof($file)) {
           $line = fgets($file);
           //echo $line;
           //echo "\n";
           $sql3 = "SELECT p.item_id, p.item_name, p.item_url, p.img_url, p.item_rating, h.price FROM Product p, HistoricalData h WHERE h.item_id = '$line' AND h.date ='2017-04-20' AND p.item_id = h.item_id";
           $res3 = mysql_query($sql3);
           #count = 1;
            while ($row3 = mysql_fetch_array($res3))  {
                //echo $count;
                //$count += 1;
                //echo $row3['item_id'];
                $results[] = array('item_id' => $row3['item_id'],
                        'item_name' => $row3['item_name'],
                        'item_url' => $row3['item_url'],
                        'img_url' => $row3['img_url'],
                        'item_rating' => $row3['item_rating'],
                        'item_price' => $row3['price']
                    );
            }
       }
       fclose($file);
    }
    echo json_encode($results);
    

/*
    $results = array();
    $sql50 = "SELECT * FROM Product WHERE item_id = '$last_line'";
    $res50 = mysql_query($sql50);
    
    if(mysql_num_rows($res50)) 
    {
     while ($row50 = mysql_fetch_array($res50)) 
     {
        $item_id = $row50['item_id'];
        $sql51 = "SELECT price FROM HistoricalData WHERE item_id = '$item_id' AND date = '2017-04-20'";
        $res51 = mysql_query($sql51);
        $row51 = mysql_fetch_array($res51);
        
          $results[] = array('item_id' => $item_id,
                    'item_name' => $row50['item_name'],
                    'item_url' => $row50['item_url'],
                    'img_url' => $row50['img_url'],
                    'item_rating' => $row50['item_rating'],
                    'item_price' => $row51['price']
                    );
                    
 
     }
    } */

    mysql_close($link);
?>
