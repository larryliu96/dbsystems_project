<html>
<body>
    <h2>
	<?php
	 	echo "<p>";
		// define variables and functions
        $servername = "webhost.engr.illinois.edu";
        $username = "dbsystems_hanjinh2";
        $password = "hanjinh2";
        $dbname = "dbsystems_test";
        $tablename = "Product";

        function printRowNum($res){
            if (mysql_num_rows($res)>0){
                print("<p>There are " . mysql_num_rows($res) . " result(s) available</p>" . "<br/>");
            } else {
                echo "failed!<br/>";
            }
        }


        // get date
        date_default_timezone_set("America/New_York");
        echo date("Y/m/d") . " " . date("l") . " " . date("h:i:sa") . "<br><br>";


        // connect to database
        $link = mysql_connect($servername, $username, $password);

        if (!$link) {
            die('Could not connect: ' . mysql_error());
            exit;
        } else {
            echo "Connect to database successfully!<br/>";
        }
        printf("MySQL host info: %s\n <br>", mysql_get_host_info());
        printf("MySQL client info: %s\n <br>", mysql_get_client_info());
        printf("MySQL proto info: %s\n <br>", mysql_get_proto_info());
        printf("MySQL server info: %s\n <br>", mysql_get_server_info());
	    	
        $status = explode('  ', mysql_stat($link));
	print_r($status);
	    	
        echo "<br>";
        echo "<br>";


        // get all the databases
        $db_list = mysql_list_dbs($link);

		$i = 0;
		$cnt = mysql_num_rows($db_list);
		
		if ($cnt>0) {
		 	echo "list of databases are: <br>";
			while ($i < $cnt) {
			    echo mysql_db_name($db_list, $i) . "<br/>";
			    $i++;
			}
		}
		echo "<br>";
	    	

		// select a database
        if (!mysql_select_db($dbname)) {
			echo "Unable to select mydbname: " . mysql_error();
			exit;
        } else {
			echo "Select database successfully!<br/>";
	    }
		echo "<br/>";


		// check how many tuples in the table
		$sql="SELECT * FROM $tablename";
		$result=mysql_query($sql);
	
		if (!$result) {
			echo "Could not successfully run query ($sql) from DB: " . mysql_error();
			exit;
		} else {
			echo "Query table successfully!<br/>";
		}

		printRowNum($result);


		// add a new tuple
		$sql1="INSERT INTO $tablename (`Item_ID`, `Item_Name`, `Img_ID`, `Department_ID`, `Item_Price`) VALUES ('1958', 'Book', '5', '200', '75.2');";       
		$result=mysql_query($sql1);
		
		if (!$result) {
    			echo "Cannot add this tuple.<br/>";
   		} else {
   			echo "Add the tuple successfully!<br/>";
   		}

		$sql="SELECT * FROM $tablename";
		$result=mysql_query($sql);
		
		if (!$result) {
			echo "Could not successfully run query ($sql) from DB: " . mysql_error();
			exit;
		} else {
			echo "Query table successfully!<br/>";
		}

		printRowNum($result);
		
		
       
        // get all the item name
        // While a row of data exists, put that row in $row as an associative array
		// Note: If you're expecting just one row, no need to use a loop
		// Note: If you put extract($row); inside the following loop, you'll
		//       then create $userid, $fullname, and $userstatus
		while ($row = mysql_fetch_assoc($result)) {
            echo $row["Item_ID"] . ": " . $row["Item_Name"] . ": " . $row["Img_ID"] . ": " . $row["Department_ID"] . ": " . $row["Item_Price"] . "<br/>";
		}
		echo "<br/>";


        // close connection
		mysql_free_result($result);
		mysql_close();
            
            
        // open a file in cPanel.FileManager.public_html
        $fileurl="LICENSE.txt";
        $myfile = fopen($fileurl, "r") or die("Unable to open file!");
        echo "The first line is " . fgets($myfile);
		//echo fread($myfile,filesize($fileurl));
		fclose($myfile);
		
		echo "</p>";
	?>
    </h2>
</body>
</html>