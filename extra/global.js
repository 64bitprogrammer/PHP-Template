function validateForm()
{
	var fname = document.getElementById('fname').value;
	var lname = document.getElementById('lname').value;
	var email = document.getElementById('email').value;
	var dob = document.getElementById('datepicker').value;
	
	var gender = document.forms["myForm"]["gender"].value;
	var contact = "xyz";
	contact = document.getElementById('contact').value;
	var address = document.getElementById('address').value;
	var city = document.getElementById('city').value;
	var state = document.getElementById('state').value;
	var country = document.getElementById('country').value;
	
	//alert(fname+lname+email+dob+gender+contact+address+city+state+country);
	

	var letters = /^[A-Za-z]+$/;
	
	if(!fname.match(letters) || fname.length == 0)
	{
		document.getElementById('error_report').innerHTML = "First Name can contain alphabets only !";
		clearSuccessMessage();
		return false;
	}
	else if(!lname.match(letters) || lname.length == 0)
	{
		document.getElementById('error_report').innerHTML = "Last Name Can can contain alphabets only !";
		clearSuccessMessage();
		return false;
	}
	else if()
	{
		document.getElementById('error_report').innerHTML = "Check Positions of '@' and '.' in Email !";
		clearSuccessMessage();
		return false;
	}
	else if(!city.match(letters))
	{
		document.getElementById('error_report').innerHTML = "City can contain alphabets only !";
		clearSuccessMessage();
		return false;
	}
	else if(!state.match(letters))
	{
		document.getElementById('error_report').innerHTML = "State can contain alphabets only !";
		clearSuccessMessage();
		return false;
	}
	else if(!country.match(letters))
	{
		document.getElementById('error_report').innerHTML = "Country can contain alphabets only !";
		clearSuccessMessage();
		return false;
	}
	else if(contact.length != 10)
	{
		document.getElementById('error_report').innerHTML = "Mobile number must be 10 digits long !";
		clearSuccessMessage();
		return false;
	}
	else
	{
		document.getElementById('error_report').innerHTML = "";
		clearSuccessMessage();
	}

	
	return false;
}

function clearSuccessMessage()
{
	document.getElementById('success_report').innerHTML = "";
}