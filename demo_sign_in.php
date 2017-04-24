<?php
  session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');
	

  $uname=$_POST["username"];
  $pword=$_POST["password"];

  $sql="SELECT username FROM Users WHERE username='$uname' AND password='$pword'";
  $res = mysql_query($sql);
  
  if(mysql_num_rows($res)){
  	$sql="SELECT user_id FROM Users WHERE username='$uname'";
  	$res = mysql_query($sql);
  	$row = mysql_fetch_object($res);
  	#echo $row->user_id;
  	$_SESSION['user_id'] = $row->user_id;
  	header('Location: pages/product_search.html');
  	exit;
  }
  else{
    echo "<html>
           <body>
             Log-in Unsuccessful
           </body>
         </html>";
  }
  mysql_close($link);
?>
