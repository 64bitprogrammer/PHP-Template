// javascript file to handle listing.php code

// function to handle the remember me
function checkLogin(){
	var checkbox = document.getElementById('rememberMe');
	var hidden = document.getElementById('checkbox_value');
	if(checkbox.checked)
		hidden.value = "checked";
	else
		hidden.value = "unchecked";

	if(validateEmail() && validatePassword())
		return true;
	else
		return false;
}

function validatePassword()
{
	var pass = document.getElementById('password').value;
	if(pass.length <6 || pass=="")
		document.getElementById('pass_help').innerHTML = "Password must be min. 6 char long";
	else
		return true;

	return false;
}

// validate mail
function validateEmail()
{
	var email = document.getElementById('email').value;
	var helpObj = document.getElementById('login_help');
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

// function to toggle asc / dec and call the actual sort method
function toggleSortMethod(filter,key){

	sortTypeObj = document.getElementById('sort_type');
	sortColumn = document.getElementById('hidden_column');
	sortColumn.value = filter;

	if(sortTypeObj.value=="asc"){
		sortTypeObj.value = "desc";
		//sortData(filter,sortTypeObj.value,key);
	}
	else{
		sortTypeObj.value = "asc";
		//sortData(filter,sortTypeObj.value,key);
	}

	document.getElementById('sortForm').submit();

}

// function to sort and display records_list
function sortData(filter,sortMode,key){
		alert("Filter = "+filter+" Mode = "+sortMode+" Key = "+key);
}

// function to handle search via ajax
function search(key){

	$("#records_list").hide();

		$.ajax({
			type: "POST",
			url: "ajax_search.php",
			data: 'keyword='+key,
			success: function(data){
				$("#search_panel").html(data);
			}

		});
}

function test(val){
	alert("item = "+val);
}


function callEdit(val){
	window.open('http://localhost/test/update.php?id='+val, '_blank');
}

function callDelete(val){

	if(confirm("Confirm Delete?")){

		$.ajax({
		type: "POST",
		url: "deleteRecord.php",
		data: 'id='+val,
		success: function(data){
			if(data=='true')
				location.reload();
			else
				alert("Delete Failed !"+data);
		}

	});
	}
}
