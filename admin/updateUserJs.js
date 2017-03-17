function validateName(form)
{
	fail  =  validateUsername(form.userName.value)
	if (fail == "")  
		return true; 
	else 
	{ 
		alert(fail); 
		return false; 
	}
}
 
 function validateUsername(field)
 {
   if(field == "") return "No username was entered.\n"
   else if(field.length < 2)
	 return "Usernames must be at least 2 characters.\n"
   else if(field.length > 6)
	 return "Usernames must be less than 7 characters.\n"
   else if(/[^a-zA-Z0-9_-]/.test(field))
	 return "Only a-z, A-Z, 0-9, - and _ allowed in usernames.\n"
   return ""
 }


function validateUserResources(form) 
{

	fail="";
	fail+=validateLocation(form.location.value);
	fail+=validatePlanetResources(form.planetResources.value);
	fail+=validateShipCount(form.shipCount.value);
	
	if (fail == "")  
		return true; 
	else 
	{ 
		alert(fail); 
		return false; 
	} 
}

function validateShipCount(field)
{
	if (field == "")  
		return "No value entered for Ship Count\n";
	if(/^\d+$/.test(field)) 
	{ 
	   if(field <0) 
	   { 
		   return "Ship Count can not be negative\n"; 
	   } 
	   else 
	   { 
		   return ""; 
	   } 
	} 
	else 
	{ 
		return "Ship Count should be positive Integers only\n"; 
	} 
}

function validatePlanetResources(field)
{
	if (field == "")  
		return "No value entered for Planet Resources\n"; 
	if(/^\d+$/.test(field)) 
	{ 
	   if(field <0) 
	   { 
		   return "Planet Resources can not be negative\n"; 
	   } 
	   else 
	   { 
		   return ""; 
	   } 
	} 
	else 
	{ 
		return "Planet Resources should be positive Integers only\n"; 
	} 
}

function validateLocation(field)
{
	if (field == "")  
		return "No value entered for Planet Location\n"; 
	if(/^\d+$/.test(field)) 
	{ 
	   if(field <1 || field>100) 
	   { 
		   return "Planet Location should be between 1 to 100\n"; 
	   } 
	   else 
	   {
		   return "";
	   } 
	} 
	else 
	{ 
		return "Planet Location should be positive Integers only\n"; 
	} 
}

function conformDelete() 
{
	if(confirm('Are you sure you want to delete User?'))
	{
		return ture;
	}
	else
	{
		return false;
	}
}
	
	