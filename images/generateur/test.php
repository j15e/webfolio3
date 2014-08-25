<?php
header("Content-type: image/png");
$insertfile = imageCreateFromPNG('image.png');
$insertfile_width = imagesx($insertfile);
$insertfile_height = imagesy($insertfile);
$newimage = imagecreateTrueColor($insertfile_width, $insertfile_height);
$newimage = ImageCreateFromPNG($_GET['src']);
$size = getimagesize($_GET['src']);
$dest_x = $size[0] - $insertfile_width - 5;
$dest_y = $size[1] - $insertfile_height - 5;
imageCopyMerge($newimage, $insertfile,$dest_x,$dest_y,0,0,$insertfile_width,$insertfile_height,100);
imagepng($newimage);
imagedestroy($newimage);
imagedestroy($insertfile);?>