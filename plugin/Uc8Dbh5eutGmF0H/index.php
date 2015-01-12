<?php
	if(!$_COOKIE["SYNCLIS_CURPOS"]){
		$json = file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}");
		$details = json_decode($json);
		
		$GLOBALS['COUNTRY'] = $details->country;
		$GLOBALS['CITY']  = $details->city; 
		$GLOBALS['REGION'] = $details->region;
		if($GLOBALS['COUNTRY'] != '' && $GLOBALS['REGION'] != '' && $GLOBALS['CITY'] != '')
		{
			?>
				
				<script type="text/javascript" src="<?php echo $GLOBALS['ROOT']; ?>/api/cookies.js"></script>
				<script type="text/javascript">createCookieByHour("SYNCLIS_CURPOS","<?php echo base64_encode( $GLOBALS['COUNTRY'] .":". $GLOBALS['CITY'] .":". $GLOBALS['REGION']); ?> .'",72); window.location="";</script>
			<?php
		}
	}
?>
	<style>
		body{
			font-family: 'Lucida Grande', 'Lucida Sans Unicode', Verdana, sans-serif;
			font-size: 12px;
			padding:0;
			 margin:0;
			 background: url(https://synclis.com/plugin/assets/bwsymbol.png);
			 background-size: 370px; 370px;
			 background-repeat: no-repeat;
		}
			
		button{
			border-radius: 3px;
			-webkit-box-shadow: 2px 2px 2px 1px rgba(42, 120, 105, 1);
			-moz-box-shadow: 2px 2px 2px 1px rgba(42, 120, 105, 1);
			box-shadow: 2px 2px 2px 1px rgba(42, 120, 105, 1);
			background: #16a085;
			border: none;
			color: white;
			padding: 8px;
			margin-top: 12px;
			width: 100%;
			-webkit-transition: background 0.4s;
			transition: background 0.4s;
			-moz-transition: background 0.4s;
			letter-spacing: 4px;
			cursor: pointer;
		}
		button:hover{
			background: #fff;
			color: #16a085;
			-webkit-box-shadow: 2px 2px 2px 1px rgba(105, 105, 105, 0.5);
			-moz-box-shadow: 2px 2px 2px 1px rgba(105, 105, 105, 0.5);
			box-shadow: 2px 2px 2px 1px rgba(105, 105, 105, 0.5);
		}
		input,select {
			font-family: 'Lucida Grande', 'Lucida Sans Unicode', Verdana, sans-serif;
			outline: none;
			border:1px solid #aaa;
			padding: 9px;
			border-radius: 3px;
			width:100%;
			background: #fff;
			background: rgba(255,255,255, 0.8);
			transition: padding 0.4s;
			-webkit-transition: padding 0.4s;
			padding-left: 4px;
		}
		input:focus {
			padding-left: 12px;
		}
		textarea{
			font-family: 'Lucida Grande', 'Lucida Sans Unicode', Verdana, sans-serif;
			outline: none;
			border:1px solid #aaa;
			padding: 9px;
			height: 80px;
			border-radius: 3px;
			width:100%;
			resize: none;
			background: #fff;
			background: rgba(255,255,255, 0.8);
			transition: padding 0.4s;
			-webkit-transition: padding 0.4s;
		}
		::-webkit-scrollbar {
		width: 9px;
	}
	 
	::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
		border-radius: 10px;
	}
	 
	::-webkit-scrollbar-thumb {
		border-radius: 10px;
		background: #6DD0BC;
		opacity: 0.5;
		-webkit-box-shadow: inset 0 0 6px rgba(35, 135, 116,0.5); 
	}
	</style>
		<?php 
			include('../../api/connectToDB.php');
			$b = mysqli_query($conn,"SELECT IMAGE, CONTENT FROM `PLUGIN_TMP` WHERE HASH='{$_GET['s']}'");
			$row = mysqli_fetch_row($b);
		?>
		
		<div id="SynclisCreatePanel" style="overflow:hidden; ">
			<div style="background: #f5f5f5;background: rgba(240,240,240,0.5);">
				<center><img id="synclis-replaceimg" src="<? if($row[0] == '' || $row[0] =='undefined') echo 'https://synclis.com/MyListings/no-photo.png'; else echo $row[0]; ?>" style=" height: 125px; max-width: 225px;"/></center>
			</div>
			<div style="padding:8px; height: 148px; overflow-y: scroll;">
				<select onChange="synclis_execCG()" id ="synclis-plugin-sections">
					<option value="0">Select a Category</option>
					<option value="1">Housing</option>
					<option value="4">Technology</option>
					<option value="7">Business Listing</option>
					<option value="2">Freelance Listing</option>
					<option value="5">Job Listing</option>
					<option value="3">Store Listing</option>
					<option value="6">Event Listing</option>
					<option value="9">Vehicle Listing</option>
					<option value="8">Miscellaneous</option>
				</select>
				<select id="synclis-plugin-categories">
					<option value="0">Select a Category First</option>
				</select>
				
				<input class="synctheme" id="synclis-main-plugin-title"    placeholder="Title"   value=""><br/>
				<input class="synctheme" id="synclis-main-plugin-website"  placeholder="Website" value=""><br/>
				<input class="synctheme" id="synclis-main-plugin-contact" placeholder="Phone Contact (Optional)" value=""><br/>
				<input class="synctheme" id="synclis-main-plugin-price" placeholder="Price | Pay | Wage"   value=""><br/>
				<select id="synclis-main-plugin-paymentbasis" style="width:100%;"> <option value="">Payment Basis</option><option>One time</option><option>Per Year</option><option>Per Month</option><option>Per Week</option><option>Per Day</option><option>Per Hour</option></select>
				<select id="synclis-main-plugin-bedroom" style="width:100%;"> <option value="">Bedrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
				<select id="synclis-main-plugin-bathroom" style="width:100%;"> <option value="">Bathrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
				<select id="synclis-main-plugin-condition" style="width:100%;"> <option value="">Condition</option><option>New</option><option>Great</option><option>Good</option><option>Moderate</option><option>Poor</option><option>Broken</option></select>
				<select id="synclis-main-plugin-paymethod" style="width:100%;"> <option value="">Preferred Payment Method</option><option>Cash</option><option>Check</option><option>Card</option></select>
				<textarea class="synctheme" id="synclis-main-plugin-description" placeholder="Description"><? echo $row[1]; ?></textarea><br/><br/>
				<button onClick="submit()" class="button" id="synclis-submitbutton">CREATE</button>
			</div>
		</div>
		
		<script>
			var ttp = '<? echo $row[1]; ?>';
			if(ttp != '')
			{//If not empty.
				var title = ttp.match( /[^\.!\?]+[\.!\?]+/g );
				var comps = ttp.split(" ");
				document.getElementById("synclis-main-plugin-title").value = title[0];
				for(var i=0; i < comps.length; i++){
					if(comps[i].slice(0, 4) == 'http')
						document.getElementById("synclis-main-plugin-website").value = comps[i];
					if(comps[i].match(/(?:\d{1,3},)*\d{1,3}(?:\.\d+)?/g) )
						document.getElementById("synclis-main-plugin-price").value = comps[i];
				}
			}
		</script>

	<script src="../../api/base64.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script>
				document.getElementById('synclis-main-plugin-price').style.display = "none";
				document.getElementById('synclis-main-plugin-paymentbasis').style.display = "none";
				document.getElementById('synclis-main-plugin-bedroom').style.display = "none";
				document.getElementById('synclis-main-plugin-bathroom').style.display = "none";
				document.getElementById('synclis-main-plugin-price').style.display = "none";
				document.getElementById('synclis-main-plugin-condition').style.display = "none";
				document.getElementById('synclis-main-plugin-paymethod').style.display = "none";
		function synclis_execCG(){
			var http = new XMLHttpRequest();
			var e = document.getElementById("synclis-plugin-sections");
			var values = e.options[e.selectedIndex].value;
			
				document.getElementById('synclis-main-plugin-price').style.display = "none";
				document.getElementById('synclis-main-plugin-paymentbasis').style.display = "none";
				document.getElementById('synclis-main-plugin-bedroom').style.display = "none";
				document.getElementById('synclis-main-plugin-bathroom').style.display = "none";
				document.getElementById('synclis-main-plugin-price').style.display = "none";
				document.getElementById('synclis-main-plugin-condition').style.display = "none";
				document.getElementById('synclis-main-plugin-paymethod').style.display = "none";
			
			if( values == 1  || values == 4 || values == 7 || values == 2 || values == 5 || values == 8 || values == 9) {
				document.getElementById('synclis-main-plugin-price').style.display = "";
				document.getElementById('synclis-main-plugin-paymentbasis').style.display = "";
			} if( values  == 1) {
				document.getElementById('synclis-main-plugin-bedroom').style.display = "";
				document.getElementById('synclis-main-plugin-bathroom').style.display = "";
			} if( values == 4 || values == 8) {
				document.getElementById('synclis-main-plugin-price').style.display = "";
				document.getElementById('synclis-main-plugin-condition').style.display = "";
				document.getElementById('synclis-main-plugin-paymethod').style.display = "";
			}
			
			http.open("GET", "https://synclis.com/api/sys/categories?q="+ values +"?lang=<?php echo $GLOBALS['USER_DATA'][3]; ?>", true);
			
			//Send the proper header information along with the request
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.onreadystatechange = function() {//Call a function when the state changes.
				if(http.readyState == 4 && http.status == 200)
				{
					try{
						var json = JSON.parse(http.responseText);
						if(json.response == 'error')
							alert("ERROR: " + json.message);
						else{
							document.getElementById("synclis-plugin-categories").innerHTML = '<option value="0">Select a Sub Category</option>';
							for(var t=0; t < json.length; t++)
								document.getElementById("synclis-plugin-categories").innerHTML += '<option value="'+ json[t].id +'">' + Base64.decode(json[t].name) + '</option>';
						}
					}catch(e){
						alert("Opps, something went wrong.");
					}
				}
			}
			http.send();
		}

		var geoloc, userloc;
		setTimeout(function(){
		if(readCookie("SYNCLIS_CURPOS") != ''){
				geoloc = Base64.decode(readCookie('SYNCLIS_CURPOS')).split(":");
				userloc = "&country="+ geoloc[0] +"&providence="+ geoloc[2] +"&city="+ geoloc[1];
				codeAddress(geoloc[0] + ", " + geoloc[2] + " " + geoloc[1]);
		}
		},100);
		
		var clicked = false; // Prevent Double Click.
		function submit(){
			if(!clicked){
				var http = new XMLHttpRequest();
				
				http.open("POST", "https://synclis.com/api/sys/listings", true);
				var params = "title="+ encodeURIComponent(document.getElementById("synclis-main-plugin-title").value) +
					  "&description="+ encodeURIComponent(document.getElementById("synclis-main-plugin-description").value) +
							 "&type=" +
						  "&cat-id="+ document.getElementById("synclis-plugin-categories").options[document.getElementById("synclis-plugin-categories").selectedIndex].value +
							userloc+
						  "&image=" + document.getElementById("synclis-replaceimg").src +
							window.gloc +
						"&session=" + readCookie('SYNCLIS_TOKEN') +
					   "&json_data=" + parseJSONValue() +
						"&show_map=1";
				//Send the proper header information along with the request
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.onreadystatechange = function() {//Call a function when the state changes.
					if(http.readyState == 4 && http.status == 200)
					{
						try{
							var json = JSON.parse(http.responseText);
							if(json.response == 'error')
								alert("ERROR: " + json.message);
							else if(json.response == 'success'){
								document.getElementById('SynclisCreatePanel').innerHTML =
									'<div style="padding: 80px 8px 8px 8px; text-align: center; color: #888;">' +
										'<i style="color: #16a085;">Listing Created!</i><br/>' +
										'Press the <br/><br/>' +
										'<div style=\'margin-left: 50px; width: 96px; font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif; color: #333; color: black; border-radius: 3px; padding: 5px; border: 1px solid #ddd; background: #f5f5f5; -webkit-box-shadow: rgb(220, 220, 220) 2px 2px 2px 1px; box-shadow: rgb(220, 220, 220) 2px 2px 2px 1px;\'><img src=\'https://synclis.com/media/icon.png\' style=\'margin-bottom: -3px;\'> Add Listing</div>' +
										'<br/>associated to your listings, <br/>' + 
										'to start adding your listing to <b>Synclis!</b>' +
									'</div>';
							}
						}catch(e){
							alert("There was a problem with our servers.");
						}
					}
				}
				http.send(params);
			}
			clicked = true;
			setTimeout(function(){ clicked = false; },3000);
		}
	  var geocoder = new google.maps.Geocoder();

	  function codeAddress(address) {

		geocoder.geocode( { 'address': address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
			window.gloc = "&lat=" + results[0].geometry.location.lat() + "&lng=" + results[0].geometry.location.lng();
		  } else {
			alert('Geocode was not successful for the following reason: ' + status);
		  }
		});
	  }
		
		function synclisFlashOut(){
			document.body.style.transition = "opacity 0.4s";
			document.body.style.WebkitTransition = "opacity 0.4s";
			document.body.style.WebkitTransform = "translate3d(0, 0, 0)";
			document.body.style.opacity = '0';
			
			setTimeout(function(){
				document.body.style.opacity = '1';
			},400);
		}

		function parseJSONValue(){
			var jsonbuilder = '{"id":"@SYNCJECT@",';
			
			if(document.getElementById('synclis-main-plugin-website')){
				if(document.getElementById('synclis-main-plugin-website').value != '')
					jsonbuilder += '"website":"' + document.getElementById('synclis-main-plugin-website').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-contact')){
				if(document.getElementById('synclis-main-plugin-contact').value != '')
					jsonbuilder += '"phoneno":"' + document.getElementById('synclis-main-plugin-contact').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-price')){
				if(document.getElementById('synclis-main-plugin-price').value != '')
					jsonbuilder += '"price":"' + document.getElementById('synclis-main-plugin-price').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-paymentbasis')){
				if(document.getElementById('synclis-main-plugin-paymentbasis').value != '')
					jsonbuilder += '"paymentbasis":"' + document.getElementById('synclis-main-plugin-paymentbasis').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-bedroom')){
				if(document.getElementById('synclis-main-plugin-bedroom').value != '')
					jsonbuilder += '"bedroom":"' + document.getElementById('synclis-main-plugin-bedroom').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-bathroom')){
				if(document.getElementById('synclis-main-plugin-bathroom').value != '')
					jsonbuilder += '"bathroom":"' + document.getElementById('synclis-main-plugin-bathroom').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-condition')){
				if(document.getElementById('synclis-main-plugin-condition').value != '')
					jsonbuilder += '"condition":"' + document.getElementById('synclis-main-plugin-condition').value + '",';
			}
			if(document.getElementById('synclis-main-plugin-paymethod')){
				if(document.getElementById('synclis-main-plugin-paymethod').value != '')
					jsonbuilder += '"paymentmethod":"' + document.getElementById('synclis-main-plugin-paymethod').value + '",';
			}
			return jsonbuilder.slice(0, -1) + '}';
		}

		function createCookie(name,value,days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = name+"="+value+expires+"; path=/";
		}

		function createCookieByHour(name,value,days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = name+"="+value+expires+"; path=/";
		}

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}

		function eraseCookie(name) {
			createCookie(name,"",-1);
		}

		</script>