// function to load the state from db dynamically

function registerWithJson(){
	var firstName = document.getElementById('fname').value;
	var lastName = document.getElementById('lname').value;
	var userEmail = document.getElementById('email').value;
	var userPassword = document.getElementById('confirmPassword').value;
	var userDob = document.getElementById('datepicker').value;
	var userGender = document.forms["myForm"]["gender"].value
	var userNumber = document.getElementById('number').value;
	var userAddress = document.getElementById('address').value;
	var userCountry = document.getElementById('country').value;
	var userState = document.getElementById('state').value;
	var userCity = document.getElementById('city').value;
	var form = $('form')[0]; // You need to use standart javascript object here
	var formData = new FormData(form);

	jQuery.ajax({
    url: "jsonResponse.php",
    data:formData,
    type: "POST",
		processData: false, // VIMP
    contentType: false, // VIMP
    success:function(data){
			var obj = JSON.parse(data);
			if(obj.status =="success")
				$("#success_report").html("Insert Successful !");
			else
				$("#error_report").html("Insert Failed !");
    },
    error:function (){

    }
  });

}

function loadState(country_id,oldStateId)
{
	$.ajax({
	type: "POST",
	url: "getState.php",
	data:'Country_ID='+country_id+'&State_ID='+oldStateId,
	success: function(data){
    if(data=='false'){
      $("#show_state").hide();
      var state = document.getElementById("state");
      var option = document.createElement("option");
      option.text = "None"
      option.value =0;
      state.add(option);

    }
    else{
      $("#show_state").show();
      $("#state").html(data);
    }

	},
	error:function (data){
		$("#error_report").html(data);
    }

	});
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
		if(data=='false'){
      $("#show_state").hide();
      var state = document.getElementById("state");
      state.innerHTML = "";
      var option = document.createElement("option");
      option.text = "None"
      option.value =0;
      state.add(option);
    }
    else{
      $("#show_state").show();
      $("#state").html(data);
    }
	},
	error:function (data){
		$("#error_report").html(data);
    }

	});


}

// function to display imageName
function setImage()
{
	test('hi');
}
