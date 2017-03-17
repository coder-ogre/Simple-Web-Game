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
  <br>
  <form action="addMessage.php" method="post">
  	<table>
  		<tr>
  			<td> To </td>
  			<td> <input type="text" name="to_user" > </td>
  		</tr>
  		<tr>
  			<td> Message </td>
  			<td> <textarea  name="message"> </textarea> </td>
  		</tr>
  		<tr>
  			<td colspan="2"> <input type="submit" name="Send Message"> </td>
  		</tr>
  	</table>
  </form>
  <br>
  <?php 
  require_once"../dbConnection.php";
  require_once"../validation.php";
  
  $type=getUserType();
  if($type!="ADMIN")
  {
  	header("location: ../indexCommon.php");
  }
  
  session_start();
  $conn=createConnection();
  
  $userName= $_SESSION["user_name"];
  $query="SELECT * FROM users";
  $result = $conn->query($query);
  if (!$result) 
  {
  	header("Location: ../error.php?error=".$conn->error);
  }
  while($row = $result->fetch_assoc())
  {
  	$users[$row['user_id']]=$row['user_name'];
  	if($row['user_name']==$userName)
  		$userId=$row['user_id'];
  }
  
  
  $query="select from_whom,message from messages where to_whom=".$userId." order by message_date desc";
  $result = $conn->query($query);
  if (!$result)
  {
  	header("Location: ../error.php?error=".$conn->error);
  }
  
  echo "<table border='1px'>";
  echo "<tr> <th>Message From</th> <th>Message</th> </tr>";
  while($row = $result->fetch_assoc())
  {
  	echo "<tr> <td>".$users[$row['from_whom']]."</td> <td>".$row['message']."</td></tr>";
  }  
  echo "</table>";
  mysql_close($conn);
  ?>
  
  <!--//end #footer//-->
</div>

<!--//end #centerColumn//-->
</body>
</html>
