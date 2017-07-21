<?php
/* $Id: agencies.php,v 1.1.1.1 2003/06/02 21:35:02 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Agencies");
$template = 'agencies.tpl';


$query = "SELECT AGENCY.ID as ID, AGENCY.Name as Name, Count(JOB.ID) as JobCount
	  FROM AGENCY,JOB
	  WHERE AGENCY.ID > 0 AND JOB.Agency_ID = AGENCY.ID 
	  GROUP BY AGENCY.ID
	  ORDER BY Name";
$result = $dbh->execute($query);
$agencies = $dbh->fetch_all_assoc($result);
$dbh->free_result($result);
$count=0;
foreach($agencies as $agency){
	$query="SELECT COUNT(*) as agents FROM AGENT WHERE Agency_ID = " . $agency{ID};
	$result = $dbh->execute($query);
	$agent = $dbh->fetch_assoc($result);
	$dbh->free_result($result);
	$agencies[$count++]{AgentCount} = $agent{agents};
}
$smarty->assign('AgencyList' ,$agencies);

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
