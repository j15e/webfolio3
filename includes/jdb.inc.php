<div align="left">
  <?php include("haut.php"); ?>
  <?php include("jdb/config.php"); ?>
<? // connexion
@mysql_connect($host,$user,$pass)
   or die("Impossible de se connecter");
@mysql_select_db("$bdd")
   or die("Impossible de se connecter");
?>
  <table width="499" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="8" height="4" background="images/imgset2__08.png"><IMG SRC="images/imgset2__03.png" WIDTH=8 HEIGHT=4 ALT=""></td>
      <td width="480" height="4" background="images/imgset2__04.png"> </td>
      <td width="10"><IMG SRC="images/imgset2__06.png" WIDTH=6 HEIGHT=4 ALT=""></td>
    </tr>
    <tr>
      <td valign="middle" background="images/imgset2__26.png"><IMG SRC="images/imgset2__22.png" WIDTH=8 HEIGHT=6 ALT=""></td>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="back3.png">
          <tr>
            <td bgcolor="#FFFFFF"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong>Journal
                de bord</strong></font></div></td>
          </tr>
          <?php
// sélectionne toutes les fiches de la table $table
$query = "SELECT * FROM $table_z ORDER BY $class DESC LIMIT 0,$maxi;";
$result = mysql_query($query);
// tant qu'il y a des fiches
while ($val = mysql_fetch_array($result)) { ?>
          <tr bgcolor="#FFFFFF" background="back.png">
            <td height="3" background="images/imgset2__04.png"> </td>
          </tr>
          <tr>
            <td> <font face="Arial, Helvetica, sans-serif">
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
            '<a href="\\1://\\2" target="_blank">\\1://\\2</a>', $textet); ?>
              <font size="2"><strong><? echo $val["titre_fr"]; ?></strong> par
              <? if ($checkup5["email"] != "") echo "<a href=mailto:".$checkup5['email']." >"; ?>
              <? echo $val["auteur"]; ?>
              <? if ($checkup5["email"] != "") echo"</a>"; ?>
              le <? echo $val["date"]; ?></font><br>
              <font size="2"><? echo $textet; ?></font></font></td>
          </tr>
          <? }; ?>
        </table>
      </td>
      <td background="images/imgset2__16.png"><IMG SRC="images/imgset2__24.png" WIDTH=6 HEIGHT=6 ALT=""></td>
    </tr>
    <tr>
      <td><div align="left"><IMG SRC="images/imgset2__28.png" WIDTH=8 HEIGHT=4 ALT=""></div></td>
      <td height="4" background="images/imgset2__29.png"> </td>
      <td valign="top"><IMG SRC="images/imgset2__31.png" WIDTH=6 HEIGHT=4 ALT=""></td>
    </tr>
  </table>
<?php include("bas.php"); ?>
