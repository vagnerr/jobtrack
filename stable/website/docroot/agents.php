<?php
/* $Id: agents.php,v 1.1.1.1 2003/06/02 21:35:04 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Agents");
$template = 'agents.tpl';


$query = "SELECT AGENT.ID as ID, AGENT.Name as Name, Count(Job_ID) as JobCount,
		 AGENCY.ID as Agency_ID, AGENCY.Name as AgencyName
	  FROM AGENT,AGENCY,JOBAGENT_LNK
	  WHERE AGENT.ID > 0 AND Agent_ID = AGENT.ID and Agency_ID=AGENCY.ID
	  GROUP BY Agent_ID
	  ORDER BY Name";
$result = $dbh->execute($query);
$agents = $dbh->fetch_all_assoc($result);
$dbh->free_result($result);
$smarty->assign('AgentList' ,$agents);

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
