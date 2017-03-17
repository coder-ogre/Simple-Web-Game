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

if (isset($_POST['userId']) && isset($_POST['userName']) )
{
	$userId = get_post($conn, 'userId');
	$useName= get_post($conn, 'userName');
	
	$query="update users set user_name ='".$useName."' where user_id=".$userId;
	
	$result = $conn->query($query);
	
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	else
	{
		session_start();
		$_SESSION['modifiedUserId']=$userId;
		header("Location: updateUser.php");
	}
}
?> 