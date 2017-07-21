<?php
/* $Id: sources.php,v 1.1.1.1 2003/06/02 21:40:00 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Sources");
$template = 'sources.tpl';


$query = "SELECT SOURCE_CONST.ID as ID, Description,
		 Count(JOB.ID) as JobCount
	  FROM SOURCE_CONST,JOB 
	  WHERE SOURCE_CONST.ID > 0 AND JOB.Source_ID = SOURCE_CONST.ID
	  GROUP BY JOB.Source_ID
	  ORDER BY Description";
buildLoopByQuery(&$dbh,&$smarty,'SourceList',$query);



$dbh->disconnect();
$smarty->display("skin:".$template);

?>
