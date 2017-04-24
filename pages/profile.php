<?php
	session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'dbsystems_kodeswa2', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('dbsystems_test');


	$action = $_GET['action'];
	if($action == 'username'){
		$new_uname = $_POST['new_uname'];
		$uid = $_SESSION['user_id'];
		$sql = "UPDATE Users SET username='$new_uname' WHERE user_id='$uid'";
		$res = mysql_query($sql);
	}
	if($action == 'email'){
		$new_email = $_POST['new_email'];
		$uid = $_SESSION['user_id'];
		$sql = "UPDATE Users SET email='$new_email' WHERE user_id='$uid'";
		$res = mysql_query($sql);
	}
	if($action == 'password'){
		$old_pword = $_POST['old_pword'];
		$uid = $_SESSION['user_id'];
		$sql = "SELECT password FROM Users WHERE user_id='$uid'";
		$res = mysql_query($sql);
		$row = mysql_fetch_object($res);
		if($old_pword != $row->password){
			echo "Incorrect Password";
		}
		else{
			$new_pword1 = $_POST['new_pword1'];
			$new_pword2 = $_POST['new_pword2'];
			if($new_pword1 == $new_pword2){
				$sql = "UPDATE Users SET password='$new_pword1' WHERE password='$old_pword'";
				$res = mysql_query($sql);
			}
			else{
				echo "The passwords you entered are not the same";
			}
		}
			
	}
  mysql_close($link);
?>