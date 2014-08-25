<?php
// Set the static variables (discussed in step 3)
$font_file = "/home/ftpusers/lolopotu/web/webfolio/fonts/arial.ttf";
$font_size = 13;
$hauteur = 20;
$angle = 0;
$y_start = 16;
$text2 = stripslashes($text);
$double_text = $text2;

// Create image and allocate colors (discussed in step 1)
$im = imagecreate($max_width, $hauteur);
$matte = imagecolorallocate($im, 153, 153, 153);
$background = imagecolorallocate($im, 255, 255, 255);
$outline = imagecolorallocate($im, 0, 0, 0);
$hilite = imagecolorallocate($im, 240, 240, 240);
$shadow = imagecolorallocate($im, 137, 137, 137);
$text_color = imagecolorallocate($im, 0, 0, 0);

// Draw the button (discussed in step 1)
imagefilledrectangle($im, 3, 1, $max_width-2, $hauteur-2, $background); 
/*imageline($im, 0, 14, $max_width-1, 14, $outline);
imageline($im, 0, 12, $max_width-1, 12, $hilite);
imageline($im, 0, 13, $max_width-1, 13, $shadow); */

// Position the text (discussed in step 3)
$line_width = imagettfbbox($font_size, 0, $font_file, $text2);
$horz_pos = (($max_width - $line_width[2] - $line_width[0]) / 2);

// Write the text to the image (discussed in step 4)
imagettftext($im, $font_size, $angle, 5, $y_start, $text_color, $font_file, $double_text);

// Display and destroy the image (discussed in steps 5 and 6)
header("Content-type:image/png");
imagepng($im);
imagedestroy($im);
?>