<?php
$servername='127.0.0.1';
$username='nodeclient';
$password='54321';
$conn=mysqli_connect($servername,$username,$password,"users");
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
?>