// global variables
var email_available = false;

// validation for payment gateway page
function oldValidate()
{
	var a = validateName();
	var b = validateEmail();
	var c = validateNumber();
	var d = validateLname();
	var e = validateDate();
	var f = validateGender();
	var g = validateOthers();
	var h = validatePassword();
	var i = validateImg();

	var result = a && b && c && d && e && f && g && email_available && h && i;

	return result;
}

function validateForm()
{
	var a = validateName();
	var b = validateEmail();
	var c = validateNumber();
	var d = validateLname();
	var e = validateDate();
	var f = validateGender();
	var g = validateOthers();
	var h = validatePassword();
	var i = validateImg();

	var result = a && b && c && d && e && f && g && email_available && h && i;

	if(result)
		registerWithJson();
	else
		alert(" Some error in form !");

	return false;

}
// validates image properties
function validateImg(){

	var helpObj = document.getElementById("image_Help");
	var image = document.getElementById("profile_pic").files;


	//image.style.display = "none";
	if(document.getElementById("profile_pic").value != "")
	{
		helpObj.innerHTML = "objects fetched ";
		var maxFileSize = 2048000;
		var fileSize = image[0].size;
		var fileName = image[0].name;
		var arr = fileName.split(".");
		var fileExtension = arr[1];

		if((fileExtension == "jpg" || fileExtension == "png") && fileSize <=maxFileSize && fileSize >0){
			helpObj.innerHTML = "";
			return true;
		}
		else{
			if(fileExtension != "jpg" && fileExtension == "png")
				helpObj.innerHTML = "Invalid image format !";
			if(fileSize>maxFileSize)
				helpObj.innerHTML = "File size should be max. 2MB";
			if(fileSize<=0)
				helpObj.innerHTML = "File size invalid !";
			return false;
		}
	}
	else{
		helpObj.innerHTML = "No file selected";
		return false;
	}

}

// validate other fields
function validateOthers()
{
	var address = document.getElementById('address').value
	var city = document.getElementById('city').value
	var state = document.getElementById('state').value
	var country = document.getElementById('country').value
	var helpObj = document.getElementById('error_report');

	if(address == "" || city =="" || state == "" || country == "" )
	{
		helpObj.innerHTML = "Please fill all fields ";
		return false;
	}
	else
	{
		helpObj.innerHTML = "";
		return true;
	}
}

// seperate validation call for update page to avoid email already used conflict
function validateUpdate(oldEmail)
{
	var a = validateName();
	var b = validateEmailCustom(oldEmail);
	var c = validateNumber();
	var d = validateLname();
	var e = validateDate();
	var f = validateGender();
	var g = validateOthers();

	var result = a && b && c && d && e && f && g  ;

}

// function to validate password
function validatePassword(){
	var password = document.getElementById('password').value;
	var cpassword = document.getElementById('confirmPassword').value;
	var	helpObj = document.getElementById('password_help');

	if(password!="" && cpassword!=""){
		if(password === cpassword){
			if(password.length>=6){
				helpObj.innerHTML = "";
				return true;
			}
			else{
				helpObj.innerHTML = "password too short [6 chars min]";
			}
		}else{
			helpObj.innerHTML = "Password do not match";
		}
	}
	else{
		helpObj.innerHTML = "Please Enter Password";
	}
	return false;
}


function test(msg)
{
	alert("Message  : "+msg);
}

// function validates name , allows only alphabets , no spl syms or space or digits
function validateName()
{
	var name = document.getElementById('fname').value;
	var helpObj = document.getElementById('fname_help');
	var pattern1 = /[!#$%@\s]{1,}/;
	var pattern2 = /[0-9]/;

	if(name != "")
	{
		if(name.length<2)
		{
			helpObj.innerHTML  = " Name must be at least 2 character long !";
			return false;
		}
		else if(pattern1.test(name))
		{
			helpObj.innerHTML = " Special symbols or space not allowed !";
			return false;
		}
		else if(pattern2.test(name))
		{
			helpObj.innerHTML  = " Name can contain alphabets only !";
			return false;
		}
		else
		{
			helpObj.innerHTML = " ";
			return true;
		}
	}
	else
	{
		helpObj.innerHTML = " Name cannot be empty !";
		return false;
	}
}

function validateLname()
{

	var lname = document.getElementById('lname').value;
	var helpObj2 = document.getElementById('lname_help');
	var pattern3 = /[!#$%@\s]{1,}/;
	var pattern4 = /[0-9]/;

	if(lname != "")
	{
		if(lname.length<2)
		{
			helpObj2.innerHTML  = " Name must be at least 2 character long !";
			return false;
		}
		else if(pattern3.test(lname))
		{
			helpObj2.innerHTML = " Special symbols or space not allowed !";
			return false;
		}
		else if(pattern4.test(lname))
		{
			helpObj2.innerHTML  = " Name can contain alphabets only !";
			return false;
		}
		else
		{
			helpObj2.innerHTML = " ";
			return true;
		}
	}
	else
	{
		helpObj2.innerHTML = " Name cannot be empty !";
		return false;
	}
}

// function to validate email , allows only [. _ @]
function validateEmail()
{
	var email = document.getElementById('email').value;
	var helpObj = document.getElementById('email_help');
	var pattern1 = /[!#$%^&*-\s]/;
	var pattern2 = /^\w+([._]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	// /^[a-zA-z0-9]*[.]*[a-zA-z0-9]*[@]{1},[a-zA-z0-9]{1,}[.]{1}[a-zA-z0-9]{0,}/;

	if(email != "")
	{
		if(pattern1.test(email))
		{
			helpObj.innerHTML = " Only . and _ allowed !";
			return false;
		}
		else if(!pattern2.test(email))
		{
			helpObj.innerHTML = " Invalid format !";
			return false;
		}
		else if(!email_available)
		{
			helpObj.innerHTML = " Email Already Taken !";
			return true;
		}
		else
		{
			helpObj.innerHTML = " ";
			return true;
		}
	}
	else
	{
		helpObj.innerHTML = " Email cannot be empty !";
		return false;
	}
}

// email validation for update method
function validateEmailCustom(oldEmail)
{
	var email = document.getElementById('email').value;
	var helpObj = document.getElementById('email_help');
	var pattern1 = /[!#$%^&*-\s]/;
	var pattern2 = /^\w+([._]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	// /^[a-zA-z0-9]*[.]*[a-zA-z0-9]*[@]{1},[a-zA-z0-9]{1,}[.]{1}[a-zA-z0-9]{0,}/;

	if(email != "")
	{
		if(pattern1.test(email))
		{
			helpObj.innerHTML = " Only . and _ allowed !";
			return false;
		}
		else if(!pattern2.test(email))
		{
			helpObj.innerHTML = " Invalid mail format !";
			return false;
		}
		else if(email != oldEmail)
		{
			checkAvailability();
			if(!email_available){
				helpObj.innerHTML = " Email Already Taken !";
				return false;
			}
		}
		else
		{
			helpObj.innerHTML = " ";
			return true;
		}
	}
	else
	{
		helpObj.innerHTML = " Email cannot be empty !";
		return false;
	}
}

// validates number with size>6 , + symbol and digits
function validateNumber()
{
	var contact = document.getElementById('number').value;
	var helpObj = document.getElementById('number_help');
	var pattern1 = /[!#$%@\s-=^&*]{1,}/;
	var pattern2 = /[a-zA-Z]/;

	if(contact != "")
	{

		if(pattern1.test(contact))
		{
			helpObj.innerHTML = "No special symbols allowed !";
			return false;
		}
		else if(pattern2.test(contact))
		{
			helpObj.innerHTML = "Only digits allowed !";
			return false;
		}
		else if(contact.toString().length<7)
		{
			helpObj.innerHTML = "Invalid number length !";
			return false;
		}
		else
		{
			helpObj.innerHTML = "";
			return true;
		}

	}
	else
	{
		helpObj.innerHTML = " Number cannot be empty !";
		return false;
	}
}

// function to validate date
function validateDate()
{
	var date = document.getElementById('datepicker').value;
	var helpObj = document.getElementById('dob_help');
	var pattern = /^([0-9]{2})-([0-9]{2})-([0-9]{4})$/;

	if(date != "")
	{
		if(pattern.test(date))
		{
			var birth = new Date(date);
  			var curr  = new Date();
  			var diff = curr.getTime() - birth.getTime();
   			age = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));

   			if(age<18)
   			{
   				helpObj.innerHTML = "Should be 18 years or older !";
				return false;
   			}
   			else
   			{
   				helpObj.innerHTML = "";
				return true;
   			}


		}
		else
		{
			helpObj.innerHTML = "Invalid Date !";
			return false;
		}
	}
	else
	{
		helpObj.innerHTML = " Please select a date !";
		return false;
	}

}

// validates gender
function validateGender()
{
	var gender = document.forms["myForm"]["gender"].value;
	var helpObj = document.getElementById('gender_help');

	if(gender == "")
	{
		helpObj.innerHTML = " Please Select Gender !";
		return false;
	}
	else
	{
		helpObj.innerHTML = "";
		return true;
	}
}
