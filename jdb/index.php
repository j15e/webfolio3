<?php
   $monthes = array('', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil',
                            'Aoû', 'Sept', 'Oct', 'Nov', 'Déc');
   $days = array('Dim', 'Lun', 'Mard', 'Merc', 'Jeu', 'Ven', 'Sam');
   $date_first = $days[date('w')];
   $date_second = $monthes[date('n')];
   $dateajp = $date_first.' '.date('d').' '.$date_second.' '.date('Y');
?>
<?php include("config.php");
 // connexion
@mysql_connect($host,$user,$pass)
   or die("Impossible de se connecter");
@mysql_select_db("$bdd")
   or die("Impossible de se connecter");
//check
if (trim($userd) != "") {
$queryz = "SELECT * FROM `webfoliojdb_user`
WHERE `user` = '$userd' LIMIT 0, 30";
// sélectionne toutes les fiches de la table $table
$checkup2 = mysql_query($queryz);
?><? while ($checkup5 = mysql_fetch_array($checkup2)) {
/* echo "userd = $userd = ";
echo $checkup5["user"];
echo "<br>";
echo "passd = $passd = ";
echo $checkup5["password"];
echo "<br>";  */
if ($userd == $checkup5["user"] && $passd == $checkup5["password"] or $HTTP_COOKIE_VARS["adminqcrapnews"] == "ok2") { ?>
<?
$rerer = $checkup5["user"];
setcookie("adminqcrapnews","ok2",time()+3600*24);
setcookie("adminqcrapnewsuser","$rerer",time()+3600*24);
}; }; };?>
<? /*
echo $HTTP_COOKIE_VARS["adminqcrapnewsuser"];
echo $HTTP_COOKIE_VARS["adminqcrapnews"]; */
?>
<? if ($HTTP_COOKIE_VARS["adminqcrapnews"] == "ok2") { ?>
  <?php
  if ($mod != "")
  $query = "SELECT * FROM $table_z WHERE $id_tbl=$mod;";
  if ($mod != "")
$result = mysql_query($query); ?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
//Résultats
if ($mod != "")
$val_z = mysql_fetch_array($result);
if ($mod != "") echo '
<div align="center">
  <p><strong><font size="+1"><a href="index.php">Administration</a></font></strong></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="46" bgcolor="#999999"> <div align="center"><strong><font size="+1"><a name="mod"></a><a href="#all">Toutes les news
	  </a> | <a href="#add">Ajouter une news</a> | <a href="#mod">Modifier
          la news sélectioné</a></font></strong></div></td>
    </tr>
  </table>
  <p><strong></strong></p>
  </div>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td height="284">
      <form action="index.php" method="post" name="form2">
        <p align="center"><font size="+1">Modifier une news</font></p>
        <table width="500" border="0" align="center">
          <tr> <input name="mod2" type="hidden" value="'.$mod.'">
            <td width="140" valign="top" bordercolor="#999999"> <div align="right"><b>Titre
              : </b></div></td>
            <td><input type="text" name="titre_fr2" value="'.$val_z["$titre_fr_tbl"].'"></td>
          </tr>
          <tr>
            <td valign="top" bordercolor="#999999"> <div align="right"><b>Date:
                </b></div></td>
            <td><input type="text" value="'.$dateajp.'" name="date2">
            </td>
          </tr>
          <tr>
            <td valign="top" bordercolor="#999999"> <div align="right"><b>Contenue
                FR: </b></div></td>
            <td valign="top"> <textarea name="contenu_fr2" cols="60" rows="20">'.$val_z["$contenu_fr_tbl"].'</textarea></td>
          </tr>
          <tr>
            <td valign="top" bordercolor="#999999"></td>
          </tr>
        </table>
        <p align="center">
          <input type="submit" name="Submit" value="Modifier">
        </p>
</form>
</td>
</tr>
</table><br><br>';
if(isset($date2, $titre_fr2, $contenu_fr2))
mysql_query("UPDATE $table_z SET $date_tbl='$date2', $titre_fr_tbl='$titre_fr2', $contenu_fr_tbl='$contenu_fr2' WHERE $id_tbl=$mod2");
?>
  <?php
if(isset($date, $titre_fr, $contenu_fr))
	echo "<center><b><font size=5>Votre news a bien étée ajoutée.<br><br></font></b></center>";
if(isset($date, $titre_fr, $contenu_fr))
	mysql_query("INSERT INTO $table_z($auteur_tbl,$date_tbl,$titre_fr_tbl,$contenu_fr_tbl) VALUES('".$HTTP_COOKIE_VARS['adminqcrapnewsuser']."', '$date', '$titre_fr', '$contenu_fr')");
?>
<div align="center">
  <p><strong><font size="+1"><a href="index.php">Administration</a></font></strong></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="46" bgcolor="#999999"> <div align="center"><strong><font size="+1"><a name="add"></a><a href="#all">Toutes
          les news</a> | <a href="#add">Ajouter une news</a>
          <? if ($mod != "") echo ' | <a href="#mod">Modifier
          la news s&eacute;lectionn&eacute;</a>' ?>
          </font></strong></div></td>
    </tr>
  </table>
  <p><strong></strong></p>
  </div>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td height="284">
      <form action="index.php" method="post" name="form1">
        <p align="center"><font size="+1">Ajouter une news</font></p>
        <table width="500" border="0" align="center">
          <tr>
            <td width="140" valign="top" bordercolor="#999999"> <div align="right"><b>Titre
                : </b></div></td>
            <td><input type="text" name="titre_fr">
            </td>
          </tr>
          <tr>
            <td valign="top" bordercolor="#999999"> <div align="right"><b>Date:
                </b></div></td>
            <td><input type="text" value="<?php echo $dateajp; ?>" name="date">
            </td>
          </tr>
          <tr>
            <td valign="top" bordercolor="#999999"> <div align="right"><b>Contenue
                FR: </b></div></td>
            <td valign="top"> <textarea name="contenu_fr" cols="60" rows="20"></textarea></td>
          </tr>
        </table>
        <p align="center">
          <input type="submit" name="Submit" value="Ajouter">
        </p>
</form>
</td>
</tr>
</table>
<p>
</p>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="46" bgcolor="#999999">
      <div align="center"><strong><font size="+1"><a name="all" id="all"></a><a href="#all">Toutes
        les news</a> | <a href="#add">Ajouter une news</a>
        <? if ($mod != "") echo ' | <a href="#mod">Modifier
          la news s&eacute;lectionn&eacute;</a>' ?>
        </font></strong></div></td>
  </tr>
</table>
<p align="center"><font size="+1"><strong>Toutes les news</strong></font><br>
</p>
  <?php

// sélectionne toutes les fiches de la table $table
$query = "SELECT * FROM $table_z ORDER BY $class;";
$result = mysql_query($query);
mysql_query("DELETE FROM $table_z WHERE id='$del_id'");
// sélectionne toutes les fiches de la table $table

$queryz = "SELECT * FROM `qcrap_news_users` WHERE `user` = '".$HTTP_COOKIE_VARS['adminqcrapnewsuser']."' LIMIT 0, 1";
// sélectionne toutes les fiches de la table $table
$checkup2 = mysql_query($queryz);
$checkup5 = mysql_fetch_array($checkup2);
if ($checkup5["superadmin"] == "") {
$query = "SELECT * FROM $table_z WHERE auteur = '".$HTTP_COOKIE_VARS['adminqcrapnewsuser']."' ORDER BY $class;";
} else { $query = "SELECT * FROM $table_z ORDER BY $class DESC;"; };
$result = mysql_query($query);
// tant qu'il y a des fiches
while ($val = mysql_fetch_array($result)) { ?>
<table width="735" border="0" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td width="140" valign="top"> <div align="right"><b>Titre : </b></div></td>
    <td width="499"> <strong><font color="#FF0000"><? echo $val["$titre_fr_tbl"]; ?></font></strong></td>
    <td width="96" rowspan="6" align="right" valign="bottom"> <a onclick="if (window.confirm('Êtes vous sur de bien vouloir suprimmer cette news?')) {return true;} else {return false;}" href=?del_id=<? echo $val["$id_tbl"]; ?>>Suprimmer</a><br>
      <br> <br> <br> <a href=?mod=<? echo $val["$id_tbl"]; ?>>Modifier</a></td>
  </tr>
  <tr>
    <td valign="top"><div align="right"><strong>Auteur :</strong></div></td>
    <td><strong><font color="#FF0000"><? echo $val["$auteur_tbl"]; ?></font></strong></td>
  </tr>
  <tr>
    <td valign="top"> <div align="right"><b>Date : </b></div></td>
    <td> <? echo $val["$date_tbl"]; ?></td>
  </tr>
  <tr>
    <td height="61" valign="top"> <div align="right"><b>Contenue FR: </b></div></td>
    <td> <? echo $val["$contenu_fr_tbl"]; ?></td>
  </tr>
  <tr> </tr>
</table>
<br>
<?php
 }
?>
</table>
<?  }  else { ?>
<link href="../sheet.css" rel="stylesheet" type="text/css">
	 <form action="index.php" method="post" name="form1">
  <table class="classe" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;User :
          <input class="form" name="userd" type="text">
          <br>
          Password :
          <input name="passd" class="form" type="password">
          <br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form" name="Login" value="submit" type="submit">
        </div></td>
  </tr>
</table>
	 </form>
<? };
?>
