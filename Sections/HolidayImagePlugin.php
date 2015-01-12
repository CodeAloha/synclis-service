	<!--April Fools Plugin-->
	<div id="aprilfoolsplugin" style="position:fixed; bottom:0; left:-250px; width:250px; height: 250px;">
		<img id="aprilfoolsimg" src="AprilFools/0.png"/>
	</div>
	<script>
		var animalOut = true, animalIndex = 0;
		setInterval(function(){
			document.getElementById('aprilfoolsplugin').style.transition = "left 1s";
			document.getElementById('aprilfoolsplugin').style.WebkitTransition = "left 5s";
			document.getElementById('aprilfoolsplugin').style.transform = "translate3d(0px,0px,0px)";
			document.getElementById('aprilfoolsplugin').style.WebkitTransform = "translate3d(0px,0px,0px)";
			if(animalOut){
				animalOut = false;
				document.getElementById('aprilfoolsplugin').style.left = 0;
				

					animalIndex++;
					if(animalIndex > 5)
						animalIndex = 0;
					document.getElementById('aprilfoolsimg').src = "AprilFools/" + animalIndex + ".png";

				
			}else{
				animalOut = true;
				document.getElementById('aprilfoolsplugin').style.left = "-500px";
			}
		},5000);
	</script>
	<!--April Fools Plugin-->