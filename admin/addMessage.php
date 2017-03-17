<?php    
require_once"../dbConnection.php";
require_once"../commonFunctions.php"; 
require_once"../validation.php";

	$type=getUserType();
	if($type!="ADMIN")
	{
		header("location: ../indexCommon.php");
	}
    $conn = createConnection();
    session_start();
    if ($conn)
    {
        insert($conn);
    }
    else
        die ("Database access failed: ");
      
    function insert($conn)
    {
        if (isset($_POST['to_user']) && isset($_POST['message']))
        {
        	    $userName= $_SESSION["user_name"];
            	$query="SELECT user_id FROM users where user_name='".$userName."'";
            	$result = $conn->query($query);
            	if (!$result)
            	{
            		header("Location: ../error.php?error=".$conn->error);
            	}
            	while($row = $result->fetch_assoc())
            	{
            		$fromId=$row['user_id'];
            	}
              
             
            	$query="SELECT user_id FROM users where user_name='".get_post($conn, 'to_user')."'";
            	$result = $conn->query($query);
            	if (!$result)
            	{
            		header("Location: ../error.php?error=".$conn->error);
            	}
            	while($row = $result->fetch_assoc())
            	{
            		$toId=$row['user_id'];
            	}
             $query = $conn->prepare("INSERT INTO messages(from_whom, to_whom, message,message_date) VALUES(?, ?, ?,sysdate())");
             $query->bind_param("iis",$from,$to_user,$message);
             $from = $fromId; 
             $to_user = $toId; 
             $message = get_post($conn, 'message');
             $result = $query->execute();
             if (!$result)
             {
             	header("Location: ../error.php?error=".$conn->error);
             }
             header("Location: ../info.php?info=Message Sent");
        }    
    }
            $conn->close();
?>