<?php
/* $Id: removekeyword.php,v 1.1.1.1 2003/06/02 21:35:12 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

$ok = 1;

// sort our inputs
$job_ID = GET('ID');
$keyword_ID = GET('KeywordID');
//should probably test input but we are running this in a "safe" environment

//unlink the keyword from the job by deleting the row from the keyword_lnk
//table
$query = "DELETE FROM KEYWORD_LNK WHERE Job_ID = " .$job_ID ."
		AND Keyword_ID = " . $keyword_ID;
$result = $dbh->execute($query);

// we must now check that there is still at least one job linked
//to the keyword, if not we will need to remove the keyword as well.
$query = "SELECT * FROM KEYWORD_LNK WHERE Keyword_ID = " . $keyword_ID;
$result = $dbh->execute($query);
$keywords = $dbh->fetch_all_assoc($result);
$dbh->free_result($result);

if(!$keywords){
	//we got no rows back so we need to remove the keyword
	$query = "DELETE FROM KEYWORD_CONST WHERE ID = ".$keyword_ID;
	$result = $dbh->execute($query);
}


// Settup the "OK" message
$smarty->assign('LAST_RESULT_MESSAGE', "Keyword Removed Successfully");
$smarty->assign('LAST_RESULT_TYPE', "OK");


// Time to re-execute the jobdetail script
require('jobdetail.php');
$dbh->disconnect();

?>
