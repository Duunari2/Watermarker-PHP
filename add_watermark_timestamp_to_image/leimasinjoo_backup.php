<?php


//system('rm kokoonpano.png');
date_default_timezone_set('Europe/Helsinki');

$aikaleima =  date("Y-m-d H:i:s");


error_reporting(E_ALL);
ini_set( 'display_errors','1');

/* Create a new imagick object */
$im = new Imagick();

/* Create new image. This will be used as fill pattern */
$im->newPseudoImage(50, 50, "gradient:red-black");
//$im->imageWriteFile (fopen ("test_2.jpg", "wb")); //also works
/* Create imagickdraw object */
$draw = new ImagickDraw();
/* Start a new pattern called "gradient" */
$draw->pushPattern('gradient', 0, 0, 50, 50);
/* Composite the gradient on the pattern */
$draw->composite(Imagick::COMPOSITE_OVER, 0, 0, 50, 50, $im);
/* Close the pattern */
$draw->popPattern();
/* Use the pattern called "gradient" as the fill */
$draw->setFillPatternURL('#gradient');
/* Set font size to 52 */
$draw->setFontSize(52);
/* Annotate some text */
$draw->annotation(20, 50, $aikaleima);
/* Create a new canvas object and a white image */
$canvas = new Imagick();
$canvas->newImage(850, 70, "white");
/* Draw the ImagickDraw on to the canvas */
$canvas->drawImage($draw);
/* 1px black border around the image */
$canvas->borderImage('black', 1, 1);
/* Set the format to PNG */

$canvas->setImageFormat('png');
/* Output the image */

//$canvas->imageWriteFile ("test_2.png", ); //also works
header("Content-Type: image/png");
echo $canvas;
file_put_contents ("watermarkki.png", $canvas);

system('convert \
leimattava3.jpg \
\( watermarkki.png \
-background none -virtual-pixel none \
+distort perspective \
"0,0 203,153  399,0 541,153  399,299 541,355  0,298 203,355" \) \
-background none -layers merge \
screen_barn.jpg');
// Open the original image
$image2 = new Imagick();
$image2->readImage("maalattava.jpg");
// Open the watermark
$watermark2 = new Imagick();
$watermark2->readImage("watermarkki.png");
// Overlay the watermark on the original image
$image2->compositeImage($watermark2, imagick::COMPOSITE_OVER, 0, 0);
// send the result to the browser
header("Content-Type: image/" . $image2->getImageFormat());
echo $image2;

//system('convert watermarkki.png \( -clone 0 -fill "gray(35%)" -colorize 100% \) +matte -compose copy_opacity -composite maalattava.jpg');


//yllä oleva koodi luo timestamppi kuvatiedoston ilman läpinäkyvyyttä.
// Open the original image
//$image4 = new Imagick();
//$image4->readImage("leimattava2.jpg");
// Open the watermark
system("convert maalattava.jpg -resize 1024x800 miff:- | composite -watermark 30% -gravity center watermarkki.png - kokoonpano.png");
//$watermark4 = new Imagick();
//$watermark4->readImage("leimaajankatu.jpg");
// Overlay the watermark on the original image
//$image4->compositeImage($watermark4, imagick::COMPOSITE_OVER, 0, 0);
// send the result to the browser

//header("Content-Type: image/" . $image4->getImageFormat());

//exec("convert leimattava3.jpg -resize 1024x800 miff:- | composite -watermark 30% -gravity center leimaajankatu.png - outputttaus.png");

//header("Location: /liita_palikat.php");
//die();
?>
<html>
<head>
<body>
	<br><br>
	<img src="watermarkki.png">
	<br><br>
	<img src="maalattava.jpg">
	<br><br>
<img src="kokoonpano.png">
<br><br>

<body>
</head>
</html>

