<?php 

/*
    Create images on the fly.  
    
    Requires PHP4 compiled with gd support and ttf libraries.  
    Also requires variables_from_uri.inc available from 
    http://www.nirvani.net/software/variables_from_uri/.
    
    This may work with PHP3+gd+ttf, but it is not tested.  If anyone can 
    verify that it works with PHP3, please let me know.  Thanks.

    Copyright 2001 Jeremy Brand  <jeremy@nirvani.net>
    http://www.jeremybrand.com/Jeremy/Brand/Jeremy_Brand.html

    Image Create for PHP.
    Release 1.0.1
    http://www.nirvani.net/software/image_create/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

    ChangeLog:
    1.0.1:
      Added boolean flag for anti-aliasing. (flag name: a)
      Added PNG, Jpeg and Wbmp (for WAP phones) formats in addition 
        to original Gif support. (flag name: if)
      Added boolean flag for HTTP expires headers. (flag name: ex)
      Added autodetection and correction of missing image formats
        in the GD library.
      Image dimentions and size now fit the fonts better.
      Backwards compatibility maintained with 1.0.0.  You can 
        drop 1.0.1 in as a replacement for 1.0.0 and you will 
        not need to change anything.
    1.0.0:
      Initial release.

    INSTRUCTIONS FOR USE:

    Installation:
    1) Place a copy of this script on your PHP4 enabled 
       web server somewhere in the document root accessable
       to the world.
    2) Make a folder on your web server and copy some *.ttf (true 
       type font) files into this folder.  This is typically _not_
       located in the document root.
    3) Choose a folder where Image Create for PHP can create a
       cache file.  On unix a folder would have perms of something
       like 4757.
    4) Download a copy of variables from URI from 
       http://www.nirvani.net/software/variables_from_uri/.  
       Re-name the file variables_from_uri.inc and install it 
       somewhere on your web server.  Usually this is _not_ 
       installed in the docroot.
       

    Configuration:
    1) Change FONT_PATH to be the folder where fonts are installed (step
       2 above).  The folder name _must_ end with a slash /.
    2) Change FONT_CACHE_FILE_PATH to be the folder that will contain the 
       cache file (from step 3 above).  Again the folder name should 
       end in /.
    3) Choose a name for the cache file, or leave it anduse the default
       name.
    4) Change the include for variables_from_uri.inc to be the path
       and filename of where you installed variables from URI (from
       step 4 above).
    5) Scroll down to 'HOSTS' and add your web server's host name
       and any other host name that you want to be able to access
       these images.  Add the hosts as separate 'case' statements.


    If you've followed directions and it still doesn't work, you 
    probably don't have either PHP4, the GD library or TTF support
    in PHP.  Find your nearest guru.

    Example:
    <img src="http://www.yourserver.moc/image_create.php/a=0/if=1/br=192/bg=192/bb=192/fr=0/fg=0/fb=0/t=0/fs=35/fn=font_name/s=your_text_here">

    FLAGS
    -------------------------------------------------------------------------
    br, bg, bb -- Background red, green and blue (in decimal).
                  0 thru 255 [default is 255]
    fr, fg, fb -- Foreground red, green and blue (in decimal).
                  0 thru 255 [default is 0]
    t          -- Boolean flag for transarency.
                  0 == non-transparent. [default]
                  1 == transparent.or 1.  
                    Transparency (obviously) only works with indexed
                    file formats.  For example, it does not work with Jpegs.
    fs         -- Font size (decimal).
                  1 thru 150 [default is 20]
    fn         -- Font name (check your cache file for font names after 
                     you have ran this script once).
                  [default is first font in cache file]
    s          -- The string to turn into an image.
                  [required flag] 
    a          -- Boolean flag for anti-aliasing.  
                  0 == off.
                  1 == on. [default]
    ex         -- Send HTTP headers for expiration.
                  0 == expires never [default] (one year: see rfc2616).
                  1 == expires emediately.
    if         -- Image format.
                  0 == gif. [default]
                  1 == png.
                  2 == jpg.
                  3 == wbmp (mostly for wap phones)
                    If the GD library does not support your chosen 
                    image format, this program will cycle through
                    starting at 0 and send the first available
                    image format.  This way, you don't have to worry 
                    (as much) about what formats work on the specific
                    PHP build.
    -------------------------------------------------------------------------

    Notes: 
    If you add more true type fonts to your folder, simply
    delete the cache file (where ever you defined it to be)
    and it will be re-created with the new font listings.
*/

  /********************************************************************/
  /* ENABLE DEBUGGING?  Debugging goes in HTTP headers.               */
  /********************************************************************/
  define('DEBUG', FALSE);

  /********************************************************************/
  /* Set up some software variables.                                  */
  /********************************************************************/
  define('SOFTWARE_NAME', 'Image Create for PHP');
  define('VERSION_STRING','1.0.1');
  define('VENDOR_STRING','Jeremy Brand; www.jeremybrand.com');

  /********************************************************************/
  /**** FONT_CACHE_FILE_PATH MUST BE WRITEABLE BY YOUR WEB SERVER  ****/
  /********************************************************************/
  define('FONT_PATH', '/home/nirvani/fonts/');
  define('FONT_CACHE_FILE_PATH', '/home/nirvani/cache/');
  define('FONT_CACHE_FILE', 'font_cache.php');

  /********************************************************************/
  /****       REQUIRES "variables_from_uri.inc"                    ****/
  /****  AVAILABLE FROM http://www.nirvani.net/software/           ****/
  /****  DOWNLOAD IT AND SAVE IT SOMEWHERE ON YOUR SERVER.         ****/
  /****  MAKE SURE THE FOLLOWING INCLUDE() HAS THE CORRECT PATH    ****/
  /********************************************************************/
  include('/home/nirvani/includes/variables_from_uri.inc');

  /********************************************************************/
  /* Set the default values.                                          */
  /********************************************************************/
  $a  = 1;
  $if = 0;
  $br = $bg = $bb = 255;
  $fr = $fg = $fb = 0;
  $fs = 20;
  $fn = 0;
  $t  = 0;
  $ex = 0;

  /********************************************************************/
  /* Set the rest of the flags and overwrite the default from the     */
  /* URL by running variables_from_uri().                             */
  /********************************************************************/
  variables_from_uri('=','a,if,s,br,bg,bb,fr,fg,fb,fs,fn,t,ex');

  /********************************************************************/
  /**** THIS WILL AUTOMATICALLY DEFINE THE FONTS THAT CAN BE USED  ****/
  /**** WITH THIS SCRIPT                                           ****/
  /********************************************************************/
  if (!file_exists(FONT_CACHE_FILE_PATH . FONT_CACHE_FILE))
  {
    $fd = fopen(FONT_CACHE_FILE_PATH . FONT_CACHE_FILE, 'w');
    if ($fd)
    {
      $buf = <<<EOT
<?php

EOT;
      $dir = dir(FONT_PATH);
      $count = 0;
      while($entry = $dir->read())
      {
        if (eregi('\.ttf$',$entry))
        {
          $short_name = str_replace(' ','_',strtolower(eregi_replace('\.ttf$','',$entry)));
          $buf .= <<<EOT
  \$fonts_array[$count] = '$entry';
  \$fonts_array['$short_name'] = '$entry';

EOT;
          $count++;
        }
      }
      $dir->close();
      $buf .= <<<EOT
?>
EOT;
      fwrite($fd, $buf, strlen($buf));
      fclose($fd);
    }
  }
  include(FONT_CACHE_FILE_PATH . FONT_CACHE_FILE);

  /********************************************************************/
  /**** Add multiple cases for HOSTS allowed to view this          ****/
  /**** so nobody links to your images, taking up your CPU,        ****/
  /**** etc without you knowing                                    ****/
  /********************************************************************/
  $url_array = parse_url($HTTP_REFERER);
  switch (strtolower($url_array['host']))
  {
  /********************************************************************/
  /****     ADD MORE 'CASE - BREAK' STATEMENTS HERE                ****/
  /****     FOR HOSTS YOU WANT TO ALLOW TO USE THIS SCRIPT         ****/
  /********************************************************************/
    case 'www.yourserver.moc':
    case 'yourserver.moc':
    case 'www2.yourserver2.moc':
    case 'www3.yourserver.moc':
    case 'jeremybrand.com':
    case 'www.jeremybrand.com':
    case 'www.nirvani.net':
    case 'hackor.com':
    case 'google.com':      /* Allow viewing from google cache.  */
    case 'www.google.com':  /* It's just a good idea.            */
      break;

    /********************************************************************/
    /**** BLANK IS TO ALLOW SIMPLE VIEWING OF ONLY THIS IMAGE        ****/
    /********************************************************************/
    case '':  
      break;

    /********************************************************************/
    /**** THE DEFAULT IS TO EXIT THE SCRIPT, NO BANDWITH OR ANY      ****/
    /**** MORE CPU FOR UNAUTHORIZED LINKING TO THIS SCRIPT...        ****/ 
    /********************************************************************/
    default:
      exit();
      break;
  }

  /* SANITY CHECKING */
  $error = 0;
  if ($fs <1 || $fs > 150) 
    $error += 1;

  if (($br <0 || $br > 255) || ($bg <0 || $bg > 255) || ($bb <0 || $bb > 255))
    $error += 2;

  if (($fr <0 || $fr > 255) || ($fg <0 || $fg > 255) || ($fb <0 || $fb > 255))
    $error += 4;
  
  if (!strlen($s))
    $error += 8;

  if (!strlen($fonts_array[$fn]))
    $error += 16;

  if ((int)$if>3 || (int)$if<0)
    $error += 32;

  if ($error)
    exit();
  /* You may want to do something other than exit, but that was good    */
  /* enough for me.                                                     */

  /**********************************************************************/
  /* This function (tries) to get the width of the canvas you will need */
  /* to draw your image based on the font and text                      */
  /**********************************************************************/
  function get_width($array)
  {
    $width = abs(($array[2]) + ($array[0]));
    return $width*1.10;
  }

  /************************************************************************/
  /* This function (tries) to get the height of the canvas you will need  */
  /* to draw your image based on the font and text                        */
  /************************************************************************/
  function get_height($array)
  {
    $height = abs($array[5])+abs($array[3]);
    return $height*1.30;
  }

  /************************************************************************/
  /* Set up the image format array to handle the HTTP headers and the     */
  /* call to the appropriate rendering function.                          */
  /* 'ext' is not yet used, but planned for future cacheing of images     */
  /************************************************************************/
  $format_array = array(
    0 => array(
           'mime-type' => 'image/gif',
           'gd_image'  => 'ImageGif',
           'ext'       => 'gif'
    ),
    1 => array(
           'mime-type' => 'image/png',
           'gd_image'  => 'ImagePng',
           'ext'       => 'png'
    ),
    2 => array(
           'mime-type' => 'image/jpeg',
           'gd_image'  => 'ImageJpeg',
           'ext'       => 'jpg'
    ),
    3 => array(
           'mime-type' => 'image/vnd.wap.wbmp',
           'gd_image'  => 'ImageWbmp',
           'ext'       => 'wbmp'
    )
  );

  /********************************************************************/
  /* NOTHING NEEDS TO BE EDITED BELOW HERE.                           */
  /********************************************************************/

  /********************************************************************/
  /* FINALY GET TO THE GOOD STUFF... BASICALLY EVERYTHING STARTS HERE */
  /********************************************************************/

  /********************************************************************/
  /* This picks a time for the cache to start and rounds the value    */
  /* so that the expire HTTP header functionality does what is        */
  /* expected.                                                        */
  /********************************************************************/
  $ts = gmmktime();
  $ts /= 10000; 
  $ts = round($ts);
  $ts *= 10000;

  if (DEBUG)
  {
    header("XX-String: $s");
    header("XX-Vars: a=$a if=$if br=$br bg=$bg bb=$bb fr=$fr fg=$fg fb=$fb t=$t fs=$fs fn=$fn ex=$ex");
  }
  header('Last-Modified: ' . date('D, d M Y H:i:s',$ts) . ' GMT');
  if ($ex)
  {
    header('Expires: ' . date('D, d M Y H:i:s',$ts) . ' GMT');
    header('Cache-Control: must-revalidate, no-cache');
    header('Pragma: no-cache');
  }
  else
    header('Expires: ' . date('D, d M Y H:i:s',$ts+31536000) . ' GMT');
  header('XX-Font-Name: ' . $fonts_array[$fn]);
  header('XX-Software: ' . SOFTWARE_NAME); 
  header('XX-Version: ' . VERSION_STRING); 
  header('XX-Vendor: ' . VENDOR_STRING); 
  header('Connection: close');
  header('Content-Type: '.$format_array[$if]['mime-type']);

  $array = imagettfbbox($fs, 0, FONT_PATH.$fonts_array[$fn], $s.'l');
  $im = imagecreate(get_width($array),get_height($array));
  $bg = ImageColorAllocate($im, $br,$bg,$bb);
  $fg = ImageColorAllocate($im, $fr,$fg,$fb);
  if ((int)$t)
    $trans = imagecolortransparent($im, $bg);
  if (!(int)$a)
    $fg = 0 - $fg; 
  // good - ImageTTFText($im, $fs, 0, abs($array[0])*2, abs($array[5]), $fg, FONT_PATH.$fonts_array[$fn], $s);
  ImageTTFText($im, $fs, 0, -($array[6]), -($array[7]), $fg, FONT_PATH.$fonts_array[$fn], $s);
  if (!@$format_array[$if]['gd_image']($im))
  {
    for ($i=0; $i<=3; $i++)    
    {
      header('Content-Type: '.$format_array[$i]['mime-type']);
      if (@$format_array[$i]['gd_image']($im))
        break;
    }
  }
  ImageDestroy($im);

?>
