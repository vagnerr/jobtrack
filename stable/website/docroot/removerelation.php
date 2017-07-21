<?php
/* $Id: removerelation.php,v 1.1.1.1 2003/06/02 21:35:12 vagnerr Exp $ */

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
$relation_ID = GET('RelationID');
//should probably test input but we are running this in a "safe" environment

//unlink the relation from the job by deleting the row from the jobrelated_lnk
//table
$query = "DELETE FROM JOBRELATED_LNK WHERE ID = " . $relation_ID;
$result = $dbh->execute($query);


// Settup the "OK" message
$smarty->assign('LAST_RESULT_MESSAGE', "Relation Removed Successfully");
$smarty->assign('LAST_RESULT_TYPE', "OK");


// Time to re-execute the jobdetail script
require('jobdetail.php');
$dbh->disconnect();

?>
