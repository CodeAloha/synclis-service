<?php

	$x = 50;
	$y = 50;

	$final_img = imagecreatetruecolor($x, $y);


	imagesavealpha($final_img, true);


	$trans_colour = imagecolorallocatealpha($final_img, 0, 0, 0, 127);
	imagefill($final_img, 0, 0, $trans_colour);


	$images = array('tour/icon.png', 'icons/categories/apartment.png');

		$image_layer = imagecreatefrompng('tour/icon.png');
		 imagecopyresampled($final_img, $image_layer, 0, 0, 0, 0, 50, 50, 225, 225);
		
		$image_layer = imagecreatefrompng("{$_GET['img']}");
		 imagecopyresampled($final_img, $image_layer, 9, 2, 0, 0, 32, 32, 64, 64);

	//imagealphablending($final_img, true);
	imagesavealpha($final_img, true);
	imagealphablending($final_img, true);


	header('Content-Type: image/png');
	imagepng($final_img);

?>