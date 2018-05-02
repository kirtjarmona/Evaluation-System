 <?php ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);?>
<?php 
	$host = 'localhost'; 
	$user = 'postgres'; 
	$pass = 'x1kirt'; 
	$port = '5400';
	$db = 'FES'; 
	$conn = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die ("<div style=\"display:block;\"><h3>Could not Connect to Database Server</h3></div>");
 ?>