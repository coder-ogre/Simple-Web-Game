<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
<title>Admin Index</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>
<body>
<script>
    function validate(form)
    {
      fail="";
      fail = validate_user(form.user_name.value);
      fail += validate_password(form.password.value);
      
      if (fail == "")  
                return true; 
            else 
            { 
                alert(fail); 
                return false; 
            }
    }
  
    function validate_user(field)
    {
      if(field == "") 
          return "No username was entered you must enter username!.\n";
        else if(field.length > 6)
        return "Usernames must be less than 7 characters.\n"
        return "";
    }
    
    function validate_password(field)
    {
      if(field == "") 
          return "Enter your password!.\n";
            return "";
    }
    
  </script>
<div id="centerColumn">
  <div id="navbar">
    <ul>
      <li><a href="registration.php">Register</a></li>
    </ul>
  </div>
  <div id="header">
    <h1>Simple Game</h1>
  </div>
<br>
 <?php 
 	require_once"validation.php";
 	$type=getUserType();
 	if($type=="ADMIN")
 	{
 		header("location: admin/adminIndex.php");
 	}
 	else if($type=="USER")
 	{
 		header("location: user/userIndex.php");
 	}
 ?>
  <br>
  <form action="login.php" method="post" onsubmit="return validate(this)"> 
        <table> 
            <tr> 
                <td>User Name:</td> 
                <td><input type="text" name="user_name" placeholder="username"></td> 
            </tr> 
            <tr> 
                <td>Password:</td> 
                <td><input type="password" name="password" placeholder="**********"></td> 
            </tr> 
            <tr> 
                <td colspan="2"> <input type="submit" value="Login" onclick="validate()"> </td> 
            </tr> 
        </table> 
    </form>
    <br>
</div>
</body>
</html>
