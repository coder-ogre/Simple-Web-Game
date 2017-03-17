<?php 
require_once"../dbConnection.php";
require_once"../commonFunctions.php";
require_once"../validation.php";

$type=getUserType();
if($type!="USER")      
{
	header("location: ../indexCommon.php");
}

$conn=createConnection();
session_start();
$userName= $_SESSION["user_name"];
if (isset($_POST['form']) && isset($_POST['to']) && isset($_POST['noShips']) )
{
	$query="SELECT user_id FROM users where user_name='".$userName."'";
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	while($row = $result->fetch_assoc())
	{
		$userId=$row['user_id'];
	}

	$from = get_post($conn, 'form');
	$to = get_post($conn, 'to');
	$noShips = get_post($conn, 'noShips');
	
	$query="select user_id,user_planet_id from planets where planet_location=".$from;
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	while($row = $result->fetch_assoc())
	{
		$formUserId=$row['user_id'];
		$fromUserPlanetId=$row['user_planet_id'];
	}
	
	$query="select user_id,user_planet_id from planets where planet_location=".$to;
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	while($row = $result->fetch_assoc())
	{
		$toUserId=$row['user_id'];
		$toUserPlanetId=$row['user_planet_id'];
	}
	
	if($userId == $formUserId && $userId!= $toUserId)
	{
		$query="select s.ship_count  from  planets p,ships s where p.user_planet_id =s.user_planet_id"
				." and p.planet_location='".$from."'";
		$result = $conn->query($query);
		if (!$result)
		{
			header("Location: ../error.php?error=".$conn->error);
		}
		while($row = $result->fetch_assoc())
		{
			$totalShips=$row['ship_count'];
		}	
		if($noShips<=$totalShips)
		{
			$totalShips-=$noShips;
			
			$distance=getDistance($from, $to);
			
			
			$query="UPDATE ships s JOIN planets p ON (p.user_planet_id =s.user_planet_id) "
					." SET s.ship_count = ".$totalShips." WHERE p.planet_location='".$from."'";
			$result = $conn->query($query);
			if (!$result)
			{
				header("Location: ../error.php?error=".$conn->error);
			}
			
			$query="insert into operation (from_planet,to_planet,number_of_turns,current_turns,action,ships) value "
					."(".$fromUserPlanetId.",".$toUserPlanetId.",".$distance.","."0,'ATTACK',".$noShips.")";
			$result = $conn->query($query);
			if (!$result)
			{
				header("Location: ../error.php?error=".$conn->error);
			}
			header("Location: ../info.php?info=Attack started");
		}
		else 
		{
			header("Location: ../error.php?error=User does not have enough ships to move");
		}
	}
	else
	{
		header("Location: ../error.php?error=To OR From Planet not belong to the user");
	}
}
else
{
	header("Location: ../error.php?error=No data provided");
}

?>