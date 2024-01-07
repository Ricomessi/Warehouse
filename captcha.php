<?php
session_start();

function acakCaptcha()
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $panjangAlpha = strlen($alphabet) - 2;

    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangAlpha);
        $pass[] = $alphabet[$n];
    }

    return implode($pass);
}

$code = acakCaptcha();
$_SESSION["code"] = $code;

$wh = imagecreatetruecolor(173, 50);

$bgc = imagecolorallocate($wh, 22, 86, 165);

$fc = imagecolorallocate($wh, 223, 230, 233);

imagefill($wh, 0, 0, $bgc);

imagestring($wh, 10, 50, 15, $code, $fc);

// Send the appropriate header to tell the browser that this is an image.
header('Content-Type: image/jpeg');

// Output the image
imagejpeg($wh);

// Destroy the image to free up memory
imagedestroy($wh);
