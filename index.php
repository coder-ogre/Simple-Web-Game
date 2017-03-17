<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
<title>Welcome to Simple Game!</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>
<body>
<div id="centerColumn">
  <div id="navbar">
    <ul>
      <li><a href="indexCommon.php">Login</a></li>
      <li><a href="registration.php">Register</a></li>
    </ul>
  </div>
  <div id="header">
    <h1>Simple Game</h1>
  </div>
  <br>
  <div>
    <p>
      Welcome to the simple web game, Simple Game!  <br /><p>Use the nav bars at the top of the page to register, or if you already have an account, to log in.</p>
    </p>
  </div>
  <?php 
   	require_once"../validation.php";
   	require_once"../dbConnection.php";
   	$type=getUserType();
   	if($type=="USER")
   	{
   		header("location: ./user/userIndex.php");
   	}
    if($type=="ADMIN")
   	{
   		header("location: ./admin/adminIndex.php");
   	}
  ?>
</body>
</html> 