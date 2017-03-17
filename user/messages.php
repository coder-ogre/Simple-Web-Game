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
  			<td> <textarea  name="message" > </textarea> </td>
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
  if($type!="USER")
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
 	 echo "<tr> <td>".$users[$row['from_whom']]."</td> <td>".$row['message']."</td>  </tr>";
   /*echo<<<MESSAGES
        <tr>
          <form action="messages.php" method="post">
          <td> <input type="text" name="fromUser" value=$users[$row[from_whom]]> </td> 
          <td> <input type="text" name="inMessage" value=$row[message]> </td>
          <td> <input type="submit" name = "delete" value="Delete">       </td>
        </form>
        </tr>   
MESSAGES;*/
  }
  echo "</table>";
  
  /*if( isset($_POST['delete']) ) 
  {     // code to allow products to be deleted
    $messageToDelete= get_post($conn, 'message');
    $productID = get_post($conn, 'productID');  
    $query=$conn->prepare("delete from ".strtoupper($vendor)." WHERE productID = ?");
    $query->bind_param("i", $productID);
    
    $result = $query->execute(); 
    if (!$result) echo "Update failed2: ".$conn->error;
  } 
  function get_post($conn, $var) // code to sanitize data
  { 
    return $conn->real_escape_string($_POST[$var]); 
  }  */
  
  mysql_close($conn);
  ?>
  
  <!--//end #footer//-->
</div>

<!--//end #centerColumn//-->
</body>
</html>
