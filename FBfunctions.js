function setLogin(user){
	var str = JSON.stringify(user);
	jQuery.ajax({
      url: "FBlogin.php",
      data:'user='+str,
      type: "POST",
      success:function(data){
        //$("#error_report").html(data);
        if(data == "Success")
        {
			window.location= "pagination.php";
        }
        else
        {
          alert("ERROR:"+data);
        }
      },
      error:function (data){
          alert("ajax error");
      }
    });
}

function manualLogin(){
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			fetchDetails();
		}else{
			FB.login(function(response){
				console.log(JSON.stringify(response));
				fetchDetails();
			});
		}
	});
}

function manualLogout(){
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			FB.logout();
			alert("logged out");
		}
		else{
			alert("not logged in");
		}
	});
}

function fetchDetails(){
	console.log("hi");
	FB.api('/me', { locale: 'en_US', fields: 'id,email,first_name,last_name,gender,birthday' },
		function(response) {
			setLogin(response);
		}
	);
}

function checkStatus(){
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			console.log("Token:"+response.authResponse.accessToken);
			console.log("-->"+JSON.stringify(response));
		}
		console.log("stats:"+response.status);
	});
}

// Default settings
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1082505441895613',
      cookie     : true,
      xfbml      : true,
	  oauth		 : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   	function checkLoginState() {
		FB.getLoginStatus(function(response) {
			setStatus("Login State: "+(JSON.stringify(response)));
			
		});
	}

