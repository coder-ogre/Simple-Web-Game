<?php

function getUserType()
{
	session_start();
	if (isset($_SESSION['user_name']) && isset($_SESSION['check']) && isset($_SESSION['user_type']))
	{	
		if ($_SESSION['check'] == hash('ripemd128', $_SERVER['REMOTE_ADDR'] .$_SERVER['HTTP_USER_AGENT']))
		{
			return $_SESSION['user_type'];
		}
		else  
		{
			header("location: logout.php");
		}
	}
	else 
	{
		return "GENERAL";
	}
}  
?>   