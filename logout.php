<!DOCTYPE html> 
<HTML> 
<HEAD>  
    <title>logout</title> 
    <meta http-equiv="refresh" content="5;url="> 
</HEAD> 
<body> 
    <br> 
    <?php 
     session_start(); 
     if (isset($_SESSION['user_name'])) 
     { 
         session_start(); 
         $_SESSION = array(); 
         setcookie(session_name(), '', time() - 2592000, '/'); 
         session_destroy(); 
     } 
    header("Location: indexCommon.php"); 
    ?> 
</body> 
</HTML>
