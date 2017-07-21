<?php
/* $Id: companies.php,v 1.1.1.1 2003/06/02 21:35:05 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Companies");
$template = 'companies.tpl';


$query = "SELECT COMPANY.ID as ID, Name, Count(JOB.ID) as JobCount
	  FROM COMPANY,JOB 
	  WHERE COMPANY.ID > 0 AND JOB.Company_ID = COMPANY.ID
	  GROUP BY JOB.Company_ID
	  ORDER BY Name";
$result = $dbh->execute($query);
$companies = $dbh->fetch_all_assoc($result);
$dbh->free_result($result);
$smarty->assign('CompanyList' ,$companies);

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
