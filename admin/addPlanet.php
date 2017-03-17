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

if (isset($_POST['userId']) && isset($_POST['location']) && isset($_POST['planetResources']) && isset($_POST['shipCount']) )
{
	$userId = get_post($conn, 'userId');
	$location= get_post($conn, 'location');
	$planetResources= get_post($conn, 'planetResources');
	$shipCount =get_post($conn, 'shipCount');
	
	if(checkLocation($conn, $location) == 1)
	{
		$query="insert into planets (user_id,planet_location,planet_resources) value(";
		$query=$query.$userId.",".$location.",".$planetResources.")";
		$result = $conn->query($query);
		if (!$result)
		{
			header("Location: ../error.php?error=".$conn->error);
		} 
		else
		{
			$query="select * from planets where planet_location=".$location;
			$result = $conn->query($query);
			//echo $query."<br>";
			if (!$result) 
			{
				header("Location: ../error.php?error=".$conn->error);
			}
			while($row = $result->fetch_assoc())
			{
				$userPlanetId= $row['user_planet_id'];
			}
			//echo $userPlanetId;
			
			$query="insert into ships (user_planet_id,ship_count) value(".$userPlanetId.",".$shipCount.")";
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
	else
	{
		header("Location: ../error.php?error=The planet Location is not empty");
	}
	
}
?>