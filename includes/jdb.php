<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../sheet.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#999999" class="classe">
<?php include("../jdb/config.php"); ?>
<? // connexion
@mysql_connect($host,$user,$pass)
   or die("Impossible de se connecter");
@mysql_select_db("$bdd")
   or die("Impossible de se connecter");
?>
<table class="classe" border="0" cellspacing="0" cellpadding="0">
<td width="210" valign="top" bgcolor="#999999">
      <div align="center">
        <font color="#000000"><strong>
        </strong></font></div>
<?php
// sélectionne toutes les fiches de la table $table
$query = "SELECT * FROM $table_z ORDER BY $class DESC LIMIT 0,$maxi;";
$result = mysql_query($query);
echo '<table class="classe" width="210" border="0" cellspacing="0" cellpadding="0">';
// tant qu'il y a des fiches
while ($val = mysql_fetch_array($result)) { ?>
<?
$queryz = "SELECT * FROM `webfoliojdb_user` WHERE `user` = '".$val['auteur']."' LIMIT 0, 1";
// sélectionne toutes les fiches de la table $table
$checkup2 = mysql_query($queryz);
$checkup5 = mysql_fetch_array($checkup2);



// urls automatique
$textet = eregi_replace('([[:space:]]|^)(www)', '\\1http://\\2', $val["contenu_fr"]);
$prefixt = '(http|https|ftp|telnet|news|gopher|file|wais)://';
$pureUrlt = '([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)';
$textet = eregi_replace($prefixt.$pureUrlt,
            '<a href="\\1://\\2" target="_blank">\\1://\\2</a>', $textet);


?>
<tr>
            <td>
			<center>........................................................................</center>
			<font color="#FFFFFF"><? echo $val["titre_fr"]; ?> par <? if ($checkup5["email"] != "") echo "<a href=mailto:".$checkup5['email']." >"; ?>
			<? echo $val["auteur"]; ?><? if ($checkup5["email"] != "") echo"</a>"; ?> le <? echo $val["date"]; ?></font><br>
				<font color="#333333"><? echo $textet; ?></font><br>
              </td>
          </tr>
<? }; ?>
<tr>
<td>
<center>........................................................................</center>
</td>
</tr>
</table>
</td>
</table>
<? mysql_close(); ?>
</body>
</html>
