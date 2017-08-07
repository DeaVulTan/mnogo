<?
//header("Content-type: image/png");

$width=100; $height=50;
$im=imagecreatetruecolor($width, $height) or die("Cannot Initialize new GD image stream");
$white=imagecolorallocate($im, 255, 255, 255);
$color=imagecolorallocatealpha($im, 0, 49, 106, mt_rand(45, 75));
$green=imagecolorallocatealpha($im, 35, 150, 20, mt_rand(45, 65));
$red=imagecolorallocatealpha($im, 200, 90, 50, mt_rand(45, 65));
$blue=imagecolorallocatealpha($im, 50, 70, 200, mt_rand(45, 65));

	
$colors=array($green, $red, $blue, $color);
	  
imagefilledrectangle($im, 0, 0, $width, $height, $white);
imagerectangle($im, 0, 0, $width-1, $height-1, $color);
$i = 0;
while ($i < rand(18, 25))
{
	$linecolor = imagecolorallocatealpha($im, rand(0, 255), rand(0, 255), rand(0, 255), 80);
	imageline($im, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $linecolor);
	$i++;
}

$font_size=12;

$code="";
for ($i=1; $i<=5; ++$i)
    $code .= mt_rand(0, 9);

//$_SESSION["ImageCode"]=$code;
setcookie("IMAGECODE", md5($code));
putenv('GDFONTPATH=' . realpath('.'));

for ($i=0; $i<strlen($code); ++$i)
{
    $angle=mt_rand(-10,20);
    $shift=mt_rand(-2, 2);
    $size=mt_rand(17,20);
	$color=$colors[mt_rand(0, 3)];
    imagettftext($im, 9+$size, $angle, 10+$i*($font_size+2), 10+$shift+($height+$font_size)/2, $color, "verdana", $code[$i]."&nbsp;&nbsp;&nbsp;");
}

imagepng($im);
imagedestroy($im);

?>
