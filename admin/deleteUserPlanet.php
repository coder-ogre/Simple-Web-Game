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

if($_POST['userPlanetId'] && $_POST['userId'])
{
	$query=$conn->prepare("delete from planets where  user_planet_id=?");
	$query->bind_param("i",$userPlanetId);
	$userPlanetId = get_post($conn, 'userPlanetId');
	$userId = get_post($conn, 'userId');
	
	echo $userId."<br>".$userPlanetId;
	$result = $query->execute();

	if (!$result) 
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	else
	{
		session_start();
		$_SESSION['userId']=$userId;
		header("Location: updateUser.php");
	}
}
else 
{
	header("Location: ../error.php?error=No Data Posted");
}
?>