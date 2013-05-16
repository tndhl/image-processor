<?php
require_once 'Image.class.php';

$background = new Image('img/background.jpg');
$cookie = new Image('img/cookie.png');

// resize background to Cookie's width
$background->scaleToWidth($cookie->getWidth() + 100);

// Get Top, Left margin
// to position Cookie on the middle of Background
$marginX = ($background->getWidth() - $cookie->getWidth()) / 2;
$marginY = ($background->getHeight() - $cookie->getHeight()) / 2;
$background->mergeWith($cookie, $marginX, $marginY);

// Save image to file
$background->save('img/cookie_with_resized_background.jpg');

// Print image on screen
$background->printOut();
?>