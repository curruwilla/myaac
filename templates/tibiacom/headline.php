<?php

if (strlen($_GET['t']) > 100) {
    $_GET['t'] = '';
}

// set font path
putenv('GDFONTPATH=' . __DIR__);

// create image
$image = imagecreatetruecolor(250, 28);

// make the background transparent
imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));

// set text
$font = getenv('GDFONTPATH') . DIRECTORY_SEPARATOR . 'martel.ttf';
imagettftext($image, 18, 0, 4, 20, imagecolorallocate($image, 240, 209, 164), $font, utf8_decode($_GET['t']));

// header mime type
header('Content-type: image/gif');

// save image
imagegif($image/*, $file*/);