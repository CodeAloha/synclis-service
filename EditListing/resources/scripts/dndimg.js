var imageSources = new Array();
var localNames = new Array();
var index = 0 ;

$(document).ready(function() {
	var dropbox = document.getElementById("dropbox")

	// init event handlers
	dropbox.addEventListener("dragenter", dragEnter, false);
	dropbox.addEventListener("dragexit", dragExit, false);
	dropbox.addEventListener("dragover", dragOver, false);
	dropbox.addEventListener("drop", drop, false);

	var dropbox = document.getElementById("preview")

	// init event handlers
	dropbox.addEventListener("dragenter", dragEnter, false);
	dropbox.addEventListener("dragexit", dragExit, false);
	dropbox.addEventListener("dragover", dragOver, false);
	dropbox.addEventListener("drop", drop, false);
	
	// init the widgets
	//$("#progressbar").progressbar();
});

function dragEnter(evt) {
	evt.stopPropagation();
	evt.preventDefault();
}

function dragExit(evt) {
	evt.stopPropagation();
	evt.preventDefault();
}

function dragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
}

function drop(evt) {
	evt.stopPropagation();
	evt.preventDefault();

	var files = evt.dataTransfer.files;
	var count = files.length;

	// Only call the handler if 1 or more files was dropped.
	if (count > 0)
		handleFiles(files);
}


function handleFiles(files) {
	var file = files[0];
	localNames[index] = file.name;
	document.getElementById("droplabel").innerHTML = "Processing " + file.name;
	var extension = file.name.slice( -3 );
	if(extension == "png" || extension == "peg" || extension == "tif" || extension == "jpg" ||
	   extension == "PNG" || extension == "PEG" || extension == "TIF" || extension == "JPG")
	{}
	else if(extension == "gif")
	{
		alert('If gif is animated, only first frame will be used.');
	}
	else
	{
		alert('This file format is not supported!');
		document.getElementById("droplabel").innerHTML = "Not supported.";
		return;
	}
	
	
	
	var reader = new FileReader();

	// init the reader event handlers
	reader.onprogress = handleReaderProgress;
	reader.onloadend = handleReaderLoadEnd;

	// begin the read operation
	reader.readAsDataURL(file);
}

function handleReaderProgress(evt) {
	if (evt.lengthComputable) {
		var loaded = (evt.loaded / evt.total);

	}
}

function handleReaderLoadEnd(evt) {

		var img = document.getElementById("preview");
		img.src = evt.target.result;
		document.getElementById("image1").src = evt.target.result;
		postImage();
		
		var magnificPopup = $.magnificPopup.instance; 
		magnificPopup.close(); 
		
}