<!DOCTYPE html> 
<HTML>  
<HEAD> 
    <title></title> 
</HEAD> 
<body> 
    <?php 
        //Sets 30 min time out. 
        ini_set('session.gc_maxlifetime', 1800); 
        session_start(); 
        //Connect to database. 
        include('dbConnection.php');
		    $conn = createConnection();
	    	if (!$conn) die ("Database access failed: "); 
        //echo "connected"; 
		
		    if (isset($_SESSION['user_name'])) 
        { 
            if ($_SESSION['check'] != hash('ripemd128', $_SERVER['REMOTE_ADDR'] .$_SERVER['HTTP_USER_AGENT'])) 
            { 
                header("Location: logout.php"); 
            } 
        } 
        else 
        { 
            if (isset($_POST['user_name']) && isset($_POST['password']) ) 
            { 				
                $user_name=get_post($conn, 'user_name'); 
                $password=get_post($conn, 'password'); 
                $salt1 = "qm&h*"; 
                $salt2 = "pg!@"; 
                $userGiven = hash('ripemd128', "$salt1$password$salt2"); 
                $query = "SELECT password,user_type FROM users WHERE user_name='$user_name'"; 
                $result = $conn->query($query); 
                if (!$result) die($conn->error); 
                $password="";
                $user_type="";
                while($row = $result->fetch_assoc()) 
                { 
                   $password=$row['password']; 
                   $user_type=$row['user_type'];
                }
               
                echo "pass:".$password."<br>";
                echo "type:".$userGiven."<br>";
                
                if($password==$userGiven) 
                { 
                    $_SESSION['user_name'] = $user_name; 
                    $_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] .$_SERVER['HTTP_USER_AGENT']);
                    $_SESSION['user_type']=$user_type;
                    
                    header("location: indexCommon.php");
                }
                else 
                { 
                    header("Location: error.php?error=your password or username is wrong");         
                } 
                 
            } 
            else 
            { 
                header("Location: error.php?error=you are not allow to access this page"); 
            }   
            }  
		
	    	//Return the value after sanitizing from the post array. 
        function get_post($conn, $var) 
        { 
            return $conn->real_escape_string($_POST[$var]); 
        }
   
    ?>     
</body> 
</HTML>
