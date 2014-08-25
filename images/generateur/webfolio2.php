<?php
require("./phpWatermark.inc.php");
$wm = new watermark("image.png");
$wm->setPosition("BR");
$wm->setFixedColor("#ffffff");
$wm->setFixedColor(array(255, 255, 255));
$wm->addWatermark("| Webfolio 2003-2004 Secondaire 3 | Jean-Philippe Doyle |", "TEXT");
$im = $wm->getMarkedImage();
header("Content-type: image/png");
imagepng($im);

?>