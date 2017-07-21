<?php
/* $Id: activejobs.php,v 1.1.1.1 2003/06/02 21:39:47 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);



/*handle activejobs.php or alljobs.php*/
	$active_only = " AND Status_ID = 1 ";
	$Cactive_only = " WHERE Status_ID = 1 ";
	$smarty->assign('PageTitle', "Active Jobs");
	/*we dont need to know status when they will all be "open" */
	$smarty->assign('hide_Status',1);
	$template = 'activejobs.tpl';


process_job_list(&$dbh, &$smarty, $pager_size, $Cactive_only, $active_only);
$dbh->disconnect();
$smarty->display("skin:".$template);

?>
