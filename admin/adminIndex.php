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
 	require_once"../validation.php";
 	$type=getUserType();
 	if($type!="ADMIN")
 	{
 		header("location: ../indexCommon.php");
 	}
 ?>
  <br>
  <form action="nextTurn.php" >
  	<center>
  		<input type="submit" value="Next Turn">
  	</center>
  </form>
  <!--//end #footer//-->
</div>

<!--//end #centerColumn//-->
</body>
</html> 
