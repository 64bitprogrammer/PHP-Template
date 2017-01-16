// global variables
var email_available = false;

// function to display imageName
function setImage()
{
	test('hi');
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
}

// function to load the state from db dynamically
function loadState(country_id,oldStateId)
{
	$.ajax({
	type: "POST",
	url: "getState.php",
	data:'Country_ID='+country_id+'&State_ID='+oldStateId,
	success: function(data){
		$("#state").html(data);
	},
	error:function (data){
		$("#error_report").html(data);
    }

	});
}

function test(msg)
{
	alert("Message  : "+msg);
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

	return result;;
}



// function to check for email availability via ajax
function checkAvailability()
{

  jQuery.ajax({
      url: "check_email.php",
      data:'emailID='+$("#email").val(),
      type: "POST",
      success:function(data){
        //$("#error_report").html(data);
        if(data == "available")
        {
          $("#email_help").html("");
          email_available = true;
        }
        else
        {
          $("#email_help").html("Email Already Exists !");
          email_available = false;
        }
      },
      error:function (data){
          alert("ajax error");
      }
    });
}


// function for city state validation
function getState(val)
{
	$.ajax({
	type: "POST",
	url: "getState.php",
	data:'Country_ID='+val,
	success: function(data){
		$("#state").html(data);
	},
	error:function (data){
		$("#error_report").html(data);
    }

	});


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

	var result = a && b && c && d && e && f && g && email_available && h;

	return result;

}
