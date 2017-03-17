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
 <script src="updateUserJs.js"></script>
  <br>
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
  $userId="";
  
  session_start();
  if($_POST['userId'])
  {
  	$userId = get_post($conn, 'userId');
  }
  else 
  {
  	$userId = $_SESSION['modifiedUserId'];
  }
  
  if($userId!=null && $userId!="")
  {
  	
  	$query="SELECT * FROM users where user_type='USER' and user_id=".$userId;
  	$result = $conn->query($query);
  	if (!$result) 
  	{
  		header("Location: ../error.php?error=".$conn->error);
  	}
  	while($row = $result->fetch_assoc())
  	{
  		echo<<<_END
  		<form action="updateUserName.php" onsubmit="return validateName(this)" method="post">
  		<input type="text" name="userId" value="$row[user_id]" hidden="true"> 
  		<table>
  			<tr>
  				<th>User Name</th>
  				<td>
  					<input type="text" name="userName" value="$row[user_name]">
  				</td>
  				<td>
  				<input type="submit" value="Update">
  				</td>
  			</tr>
  		</table>
  		</form>			
_END;
  	}
  	echo<<<_END
  	<table > 
  			<tr> 
  			<th>Location</th> 
  			<th>Planet Resources</th> 
  			<th>Ship Count</th> 
  			<th></th><th></th>
  			</tr>
  			<tr>
  				<form action="addPlanet.php" onsubmit="return validateUserResources(this)" method="post">
  				<input type="text" name="userId" value="$userId" hidden="true">
  				<td>
  					<input type="number" name="location" ">
  				</td>
  				<td>	
  					<input type="number" name="planetResources">
  				</td>
  				<td>
  					<input type="number" name="shipCount">
  				</td>
  				<td colspan=2>
  					<input type="submit" value="Add Planet">
  				</td>
  				</form>
  			</tr>		
_END;
  	$query="SELECT p.user_planet_id,p.user_id,p.planet_location,p.planet_resources,s.ship_count FROM planets p,ships s where p.user_planet_id = s.user_planet_id and p.user_id=".$userId; 
  	$result = $conn->query($query);
  	if (!$result)
  	{
  		header("Location: ../error.php?error=".$conn->error);
  	}
  	while($row = $result->fetch_assoc())
  	{
  		echo<<<_END
  			<tr>
  			<form action="updateUserDetails.php" method="post">
  				<input type="text" name="userId" value="$row[user_id]" hidden="true">
  				<input type="text" name="userPlanetId" value="$row[user_planet_id]" hidden="true">
  					<td>
  						<input type="number" name="location" value="$row[planet_location]">
  					</td>
  					<td>
  						<input type="number" name="planetResources" value="$row[planet_resources]">
  					</td>
  					<td>
  						<input type="number" name="shipCount" value="$row[ship_count]">
  					</td>
  					<td>
  					<input type="submit" value="Update">
  					</td>
  			</form>
  			<form action="deleteUserPlanet.php" onsubmit="return conformDelete()" method="post">
  					<input type="text" name="userId" value="$row[user_id]" hidden="true">
  					<input type="text" name="userPlanetId" value="$row[user_planet_id]" hidden="true">
  					<td>
  							<input type="submit" value="Delete">
  					</td>
  			</form>
  			</tr>
_END;
  	}
  	echo "</table>";
  }
  else 
  {
  	header("Location: ../error.php?error=No data Posted");
  }
  ?>
  
</div>
</body>
</html>
