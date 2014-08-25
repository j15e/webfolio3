<?php

function text2image($mytext,$imwidth,$imheight) {
	if (!empty($mytext)) {
		if (empty($imwidth)) $imwidth=300;
		if (!isset($imheight)) $imheight=200;
		Header("Content-type: image/Jpeg");
		$im = @ImageCreate ($imwidth=300, $imheight) or die ("Cannot Initialize new GD image stream");
		$background_color = ImageColorAllocate ($im, 255, 211, 155);
		$text_color = ImageColorAllocate ($im, 0, 0, 0);
		$mytext = stripslashes($mytext);
		$mytext = ereg_replace("\r\n","\n",$mytext) ;
		$count=5;
		$returns = explode("\n", $mytext);
		while(list($k, $mytext) = each($returns))	{
			$count = $count;
			$insert_text = substr($mytext, 0);
			ltrim($insert_text);
			ImageString ($im, 2, 5,$count, $insert_text, $text_color);
			imagerectangle ($im, 2, 2, $imwidth-2, $imheight-2, $text_color);
			$count=$count+13;
		}
		ImageJpeg($im);
		ImageDestroy;
	}
}
#echo "<!-- by michael@phpdevshed.com -->";
text2image($mytext,$imwidth,$imheight);

?>
