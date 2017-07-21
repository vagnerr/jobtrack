<?php
/* $Id: removecompany.php,v 1.1.1.1 2003/06/02 21:39:57 vagnerr Exp $ */

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
$company_ID = GET('Company_ID');
//should probably test input but we are running this in a "safe" environment

//unlink the company from the job by updateing the Company_ID field
//in the job table
$query = "UPDATE JOB SET Company_ID=0 WHERE ID=" .$job_ID;
$result = $dbh->execute($query);

// Settup the "OK" message
$smarty->assign('LAST_RESULT_MESSAGE', "Company Removed Successfully");
$smarty->assign('LAST_RESULT_TYPE', "OK");


// Time to re-execute the jobdetail script
require('jobdetail.php');
$dbh->disconnect();

?>
