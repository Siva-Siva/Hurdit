<?php
$upVotes = $_GET['upVotes'];
$downVotes = $_GET['downVotes'];
$total = $upVotes + $downVotes;	

// Create a 200 x 25 image
$image = imagecreatetruecolor(200, 25);

if ($total != 0){
	
	//Calculates the percentage of the bar each bar should take up
	$ups = ($upVotes/$total) * 200;
	$downs = ($downVotes/$total) * 200;

	// Allocate colors
	$green = imagecolorallocate($image, 108, 180, 246);
	$red = imagecolorallocate($image, 231, 130, 130);
}	
else
	{
		//sets the bar to grey
		$ups = 0;
		$downs = 200;
		
		$green = imagecolorallocate($image, 200,200,200);
		$red = imagecolorallocate($image, 200,200,200);
		
	}


// Draw two rectangles each with its own color
imagefilledrectangle($image, 0, 0, $ups, 25, $green);
imagefilledrectangle($image, 200-$downs, 0, 200, 25, $red);

// Output and free from memory
header('Content-Type: image/png');

//Free disk space
imagejpeg($image);
imagedestroy($image);
?>
