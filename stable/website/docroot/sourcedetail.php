<?php
/* $Id: sourcedetail.php,v 1.1.1.1 2003/06/02 21:35:14 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$source_ID = GET(ID);
$smarty->assign('ID_FIELD', "ID=" . $source_ID . "&");

$main_clause = " AND JOB.Source_ID = " . $source_ID;
$count_clause = " WHERE JOB.Source_ID = " . $source_ID;
$smarty->assign('PageTitle', "Jobs By Source");

/*we dont need to know status when they will all be "open" */
$template = 'sourcedetail.tpl';


process_job_list($dbh, $smarty, $pager_size, $count_clause, $main_clause);

$query = "SELECT Description FROM SOURCE_CONST WHERE ID = " . $source_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$source = $line{Description};
$dbh->free_result($result);
$smarty->assign('Source' ,$source);
$smarty->assign('hide_Source',1);
$dbh->disconnect();
$smarty->display("skin:".$template);

?>
