<?php
	session_start();
	//echo $_SESSION["current_user"];
	//echo $_COOKIE["current_user"];
	session_destroy();
	unset($_COOKIE["current_user"]);
	setcookie("current_user","",time() -3600, "/","", 0);
	//header("location: login.php");
?>
<!doctype html>
<html>
<head>
</head>
<body>

<script>

	// Default settings
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1082505441895613',
			cookie     : true,
			xfbml      : true,
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

	window.onload = function(){
		logout();
	}
	function logout(){
		console.log("1");
		FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			FB.logout();
			console.log("2");
			window.location="login.php";
			console.log("3");
		}
		else{
			console.log("4");
			window.location="login.php";
			console.log("5");
		}
		});
	}
</script>
</body>
</html>