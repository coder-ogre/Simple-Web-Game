<?php
	require_once"../dbConnection.php";
	require_once"../commonFunctions.php";
	require_once"../validation.php";
	  
	$type=getUserType();
	if($type!="ADMIN") 
	{
		header("location: ../indexCommon.php"); 
	}
	$conn=createConnection();

	if($_POST['userId'])
	{
		$query=$conn->prepare("delete from users where user_id=?");
		$query->bind_param("i",$userId);
		$userId = get_post($conn, 'userId');
		$result = $query->execute();
		
		if (!$result) 
		{
			header("Location: ../error.php?error=".$conn->error);
		}
		else 
		{
			header("Location: ../info.php?info=User Deleted");
		}
	}
?>