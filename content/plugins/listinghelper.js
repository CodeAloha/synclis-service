/*

	BOOKMARK FUNCTIONS
	
*/
	
	function bookmarkit(listing){
		if(readCookie("SYNCLIS_TOKEN")){
			if(document.getElementById("bkm" + listing).style.color =='orange') synclis_delBkmrk(listing);
			else synclis_setBkmrk(listing);
		}else{
			alert('You must be logged in to bookmark ');
		}
	}
	
	function synclis_setBkmrk(listing){
		var http = new XMLHttpRequest();
		http.open("POST", "https://synclis.com/api/sys/bookmarks", true);

		var params = "session=" + readCookie("SYNCLIS_TOKEN") + "&listing=" + listing;

		
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
						document.getElementById("bkm" + listing).style.transition = "color 0.6s";
						document.getElementById("bkm" + listing).style.WebkitTransition = "color 0.6s";
						document.getElementById("bkm" + listing).style.color = "orange";
						document.getElementById("bkm" + listing).innerHTML = '<i class="x-icon-bookmark-o"></i> Saved';
					}
					else
						alert(http.responseText);
				}catch(e){
					alert(http.responseText);
				}
			}
		}
		http.send(params);
	}
	
	function synclis_delBkmrk(listing){
		var http = new XMLHttpRequest();
		http.open("DELETE", "https://synclis.com/api/sys/bookmarks?listing="  + listing + "&session=" + readCookie("SYNCLIS_TOKEN"), true);


		
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
						document.getElementById("bkm" + listing).style.transition = "color 0.6s";
						document.getElementById("bkm" + listing).style.WebkitTransition = "color 0.6s";
						document.getElementById("bkm" + listing).style.color = "#333";
						document.getElementById("bkm" + listing).innerHTML = '<i class="x-icon-bookmark-o"></i> Bookmark';
					}
					else
						alert(http.responseText);
				}catch(e){
					alert(http.responseText);
				}
			}
		}
		http.send();
	}

	
	function fadeOutListing(id){
		if(document.getElementById('synclisSort' + id)){
			document.getElementById('synclisSort' + id).style.transition = "opacity 0.4s";
			document.getElementById('synclisSort' + id).style.WebkitTransition = "opacity 0.4s";
			document.getElementById('synclisSort' + id).style.transform = "translate3d(0,0,0)";
			document.getElementById('synclisSort' + id).style.WebkitTransform = "translate3d(0,0,0)";
			document.getElementById('synclisSort' + id).style.opacity = "0";
			setTimeout(function(){ //
				document.getElementById('synclisSort' + id).style.display = "none";
				msnry.layout();
			},400);
		}
	}
	function fadeInListing(id){
		if(document.getElementById('synclisSort' + id)){
			document.getElementById('synclisSort' + id).style.display = "";
			document.getElementById('synclisSort' + id).style.transition = "opacity 0.4s";
			document.getElementById('synclisSort' + id).style.WebkitTransition = "opacity 0.4s";
			document.getElementById('synclisSort' + id).style.transform = "translate3d(0,0,0)";
			document.getElementById('synclisSort' + id).style.WebkitTransform = "translate3d(0,0,0)";
			document.getElementById('synclisSort' + id).style.opacity = "1";
		}
	}
	
/*

	ENJOY FUNCTIONS
	
*/
	
	function enjoyit(listing)
	{
		if(readCookie("SYNCLIS_TOKEN"))
		{
			var http = new XMLHttpRequest();
			http.open("POST", "https://synclis.com/api/sys/enjoy", true);

			var params = "session=" + readCookie("SYNCLIS_TOKEN") + "&listing=" + listing;

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
							document.getElementById("tog" + listing).style.transition = "background 0.6s";
							document.getElementById("tog" + listing).style.WebkitTransition = "background 0.6s";
							document.getElementById("tog" + listing).style.background = "orange";
						}
						else
							alert(http.responseText);
					}catch(e){
						alert(http.responseText);
					}
				}
			}
			http.send(params);
		}else{
			alert('You must be logged in to bookmark ');
		}
	}
	
/*Sorting lists*/


	function synclis_sort(){
		if(sortingJSON)
		{
			
			//Show Stoppers
			if(document.getElementById("synclissort_minprice") && document.getElementById("synclissort_maxprice")){
				var min = parseInt(document.getElementById("synclissort_minprice").value),
					max = parseInt(document.getElementById("synclissort_maxprice").value);
				
				if(min >= max){
					alert("Min Price must be lower than the Max Price.");
					document.getElementById('synclissort_minprice').style.border='1px solid #f77';
				}
				else{
					document.getElementById('synclissort_minprice').style.border='1px solid #bbb';
				}
			}
			
			
			
			//MAIN LOOOP
			for(var t=0; t< sortingJSON.length; t++)
			{//Loop Through All Elements

				if(document.getElementById("synclissort_minprice") && document.getElementById("synclissort_maxprice"))
				{//Check If Min/Max Price Is Enabled.
					if(sortingJSON[t].price){
						var x   = parseInt(sortingJSON[t].price);
						if(document.getElementById("synclissort_maxprice").value == ''){max = 5000000000; document.getElementById('synclissort_maxprice').style.border='1px solid #f77';}
						else{ document.getElementById('synclissort_maxprice').style.border='1px solid #bbb'; }
						if(document.getElementById("synclissort_minprice").value == ''){min = 0;          document.getElementById('synclissort_minprice').style.border='1px solid #f77';}
						else{ document.getElementById('synclissort_minprice').style.border='1px solid #bbb'; }
						if((min <= x) && (x <= max)){fadeInListing(sortingJSON[t].id);}
						else{fadeOutListing(sortingJSON[t].id);}
					}else{
						fadeOutListing(sortingJSON[t].id);
					}
				}
				
				if(document.getElementById("synclissort_paymentbasis"))
				{//Check If Payment Basis Is Enabled.
					if(sortingJSON[t].paymentbasis)
					{
						if(document.getElementById("synclissort_paymentbasis").value != sortingJSON[t].paymentbasis)	
							fadeOutListing(sortingJSON[t].id);
					}
				}
				
				if(document.getElementById("synclissort_bedrooms"))
				{//Check If Bedrooms Is Enabled.
					if(sortingJSON[t].bedroom && document.getElementById("synclissort_bedrooms").value != 'Bedrooms')
					{
						if(document.getElementById("synclissort_bedrooms").value > sortingJSON[t].bedroom)	
							fadeOutListing(sortingJSON[t].id);
					}
				}
				
				if(document.getElementById("synclissort_bathrooms"))
				{//Check If Bathrooms Is Enabled.
					if(sortingJSON[t].bathroom && document.getElementById("synclissort_bathrooms").value != 'Bathrooms')
					{
						if(document.getElementById("synclissort_bathrooms").value > sortingJSON[t].bathroom)	
							fadeOutListing(sortingJSON[t].id);
					}
				}
				
				if(document.getElementById("synclissort_condition"))
				{//Check If Bathrooms Is Enabled.
					if(sortingJSON[t].condition && document.getElementById("synclissort_condition").value != 'Condition')
					{
						if(document.getElementById("synclissort_condition").value != sortingJSON[t].condition)	
							fadeOutListing(sortingJSON[t].id);
					}
				}
				
				if(document.getElementById("synclissort_paymentmethod"))
				{//Check If Bathrooms Is Enabled.
					if(sortingJSON[t].paymentmethod && document.getElementById("synclissort_paymentmethod").value != 'Payment Method')
					{
						if(document.getElementById("synclissort_paymentmethod").value != sortingJSON[t].paymentmethod)	
							fadeOutListing(sortingJSON[t].id);
					}
				}

			}//Loop Through All Elements
		}
		else
		{
			alert('Synclis Parsing Error [106]: Unable to sort your listing.');
		}
	}
	
	function hideListingHelper(){
		if(document.getElementById('MessageHelper'))
		{
			document.getElementById('MessageHelper').style.transform = "translate3d(0px,0px,0px)";
			document.getElementById('MessageHelper').style.WebkitTransform = "translate3d(0px,0px,0px)";
			
			document.getElementById('MessageHelper').style.transition = "height 0.8s";
			document.getElementById('MessageHelper').style.WebkitTransition = "height 0.8s";
			document.getElementById('MessageHelper').style.border = "none";
			document.getElementById('MessageHelper').style.height= '0';
			setTimeout(function(){ //
				msnry.layout();
			},800);
		}
	}
	
	
	/*Hide Filter Plugin*/
	var filterhidden = true;
	function filterView(){
		if(filterhidden){
			filterhidden = false;
			document.getElementById('synclis-filter-panel').style.transition = "bottom 1s linear";
			document.getElementById('synclis-filter-panel').style.WebkitTransition = "bottom 1s linear";
			document.getElementById('synclis-filter-panel').style.bottom = "0";
		}else{
			filterhidden = true;
			document.getElementById('synclis-filter-panel').style.transition = "bottom 1s linear";
			document.getElementById('synclis-filter-panel').style.WebkitTransition = "bottom 1s linear";
			document.getElementById('synclis-filter-panel').style.bottom = "-200px";
		}
	}
	
	
	