<?php
/* $Id: locations.php,v 1.1.1.1 2003/06/02 21:35:11 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Locations");
$template = 'locations.tpl';


$query = "SELECT LOCATION_CONST.ID as ID, Value,
		 Count(JOB.ID) as JobCount
	  FROM LOCATION_CONST,JOB 
	  WHERE LOCATION_CONST.ID > 0 AND JOB.Location_ID = LOCATION_CONST.ID
	  GROUP BY JOB.Location_ID
	  ORDER BY Value";
buildLoopByQuery($dbh,$smarty,'LocationList',$query);



$dbh->disconnect();
$smarty->display("skin:".$template);

?>
