<?php

$page = (int)(!isset($_GET["pages"]) ? 1 : $_GET["pages"]);
if ($page <= 0) $page = 1;
 
/*$per_page = $PAGINATION_PERPAGE;// Set how many records do you want to display per page.
*/ 

$per_page=5;
$startpoint = ($page * $per_page) - $per_page;

?>