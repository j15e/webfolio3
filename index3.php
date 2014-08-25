<?php
	if(!isset($_GET['page']))
        $_GET['page']="projet";
	include (("includes/").$_GET['page'].(".inc.php"))
?>
