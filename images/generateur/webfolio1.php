<?php
require("phpwatermark.inc.php");
$wm = new watermark($image);
$wm->setPosition("TR");
   $imgk[] = "wf2.png";
   $imgk[] = "wf3.png";
   $imgk[] = "wf4.png";
   $imgk[] = "wf5.png";
   $imgk[] = "wf6.png";
   $imgk[] = "wf7.png";
 srand((double)microtime()*1000000); 
 $num = rand(0,sizeof($imgk)-1); 
$wm->addWatermark("../".$imgk[$num]."", "IMAGE");
$im = $wm->getMarkedImage();
header("Content-type: image/png");
imagepng($im);?>