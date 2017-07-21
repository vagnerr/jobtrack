<?php
/* $Id: keywords.php,v 1.1.1.1 2003/06/02 21:35:11 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Keywords");
$template = 'keywords.tpl';


$query = "SELECT KEYWORD_CONST.ID as ID, Keyword, Count(Job_ID) as JobCount
	  FROM KEYWORD_CONST,KEYWORD_LNK 
	  WHERE KEYWORD_LNK.Keyword_ID = KEYWORD_CONST.ID
	  GROUP BY ID
	  ORDER BY Keyword";
buildLoopByQuery(&$dbh,&$smarty,'KeywordList',$query);

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
