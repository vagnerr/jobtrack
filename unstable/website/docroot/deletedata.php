<?php
/* $Id: deletedata.php,v 1.1.1.1 2003/06/02 21:39:51 vagnerr Exp $ */

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
$data_ID = GET('DataID');
//should probably test input but we are running this in a "safe" environment

//delete the data  from the jobdata table by deleting the row , We may
//want to implement some kind of are you sure popup seeing as this data
//is difficult to recrete once gone. Also we may waht to cascade delete
//data in the future if we for example have a webpage and all its
//images stored 
$query = "DELETE FROM JOBDATA WHERE ID = " . $data_ID;
$result = $dbh->execute($query);


// Settup the "OK" message
$smarty->assign('LAST_RESULT_MESSAGE', "Data Removed Successfully");
$smarty->assign('LAST_RESULT_TYPE', "OK");


// Time to re-execute the jobdetail script
require('jobdetail.php');
$dbh->disconnect();

?>
