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

if (isset($_POST['userId']) && isset($_POST['userPlanetId']) && isset($_POST['location']) && isset($_POST['planetResources']) && isset($_POST['shipCount']) )
{
	$userId = get_post($conn, 'userId');
	$userPlanetId= get_post($conn, 'userPlanetId');
	$location= get_post($conn, 'location');
	$planetResources= get_post($conn, 'planetResources');
	$shipCount =get_post($conn, 'shipCount');
	
	$query="update ships set ship_count=".$shipCount." where user_planet_id=".$userPlanetId;
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	else
	{
		$query="update planets set planet_resources=".$planetResources.",planet_location=".$location." where user_planet_id=".$userPlanetId;
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
}

?>