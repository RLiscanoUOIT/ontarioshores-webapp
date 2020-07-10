<?php
/*for heroku db */
$con=mysqli_connect ("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6") or die ('I cannot connect to the database because: ' . mysql_error());
mysqli_select_db ($con,'heroku_dbefbfd5b04ac35');
?>
