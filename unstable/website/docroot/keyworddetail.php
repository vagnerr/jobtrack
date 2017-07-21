<?php
/* $Id: keyworddetail.php,v 1.1.1.1 2003/06/02 21:39:55 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$keyword_ID = GET(ID);
$smarty->assign('ID_FIELD', "ID=" . $keyword_ID . "&");

$main_clause = " AND KEYWORD_LNK.Job_ID = JOB.ID AND KEYWORD_LNK.Keyword_ID = " . $keyword_ID;
$count_clause = " WHERE KEYWORD_LNK.Job_ID = JOB.ID AND KEYWORD_LNK.Keyword_ID = " . $keyword_ID;
$extra_tables = " , KEYWORD_LNK ";
$smarty->assign('PageTitle', "Jobs By Keyword");
/*we dont need to know status when they will all be "open" */
$template = 'keyworddetail.tpl';


process_job_list(&$dbh, &$smarty, $pager_size, $count_clause, $main_clause, $extra_tables);

$query = "SELECT Keyword FROM KEYWORD_CONST WHERE ID = " . $keyword_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$keyword = $line{Keyword};
$dbh->free_result($result);
$smarty->assign('Keyword' ,$keyword);

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
