<?php
/* $Id: agencydetail.php,v 1.1.1.1 2003/06/02 21:39:48 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

$agency_ID = GET(ID);
$smarty->assign('ID',$agency_ID);
$smarty->assign('ID_FIELD', "ID=" . $agency_ID . "&");

$main_clause = " AND Agency_ID = " . $agency_ID;
$count_clause = " WHERE Agency_ID = " . $agency_ID;
$smarty->assign('PageTitle', "Agency Details");
/*we dont need to know status when they will all be "open" */
$smarty->assign('hide_Agency',1);
$template = 'agencydetail.tpl';


process_job_list(&$dbh, &$smarty, $pager_size, $count_clause, $main_clause);


$query = "SELECT Name FROM AGENCY WHERE ID = " . $agency_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$name = $line{Name};
$dbh->free_result($result);
$smarty->assign('Name', $name);

$query = "SELECT AGENCYCONTACT_LNK.ID as ID, Description, Data, Keyword,
          CONTACTTYPE_CONST.ID as ContactType_ID
	  FROM AGENCYCONTACT_LNK, CONTACTTYPE_CONST
	  WHERE ContactType_ID = CONTACTTYPE_CONST.ID
	  AND Agency_ID = " . $agency_ID . "
	  ORDER BY CONTACTTYPE_CONST.ID";
buildLoopByQuery(&$dbh,&$smarty,'AgencyContactList',$query);
buildLoopByTable(&$dbh,&$smarty,'ContactTypeList','CONTACTTYPE_CONST');

$query = "SELECT AGENT.ID as ID, Name from AGENT
          WHERE Agency_ID = " . $agency_ID;
$result = $dbh->execute($query);
$agents = $dbh->fetch_all_assoc($result);
$dbh->free_result($result);
#grab the agents contact details
$count=0;
foreach ($agents as $agentline){
	$agentID = $agentline{ID};
	$query = "SELECT CONTACTTYPE_CONST.Description as Description,
			 CONTACTTYPE_CONST.Keyword as Keyword,
			 AGENTCONTACT_LNK.Data as Data
		  FROM CONTACTTYPE_CONST,AGENTCONTACT_LNK
		  WHERE ContactType_ID = CONTACTTYPE_CONST.ID
		  AND Agent_ID = " . $agentID;
	$result = $dbh->execute($query);
	$atcontacts = $dbh->fetch_all_assoc($result);
	$dbh->free_result($result);
	$agents[$count++]{ContactList}=$atcontacts;
}
$smarty->assign('AgentList', $agents);


$dbh->disconnect();
$smarty->display("skin:".$template);

?>
