<?php 
  ob_start();// keeps output from being displayed, while still allowing functions to perform
  include_once "dbConnection.php"; // provides code to establish a connection to my database
  $conn = createConnection();// establishes a connection to my database
  ob_end_clean(); // end of output restriction.  things will be able to be output normally
  
  
  $fail = $username = $password = $usertype = "";
  
  if(isset($_POST['username']))
    $username = fix_string($_POST['username']);
  if(isset($_POST['password']))
    $tempPassword = fix_string($_POST['password']);
  if(isset($_POST['userType']))
    $usertype = fix_string($_POST['userType']);
  
  $fail = validate_username($username);
  $fail .= validate_password($tempPassword); 
  
  $salt1 = "qm&h*";
  $salt2 = "pg!@";
  $password = hash('ripemd128', "$salt1$tempPassword$salt2");
  
  echo "<!DOCTYPE html>\n<html><head><title>An Example Form</title>";
  
  if($fail == "")
  {
    echo "</head><body>Form data successfully validated for $username.<br />";
    
    // Enter the posted fields into the database here.
    // Use hash encryption for the password.
    $outputString = "";
    
    $query = $conn->prepare("INSERT INTO users(user_name, password, user_type) VALUES(?,?,?)");
      $query->bind_param('sss', $username, $password, $usertype);
      $result = $query->execute();
      if (!$result) $outputString = $outputString."Addition to userbase failed: ".$conn->error."<br />";
      else
      $outputString = $outputString."User has been successfully added to the database.<br />";
      
      if($usertype == "USER")
      {
        $OnOrOff = 1;
      for($counter = 0; $counter < 100; $counter++)
      {
        $alreadyUsed[$counter] = 0; // initializes all locations to being not used
      }
      
      $result = $conn->query("SELECT * FROM planets");
      if (!$result) die ("Database access failed: ".$conn->error);
      while($row = $result->fetch_assoc())
      {                               /// finds out which planet locations ARE used, and marks them as such
        $alreadyUsed[$row[user_planet_id]] = 1;
      }
      
      
      $candidate = rand(0, 99);
      while($onOrOff == 1)
      {
        if($alreadyUsed[$candidate] == 1)
        {
          $candidate = rand(0, 99);
        }
        else
        {
          $onOrOff == 0;
        }
      }
      // everything up there ^^ is error-free, error is down here
      $result = $conn->query("SELECT * FROM `users` WHERE `user_name` = '$username'");
      if (!$result) die ("Database access failed: " . $conn->error);
      while($row = $result->fetch_assoc())
      {                           
        $theUserId = $row[user_id];
      }
      
      $result = $conn->query("SELECT * FROM `planets` WHERE `user_id` = '$theUserId'");
      if (!$result) die ("Database access failed: " . $conn->error);
      while($row = $result->fetch_assoc())
      {                     
        $alreadyUsed[$row[user_planet_id]] = 1;
      }
      $thePlanetLocation = $candidate;
      $theResources = 1;
      $query = $conn->prepare("INSERT INTO planets(user_id, planet_location, planet_resources) VALUES(?,?,?)");
      $query->bind_param('sss', $theUserId, $thePlanetLocation, $theResources);
      $result = $query->execute();
      if (!$result) $outputString = $outputString."Update failed: ".$conn->error."<br />";
      else
      $outputString = $outputString."A planet has been successfully added to the database.<br />";
      
      
      $result = $conn->query("SELECT * FROM `planets` WHERE `user_id` = '$theUserId'");
      if (!$result) die ("Database access failed: " . $conn->error);
      while($row = $result->fetch_assoc())
      {                           
        $thePlanetId = $row[user_planet_id];
      }
      $theShipCount = 1;
      $query = $conn->prepare("INSERT INTO ships(user_planet_id, ship_count) VALUES(?,?)");
      $query->bind_param('ii', $thePlanetId, $theShipCount);
      $result = $query->execute();
      if (!$result) $outputString = $outputString."Update failed: ".$conn->error." No ship added.";
      else
      $outputString = $outputString."A ship has been successfully added to the database.<br />";
      }
    ////////////////////// end of code to add user, with associated planet and ship to the database
    
    header("Location: ./info.php?info=".$outputString);//redirects to info.php
    
    exit;
  }
  else
  {
    echo "</head><body>An unexpected error has occured during the registration process:<br />";
    echo $fail;
  } 
  
  function validate_username($field)
  {
    $minLength = 2;
    if($field == "") return "No username was entered<br />";
    else if (strlen($field) < $minLength)
      return "$field is not at least $minLength characters long; it is only ".strlen($field)."characters long.<br />";
    else if(preg_match("/[^a-zA-Z0-9_-]/", $field))
      return "Only letters, numbers, - and _ in usernames<br />";
    return "";
  }
  
  function validate_password($field)
  {
    if($field == "") return "No password was entered<br />";
    else if(strlen($field) < 6)
      return "Passwords must be at least 6 characters<br />";
    else if(!preg_match("/[a-z]/", $field) ||
            !preg_match("/[A-Z]/", $field) ||
            !preg_match("/[0-9]/", $field))
      return "Passwords require of each of a-z, A-Z, and 0-9<br />";
    return "";
  }
  
  function fix_string($string)
  {
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return htmlentities($string);
  }
  
?>