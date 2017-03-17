<?php 
/*
 * Retrns the array of size 2 with cordinates, null if not in range 1 to 100.
 * index 0 - row location
 * index 1 - column location
 */
function getCordinates($location)
{
	$location-=1;
	$result[0]=((int) ($location/10));
	$result[1]=$location%10;	
	return $result;
}

//Return the value after sanitizing from the post array.
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}

//Returns distance between two Locations
function getDistance($location1,$location2)
{
	
	$cordnates1=getCordinates($location1);
	$cordnates2=getCordinates($location2);
	$result = 0;
	$result+= abs( $cordnates1[0]-$cordnates2[0]  );
	$result+= abs( $cordnates1[1]-$cordnates2[1]  );
	return $result;
}

/*Checks the avalability of the given location
 * return 
 * 1 location empty
 * 0 location occupied
 */
function checkLocation($conn,$location) {
	$query="select * from planets where planet_location=".$location;
	$result = $conn->query($query);
	if (!$result) die ("Database access failed: " . $conn->error);
	while($row = $result->fetch_assoc())
	{
		return 0;		
	}
	return 1;
}
?>