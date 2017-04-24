<?php
	session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');


	/*
	$id = $_SESSION['user_id'];
	$sql0 = "SELECT user_id FROM UserProductScore WHERE user_id = '$id'";
	$res0 = mysql_query($sql0);
	$filepath = '/home/dbsystems/public_html/cgi-bin/UserProductRatingScore.csv';
	*/
	
	
	$sql1 = "SELECT DISTINCT user_id FROM UserProductScore";
	$res1 = mysql_query($sql1);
	$filepath1 = '/home/dbsystems/public_html/cgi-bin/UserProductRatingUserId.csv';
	
	$sql2 = "SELECT DISTINCT item_id FROM UserProductScore";
	$res2 = mysql_query($sql2);
	$filepath2 = '/home/dbsystems/public_html/cgi-bin/UserProductRatingGameId.csv';

	if(mysql_num_rows($res1))
	{       
		$file = fopen($filepath1, "w");
		
		while ($row = mysql_fetch_array($res1))
	    {
	        fputcsv($file, explode(',', $row[0]));
	    }

		fclose($file);
		
		echo "successfully output user id to UserProductRatingUserId.csv";
	}
	else
	{
		echo "<html> <body>
			Sorry, could not find product history
			 </body> </html>";
	}
	
	if(mysql_num_rows($res2))
	{       
		$file = fopen($filepath2, "w");
		
		while ($row = mysql_fetch_array($res2))
	    {
	        fputcsv($file, explode(',', $row[0]));
	    }

		fclose($file);
		
		echo "successfully output game id to UserProductRatingGameId.csv";
	}
	else
	{
		echo "<html> <body>
			Sorry, could not find product history
			 </body> </html>";
	}
 
 	echo "<html> <body>";
	echo '<pre>';
 
    /*
    // run python script
	$command = 'cd ~/public_html/cgi-bin && ./virtualenv-15.1.0/myVE/bin/python video_game_recommender.py';
	$last_line = system($command, $retval);
 
	// Printing additional info
	echo '
	</pre>
	<hr />The recommended game is: ' . $last_line . '
	<hr />Return value: ' . $retval;
	echo "</body> </html>";
	*/

	mysql_close($link);
?>