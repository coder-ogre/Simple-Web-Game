<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
<title>Users</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
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
  <script type="text/javascript">
	function conformDelete() {
		if(confirm('Are you sure you want to delete User?'))
		{
			return ture;
		}
		else
		{
			return false;
		}
	}
  </script>
  <br>
  <?php 
   require_once"../dbConnection.php";
   require_once"../validation.php";
   
   $type=getUserType();
   if($type!="ADMIN")
   {
   	header("location: ../indexCommon.php");
   }
   
  $conn=createConnection();
 
  echo "<table border='1px'>
		<tr align='center'>
        <th>Name</th>
		<th>Options</th>
        </tr>";
    
  $query="SELECT * FROM users where user_type='USER'";
  $result = $conn->query($query);
  if (!$result) 
  {
  	header("Location: ../error.php?error=".$conn->error);
  }
  while($row = $result->fetch_assoc())
  {
  	echo<<<_END
		<tr align='center'>
    		<td>$row[user_name]</td>
  			<td>
  				<br>
  				<form action="updateUser.php" method="post">
  				<input type="text" name="userId" hidden="true" value="$row[user_id]">
  				<input type="submit" value="Update" >
  				</form>
  				<form action="deleteUser.php" onsubmit="return conformDelete()" method="post">
  				<input type="text" name="userId" hidden="true" value="$row[user_id]">
  				<input type="submit" value="Delete" >
  				</form>
  			</td>
		</tr>
_END;
  }
  echo "</table>";
  
  mysql_close($conn);
  ?>
  <br>	
  <!--//end #footer//-->
</div>

<!--//end #centerColumn//-->
</body>
</html>
