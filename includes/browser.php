<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Image</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<? 
$size = getimagesize("../images/generateur/$image");
$LLL = $size[0]+22;
$HHH = $size[1]+26;
//onload="window.resizeTo('.$LLL.','.$HHH.')" 
echo '<body background="../images/back.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">';
?>
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center"><a href="javascript:window.close()"><img src="../images/generateur/webfolio1.php?image=<? echo $image; ?>" hspace="0" vspace="0" border="0" align="middle"></a></div></td>
    </tr>
  </table>
</div>
</body>
</html>
