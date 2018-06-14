<?php
/* $Id: agentdetail.php,v 1.1.1.1 2003/06/02 21:35:04 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

$agent_ID = GET(ID);
$smarty->assign('ID',$agent_ID);
$smarty->assign('ID_FIELD', "ID=" . $agent_ID . "&");

$main_clause = " AND JOBAGENT_LNK.Job_ID = JOB.ID AND JOBAGENT_LNK.Agent_ID = " . $agent_ID;
$count_clause = " WHERE Job_ID = JOB.ID AND Agent_ID = " . $agent_ID;
$extra_tables = " , JOBAGENT_LNK ";
$smarty->assign('PageTitle', "Agent Details");
/*we dont need to know status when they will all be "open" */
$smarty->assign('hide_Agent',1);
$smarty->assign('hide_Agency',1);
$template = 'agentdetail.tpl';


process_job_list($dbh, $smarty, $pager_size, $count_clause, $main_clause, $extra_tables);


$query = "SELECT Name FROM AGENT WHERE ID = " . $agent_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$name = $line{Name};
$dbh->free_result($result);
$smarty->assign('Name', $name);

$query = "SELECT AGENTCONTACT_LNK.ID as ID, Description, Data, Keyword,
	  CONTACTTYPE_CONST.ID as ContactType_ID
	  FROM AGENTCONTACT_LNK, CONTACTTYPE_CONST
	  WHERE ContactType_ID = CONTACTTYPE_CONST.ID
	  AND Agent_ID = " . $agent_ID . "
	  ORDER BY CONTACTTYPE_CONST.ID";
buildLoopByQuery($dbh,$smarty,'AgentContactList',$query);
buildLoopByTable($dbh,$smarty,'ContactTypeList','CONTACTTYPE_CONST');

$query = "SELECT AGENCY.ID as ID, AGENCY.Name AS Name from AGENCY, AGENT
          WHERE Agency_ID = AGENCY.ID AND AGENT.ID = " . $agent_ID;
$result = $dbh->execute($query);
$agency = $dbh->fetch_assoc($result);
$dbh->free_result($result);
#grab the agents contact details
	$agencyID = $agency{ID};
	$query = "SELECT CONTACTTYPE_CONST.Description as Description,
			 CONTACTTYPE_CONST.Keyword as Keyword,
			 AGENCYCONTACT_LNK.Data as Data
		  FROM CONTACTTYPE_CONST,AGENCYCONTACT_LNK
		  WHERE ContactType_ID = CONTACTTYPE_CONST.ID
		  AND Agency_ID = " . $agencyID;
	$result = $dbh->execute($query);
	$aycontacts = $dbh->fetch_all_assoc($result);
	$dbh->free_result($result);
	$agency{ContactList}=$aycontacts;

$smarty->assign('Agency', $agency);


$dbh->disconnect();
$smarty->display("skin:".$template);

?>
