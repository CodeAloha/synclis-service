	function calcHash(value) {
		try {
			var hashObj = new jsSHA(value, "TEXT");
			return hashObj.getHash("SHA-512","HEX",1);
		} catch(e) {
			alert('Unable to process password');
		}
	}
	if(document.URL.substr( 0, 5) != 'https'){
		window.location="https://synclis.com/Login";
	}
	
	function login(){
		flag = false;
		if(document.getElementById('username').value == ''){
			pushNote('Username is empty.');
			document.getElementById('username').style.border = '1px solid #faa';
			flag = true;
		}
		else if(!validateEmail(document.getElementById('username').value)){
			pushNote('Username must be an email.');
			document.getElementById('username').style.border = '1px solid #faa';
			flag = true;
		}
		if(p!="email"){
			if(document.getElementById('password').value == ''){
				pushNote('Please enter your password.');
				document.getElementById('password').style.border = '1px solid #faa';
				flag = true;
			}
			else if(document.getElementById('password').value.length < 8){
				pushNote('Your password can not be shorter than 8 characters.');
				document.getElementById('password').style.border = '1px solid #faa';
				flag = true;
			}
		}
		

		//If Sign Up is triggered.
		if(p=="SignUp"){
			if(document.getElementById('password').value != document.getElementById('password2').value){
				pushNote('Passwords do not match.');
				document.getElementById('password').style.border = '1px solid #faa';
				document.getElementById('password2').style.border = '1px solid #faa';
				flag = true;
			}
			else if( (document.getElementById('zip').value === parseInt(document.getElementById('zip').value)) || document.getElementById('zip').value.length < 4 || document.getElementById('zip').value.length >= 10){
				pushNote('Zipcode must be a number, with four to nine digits.');
				document.getElementById('zip').style.border = '1px solid #faa';
				flag = true;
			}
			else if( /[^a-zA-Z0-9]/.test(document.getElementById('fname').value ) || /[^a-zA-Z0-9]/.test(document.getElementById('lname').value ) ){
				pushNote('First and last names must be numeric.');
				document.getElementById('fname').style.border = '1px solid #faa';
				document.getElementById('lname').style.border = '1px solid #faa';
				flag = true;
			}
			else if( document.getElementById('fname').value.length > 31 || document.getElementById('lname').value  > 31 ){
				pushNote('First and last names must be less than 32 characters long.');
				document.getElementById('fname').style.border = '1px solid #faa';
				document.getElementById('lname').style.border = '1px solid #faa';
				flag = true;
			}
			else if( !(/^[ \w#-]+$/.test( document.getElementById('address').value )) || document.getElementById('address').value.lengt > 255){
				pushNote('Address must only contain letters, numbers, ., and - and less than 255 characters long.');
				document.getElementById('address').style.border = '1px solid #faa';
				flag = true;
			}
		}
		
		if(!flag){
			if(p=="SignUp") synclis_apipu();
			else if(p=="email") synclis_pwdrst();
			else  synclis_apisec();
		}
	}
	
	function changeCheck(lim){
		if(lim == "user"){//Lim = user
				if(document.getElementById('username').value == ''){
					document.getElementById('username').style.border = '1px solid #faa';
				}
				else{
					document.getElementById('username').style.border = '1px solid #1FB5AC';
				}
				if(!validateEmail(document.getElementById('username').value)){
					pushNote('Username should be an email.');
					document.getElementById('username').style.border = '1px solid #faa';
				}
				else{
					document.getElementById('username').style.border = '1px solid #1FB5AC';
				}
		}
		else{//Lim = pass
				if(document.getElementById('password').value == ''){
					document.getElementById('password').style.border = '1px solid #faa';
				}
				else{
					document.getElementById('password').style.border = '1px solid #1FB5AC';
				}
				if(document.getElementById('password').value.length < 8){
					pushNote('Password must be more than 8 characters long.');
					document.getElementById('password').style.border = '1px solid #faa';
				}
				else{
					document.getElementById('password').style.border = '1px solid #1FB5AC';
				}
		}
	}
	
	function synclis_apisec(){
		var http = new XMLHttpRequest();
		//Must be encrypted with SHA 128, 256, 512
		http.open("GET", "https://synclis.com/api/sys/login?email="+ document.getElementById('username').value +"&password="+ calcHash(document.getElementById('password').value) +"&login-method=" + ptg(), true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error'){
						pushNote(json.message);
						document.getElementById('username').style.border = '1px solid #fff';
						document.getElementById('password').style.border = '1px solid #fff';
						document.getElementById('password').value = '';
					}
					else{
						if(json.session_token == '' || json.session_token == 'undefined')
						{ pushNote("Unable to log you in, due to improper server transaction.<br/>Please try again."); }
						else{
							document.cookie = "SYNCLIS_TOKEN" + "=" + json.session_token + "; max-age=" + 60 * 60 * 24 * 90 + "; path=/" + '; domain=synclis.com';
							document.cookie = "SYNCLIS_TOKEN" + "=" + json.session_token + "; max-age=" + 60 * 60 * 24 * 90 + "; path=/Sections"+ '; domain=synclis.com';
							document.cookie = "SYNCLIS_TOKEN" + "=" + json.session_token + "; max-age=" + 60 * 60 * 24 * 90 + "; path=/Listings"+ '; domain=synclis.com';
							document.cookie = "SYNCLIS_TOKEN" + "=" + json.session_token + "; max-age=" + 60 * 60 * 24 * 90 + "; path=/ViewListing"+ '; domain=synclis.com';
							document.cookie = "SYNCLIS_TOKEN" + "=" + json.session_token + "; max-age=" + 60 * 60 * 24 * 90 + "; path=/CreateListings"+ '; domain=synclis.com';

							
							
							
							
							
							
							setTimeout(function(){ window.location = "https://synclis.com/"},600);
						}
						document.getElementById('username').style.border = '1px solid #fff';
						document.getElementById('password').style.border = '1px solid #fff';
						document.getElementById('password').value = '';
					}
				}catch(e){
					alert(http.responseText);
				}
			}
		}
		http.send();
	}
	
	function synclis_apipu(){
		var http = new XMLHttpRequest();
		//Must be encrypted with SHA 128, 256, 512
		http.open("POST", "https://synclis.com/api/sys/users", true);
		var params = "first_name=" + document.getElementById('fname').value +
					 "&last_name=" + document.getElementById('lname').value + 
					   "&address=" + document.getElementById('address').value +
					   "&zipcode=" + document.getElementById('zip').value +
					     "&email=" + document.getElementById('username').value +
					  "&password=" + calcHash(document.getElementById('password').value);
		
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error'){
						pushNote(json.message);
					}
					else if (json.response == 'success'){
						pushNote(json.message + "<br/> please check your email.");
						document.getElementById('username').style.border = '1px solid #fff';
						document.getElementById('password').style.border = '1px solid #fff';
						document.getElementById('password').value = '';
						document.getElementById('fname').value = '';
						document.getElementById('lname').value = '';
						document.getElementById('address').value = '';
						document.getElementById('zip').value = '';
						document.getElementById('username').value = '';
						collapse();
					}
					else{
						pushNote("Unexpected error has occured.");
					}
				}catch(e){
					/*pushNote("It appears that something has went wrong, please try again, Refresh in 3 seconds.");
					setTimeout(function(){
						window.location = "";
					},3000);*/
					alert('ERROR CONSOLE: ' + http.responseText);
				}
			}
		}
		http.send(params);
	}
	
	function synclis_pwdrst(){
		var http = new XMLHttpRequest();
		//Must be encrypted with SHA 128, 256, 512
		http.open("POST", "https://synclis.com/api/sys/passreset", true);
		var params = "email=" + document.getElementById('username').value;
		
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error'){
						pushNote(json.message);
					}
					else if (json.response == 'success'){
						pushNote(json.message);
						document.getElementById('username').style.border = '1px solid #fff';
						document.getElementById('password').style.border = '1px solid #fff';
						document.getElementById('password').value = '';
						document.getElementById('fname').value = '';
						document.getElementById('lname').value = '';
						document.getElementById('address').value = '';
						document.getElementById('zip').value = '';
						document.getElementById('username').value = '';
						collapse();
					}
					else{
						pushNote("Unexpected error has occured.");
					}
				}catch(e){
					/*pushNote("It appears that something has went wrong, please try again, Refresh in 3 seconds.");
					setTimeout(function(){
						window.location = "";
					},3000);*/
					alert('ERROR CONSOLE: ' + http.responseText);
				}
			}
		}
		http.send(params);
	}

	function validateEmail(email) { 
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	} 
	
	function ptg(){if( navigator.userAgent.match(/Android/i)){return "Android";}else if( navigator.userAgent.match(/webOS/i)) {return "WebOS";}else if( navigator.userAgent.match(/iPhone/i)){return "iPhone";}else if( navigator.userAgent.match(/iPad/i)){return "iPad";}else if( navigator.userAgent.match(/iPod/i)){return "iPod";}else if( navigator.userAgent.match(/BlackBerry/i) ){return "BlackBerry";}else if( navigator.userAgent.match(/Windows Phone/i) || navigator.userAgent.match(/IEMobile/i) ){ return "Windows 8"; }else if( navigator.userAgent.match(/Opera Mini/i) ){ return "Opera"; }else{if(navigator.appVersion.indexOf("Win")!=-1 ){return "Windows";} else if(navigator.appVersion.indexOf("Mac")!=-1 ){return "Mac";}else if(navigator.appVersion.indexOf("X11")!=-1 ){return "UNIX";}else if(navigator.appVersion.indexOf("Linux")!=-1 ){return "Linux";}}}