<html>
<body>
<h3>
<?php
echo '<pre>';

// Outputs all the result of shellcommand "ls", and returns
// the last output line into $last_line. Stores the return value
// of the shell command in $retval.
//$command = 'cd ./cgi-bin && python pytest.py';
$command = 'cd ./cgi-bin && ./virtualenv-15.1.0/myVE/bin/python video_game_recommender.py';
$last_line = system($command, $retval);

// Printing additional info
echo '
</pre>
<hr />The recommended game is: ' . $last_line . '
<hr />Return value: ' . $retval;
?>
</h3>
</body>
</html>