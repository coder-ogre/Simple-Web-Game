<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
<title>Admin Index</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" media="screen" /> 
</head>   
<body>
<div id="centerColumn">
  <div id="navbar">
    <ul>
      <?php include 'header.php';?>
    </ul>
  </div>
  <div id="header"> 
    <h1>Simple Game</h1>
  </div>
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
	
	$query ="update planets set planet_resources=planet_resources+1";
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	
	$query ="UPDATE ships s JOIN planets p ON (p.user_planet_id =s.user_planet_id)".
				" SET s.ship_count = s.ship_count+1 WHERE p.planet_resources = 2";
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	
	$query ="update planets set planet_resources=0 where planet_resources=2";
	$result = $conn->query($query);
	if (!$result)
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	
	$query ="update operation set current_turns=current_turns+1";
	$result = $conn->query($query);
	if (!$result) 
	{
		header("Location: ../error.php?error=".$conn->error);
	}
	else 
	{
		$query ="select * FROM operation where number_of_turns=current_turns and action='MOVE'";
		$result = $conn->query($query);
		if (!$result) 
		{
			header("Location: ../error.php?error=".$conn->error);
		}
		while($row = $result->fetch_assoc())
		{
			$toPlanet = $row['to_planet'];
			$operationId= $row['operation_id'];
			$ships= $row['ships'];
			
			$query="update ships set ship_count=ship_count+".$ships." where user_planet_id=".$toPlanet;
			$result = $conn->query($query);
			if (!$result) die ("Database access failed: " . $conn->error);
			//echo $query;
			$query="delete from operation where operation_id=".$operationId;
			$result1 = $conn->query($query);
			if (!$result1) 
			{
				header("Location: ../error.php?error=".$conn->error);
			}
		}
		//echo "success";
		
		$query ="select * FROM operation where number_of_turns=current_turns and action='ATTACK'";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		while($row = $result->fetch_assoc())
		{
			$toPlanet = $row['to_planet'];
			$operationId= $row['operation_id'];
			$fromShips= $row['ships'];
			$fromPlanet =$row['from_planet'];
			
			$query ="SELECT * FROM ships where user_planet_id=".$toPlanet;
			$result1 = $conn->query($query);
			if (!$result1)
			{
				header("Location: ../error.php?error=".$conn->error);
			}
			while($row1 = $result1->fetch_assoc())
			{
				$toShips=$row1['ship_count'];
			}
			
			if($toShips>=$fromShips)
			{
				$toShips-=$fromShips;
				
				$query ="update ships set ship_count=".$toShips." where user_planet_id=".$toPlanet;
				$result1 = $conn->query($query);
				if (!$result1) die ("Database access failed: " . $conn->error);
				
				$query="delete from operation where operation_id=".$operationId;
				$result1 = $conn->query($query);
				if (!$result1)
				{
					header("Location: ../error.php?error=".$conn->error);
				}
			}
			else 
			{
				$fromShips-=$toShips;
				
				$query ="SELECT * FROM planets where user_planet_id=".$fromPlanet;
				$result1 = $conn->query($query);
				if (!$result1) die ("Database access failed: " . $conn->error);
				while($row1 = $result1->fetch_assoc())
				{
					$fromUser=$row1['user_id'];
				}
				
				$query ="update ships set ship_count=".$fromShips." where user_planet_id=".$toPlanet;
				$result1 = $conn->query($query);
				if (!$result1) 
				{
					header("Location: ../error.php?error=".$conn->error);
				}
				
				$query ="update planets set user_id=".$fromUser." where user_planet_id=".$toPlanet;
				$result1 = $conn->query($query);
				if (!$result1)
				{
					header("Location: ../error.php?error=".$conn->error);
				}
				
				$query="delete from operation where operation_id=".$operationId;
				$result1 = $conn->query($query);
				if (!$result1)
				{
					header("Location: ../error.php?error=".$conn->error);
				}
			}
			
		}
		
		//
		$query ="select user_id from users where  user_type='USER'	and user_id Not in(select distinct(u.user_id) from users u,planets p where p.user_id=u.user_id )";
		$result = $conn->query($query);
		if (!$result)
		{
			header("Location: ../error.php?error=".$conn->error);
		}
		
		while($row = $result->fetch_assoc())
		{
			$query="delete from users where user_id =".$row['user_id'];
			$conn->query($query);
		}
	}
	
	
	header("Location: ../info.php?info=Update Successful");
?>	
</div>
</body>
</html>