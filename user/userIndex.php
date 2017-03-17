<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>User Index</title>   
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
 	require_once"../validation.php";
 	require_once"../dbConnection.php";
 	$type=getUserType();
 	if($type!="USER")
 	{
 		header("location: ../indexCommon.php");
 	}
 	$conn=createConnection();
 	
 	$query="SELECT  u.user_name,p.planet_location,p.planet_resources,s.ship_count " 
			." from users u,planets p,ships s where u.user_id=p.user_id "
			." and p.user_planet_id=s.user_planet_id and u.user_type='USER' order by planet_location";
 	$result = $conn->query($query);
 	if (!$result)
 	{
 		header("Location: ../error.php?error=".$conn->error);
 	}
 	$count = 1;
 	echo "<table border='1px'> <tr align='center'>";
 	while($row = $result->fetch_assoc())
  	{
  		for( ;$count<$row['planet_location'];$count++)
  		{
  			echo "<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <br> ".$count."| 0 | 0 </td>";
  			if($count%10==0)
  				echo "</tr><tr align='center'>";
  		}
  		//data
  		echo "<td><b>".$row['user_name']."</b> <br> ".$count."| ".$row['planet_resources']." | ".$row['ship_count']." </td>";
  		if($count %10 ==0)
  			echo "</tr><tr align='center'>";
  		$count++;
  	}
  	for( ;$count<=100;$count++)
  	{
  		echo "<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <br> ".$count."| 0 | 0 </td>";
  		if($count%10==0)
  			echo "</tr><tr align='center'>";
  	}
 	echo "</tr> </table>";
 	
 ?>
 <p>
 	Format:<br>
 	user Name<br>
 	Location | Resources | Ships<br>
 </p>
 <br>
 	<table>
		<tr>
			<th>Form Planet</th>
			<th>To Planet</th>
			<th>No of Ships</th>
			<th>Action</th>
		</tr>
		<tr>
			<form action="moveShips.php" method="post" onsubmit="return validate(this)">
				<td><input type="number" name="form"></td><!--from and to are 1 to 100-->
				<td><input type="number" name="to"></td>
				<td><input type="number" name="noShips"></td><!--this should be 1 or more, not 0, and not negative.-->
				<td><input type="submit" value="Move Ships"></td><!-- drew - creating javascript validation to ensure these are set properly-->
			</form>	
		</tr>
		<tr>
			<form action="AttackPlanet.php" method="post" onsubmit="return validate(this)">
				<td><input type="number" name="form"></td>
				<td><input type="number" name="to"></td>
				<td><input type="number" name="noShips"></td>
				<td><input type="submit" value="Attack Ships"></td>
			</form>	
		</tr>
	</table>
</div>
<script>
    function validate(form) // validation done by Drew
    {
      fail  = validateFrom(form.form.value)
      fail += validateTo(form.to.value)
      fail += validateNumShips(form.noShips.value)
      
      if (fail == "") 
          return true;
      else {alert(fail); return false }
    }
    
    function validateFromfield)
    {
      if(field == "") return "No from-integer was entered.\n"
      else if(field < 1)
        return "From-values must be from 1 to 100.\n"
      else if(field.length > 100)
        return "From-values must be from 1 to 100.\n"
      else if(/[^0-9]/.test(field))
        return "Only integer values are accepted."
      return ""
    }
    
    function validateTo(field)
    {
      if(field == "") return "No to-integer was entered.\n"
      else if(field < 1)
        return "To-values must be from 1 to 100.\n"
      else if(field.length > 100)
        return "To-values must be from 1 to 100.\n"
      else if(/[^0-9]/.test(field))
        return "Only integer values are accepted."
      return ""
    }
    
    function validateNumShips(field)
    {
      if(field == "") return "No to-integer was entered.\n"
      else if(field < 1)
        return "Number of ships must be at least 1.\n"
      else if(/[^0-9]/.test(field))
        return "Only integer values are accepted."
      return ""
    }
  </script>
</body>
</html> 