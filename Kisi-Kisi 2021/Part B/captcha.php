<?php
$width = 120;
$height = 50;
$image = imagecreatetruecolor($width, $height);

$backgroundColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $backgroundColor);

$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$captchaCode = '';
for ($i = 0; $i < 4; $i++) {
    $captchaCode .= $characters[rand(0, strlen($characters) - 1)];
}
$textColor = imagecolorallocate($image, 0, 0, 0);

// imagettftext($image, 20, 0, 10, 30, )

$x = 10; // Starting x-coordinate
$y = 30; // Starting y-coordinate
$fontSize = 20; // Font size

// Loop through each character in the CAPTCHA code
for ($i = 0; $i < strlen($captchaCode); $i++) {
    // Generate a random rotation angle between -15 and 15 degrees
    $angle = rand(-15, 15);
    $runY = rand(-5, 5);

    // Add the character with the random rotation angle
    imagettftext($image, $fontSize, $angle, $x, $y + $runY, $textColor, 'LCALLIG.TTF', $captchaCode[$i]);

    // Move the x-coordinate for the next character
    $x += 20;
}

for ($i=0; $i < 3; $i++) { 
    $sX = rand(0, 10);
    $eX = rand(10, 200);
    $sY = rand(10, 70);
    $eY = rand(10, 50);
    $dotX = rand(0, $width - 1);
    $dotY = rand(0, $height - 1);

    imagesetpixel($image, $dotX, $dotY, $textColor);
    imageline($image, $sX, $sY, $eX, $eY, $textColor);
}
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
