<?php
// Create logo.png
$width = 200;
$height = 80;
$image = imagecreatetruecolor($width, $height);
$backgroundColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 255, 152, 0);
imagefill($image, 0, 0, $backgroundColor);
imagestring($image, 5, 40, 30, 'CrackerTime', $textColor);
imagepng($image, 'public/images/logo.png');
imagedestroy($image);
echo "✓ logo.png created\n";

// Create placeholder.png
$width = 150;
$height = 150;
$image = imagecreatetruecolor($width, $height);
$backgroundColor = imagecolorallocate($image, 240, 240, 240);
$textColor = imagecolorallocate($image, 150, 150, 150);
imagefill($image, 0, 0, $backgroundColor);
imagestring($image, 3, 30, 65, 'No Image', $textColor);
imagepng($image, 'public/images/placeholder.png');
imagedestroy($image);
echo "✓ placeholder.png created\n";
?>
