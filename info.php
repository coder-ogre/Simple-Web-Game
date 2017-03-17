<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
<title>Admin Index</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="refresh" content="5;url=indexCommon.php" />
</head>
<body>
<div id="centerColumn">
  <div id="navbar">
  </div>
  <div id="header">
    <h1>Simple Game</h1>
  </div>
  <br>
	<?php 
  	if(isset($_GET['info']))
  	{
  		echo "<h3>".$_GET['info']."</h3>";
  		echo "page redirects in 5 sec.<br>";
  	}
  
  ?>
  <!--//end #footer//-->
</div>

<!--//end #centerColumn//-->
</body>
</html>

