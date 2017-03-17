<?php 
//Creates databae connection.
function createConnection()
{
	if (file_exists("../dbinfo/details.txt"))
	{
		$path="../dbinfo/details.txt";
	}
	if (file_exists("../../dbinfo/details.txt"))
	{
		$path="../../dbinfo/details.txt";
	}
	
	if (file_exists($path))
	{
		$fh = fopen($path,"r");
		$user_name = fgets($fh);
		$pwd = fgets($fh);
		fclose($fh);
		$user_name = trim(preg_replace('/\R+/', ' ',$user_name));
		$pwd = trim(preg_replace('/\R+/', ' ',$pwd));
		$db_host = 'webprog.cs.ship.edu';
		$db = 'webprog28';
		$conn = new mysqli($db_host,$user_name,$pwd,$db);
		if ($conn->connect_error) die($conn->connect_error);
		else
		{
			return $conn;
		}
	}
	else 
	{
		die("Db details file not present");
	}
}
?>