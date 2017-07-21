<?php
/* $Id: locationdetail.php,v 1.1.1.1 2003/06/02 21:39:55 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$location_ID = GET(ID);
$smarty->assign('ID_FIELD', "ID=" . $location_ID . "&");

$main_clause = " AND JOB.Location_ID = " . $location_ID;
$count_clause = " WHERE JOB.Location_ID = " . $location_ID;
$smarty->assign('PageTitle', "Jobs By Location");

/*we dont need to know status when they will all be "open" */
$template = 'locationdetail.tpl';


process_job_list(&$dbh, &$smarty, $pager_size, $count_clause, $main_clause);

$query = "SELECT Value FROM LOCATION_CONST WHERE ID = " . $location_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$location = $line{Value};
$dbh->free_result($result);
$smarty->assign('Location' ,$location);
$smarty->assign('hide_Location',1);
$dbh->disconnect();
$smarty->display("skin:".$template);

?>
