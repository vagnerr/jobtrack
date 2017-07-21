<?php
/* $Id: jobdetail.php,v 1.1.1.1 2003/06/02 21:35:09 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$job_ID = GET(ID);

$dbh = new Database;
$dbh->connect($db);

$query = "SELECT JOB.ID as ID,
		date_format(DateAdded,'%Y-%m-%d') as DateAdded,
		date_format(DateLastChanged,'%Y-%m-%d') as DateLastChanged,
		date_format(DateToCheck,'%Y-%m-%d') as DateToCheck,
		date_format(DateOfInterview,'%Y-%m-%d %H:%i:%s') as DateOfInterview,
		JobTitle,
		Reference,
		LOCATION_CONST.Value as Location,
		LOCATION_CONST.ID as Location_ID,
		COMPANY.Name as CompanyName,
		COMPANY.ID as Company_ID,
		AGENCY.Name as AgencyName,
		AGENCY.ID as Agency_ID,
		STATUS_CONST.Description as Status,
		STATUS_CONST.ID as Status_ID,
		TYPE_CONST.Description as Type,
		TYPE_CONST.ID as Type_ID,
		SOURCE_CONST.Description as Source,
		SOURCE_CONST.ID as Source_ID,
		NEXTACTION_CONST.Description as NextAction,
		NEXTACTION_CONST.ID as NextAction_ID,
		Salary,
		Fake
	  FROM JOB, LOCATION_CONST, COMPANY, AGENCY,
		STATUS_CONST, TYPE_CONST, SOURCE_CONST, NEXTACTION_CONST
	  WHERE JOB.ID = " . $job_ID . " 
		AND LOCATION_CONST.ID = JOB.Location_ID
		AND COMPANY.ID = JOB.Company_ID
		AND AGENCY.ID = JOB.Agency_ID 
		AND STATUS_CONST.ID = JOB.Status_ID
		AND TYPE_CONST.ID = JOB.Type_ID
		AND SOURCE_CONST.ID = JOB.Source_ID
		AND NEXTACTION_CONST.ID = JOB.NextAction_ID";

$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);

$dbh->free_result($result);

// wipe the interview date if its blank
if($line{interview} == "0000-00-00 00:00:00"){
	$line{interview} = "";
}


foreach ($line as $key => $value){
	$smarty->assign($key, $value);
}
$agencyID = $line{Agency_ID};
$smarty->assign('NoteCount',getJobNotesCount($dbh,$job_ID));

$query = "SELECT AGENT.ID as ID, Name from AGENT, JOBAGENT_LNK
	  WHERE Agent_ID = AGENT.ID 
	  AND Job_ID = " . $job_ID . "
	  ORDER BY PrimaryAgent DESC";
$result = $dbh->execute($query);
global $agents; //need to make ganets global for our callback function
$agents = $dbh->fetch_all_assoc($result);
$dbh->free_result($result);
$smarty->assign('AgentList', $agents);

$primaryAgentID = $agents[0]{ID};
$smarty->assign('PrimaryAgentID',$primaryAgentID);


#sort "all" agents for our dropdown list
if($agencyID == 0){
	# ther eis no agency associated so we dont want
	# to pull all the nonrelated agents so just set
	# the current list
	$smarty->assign('AllAgentList',$agents);
}else{
	#we have a real agency so pull all the agents
	$query = "SELECT ID, Name FROM AGENT
		  WHERE Agency_ID = " . $agencyID;
	$result = $dbh->execute($query);
	$allagents = $dbh->fetch_all_assoc($result);
	$dbh->free_result($result);
	$smarty->assign('AllAgentList',$allagents);
	//buildLoopByQuery(&$dbh, &$smarty, 'allagents',$query);
	//$allagents = $smarty->get_template_vars('allagents'); // need it back :-)

	if($allagents && $agents){ // bothe need some content otherwise errors
        	$newagents = array_reverse(array_reverse(array_filter($allagents, "new_only")));
	}else{
		$newagents = $allagents;
	}
	$smarty->assign('NewAgentList',$newagents);
}


$query = "SELECT date_format(AddDate,'%e/%c/%Y %H:%i:%s') as AddDate,
	  Data,
	  AGENT.Name as AgentName,
	  AGENT.ID as Agent_ID,
	  JOBNOTES.ID as NoteID
	  FROM JOBNOTES, AGENT
	  WHERE Job_ID = " . $job_ID . "
	  AND AGENT.ID = JOBNOTES.Agent_ID
          ORDER BY JOBNOTES.AddDate";
$result = $dbh->execute($query);
$notes = $dbh->fetch_all_assoc($result);                     
$dbh->free_result($result);
$smarty->assign('JobNotesList', $notes);


$query = "SELECT KEYWORD_CONST.Keyword as Keyword, KEYWORD_CONST.ID as ID
	  FROM KEYWORD_LNK, KEYWORD_CONST
	  WHERE KEYWORD_LNK.Job_ID = " . $job_ID . "
	  AND KEYWORD_LNK.Keyword_ID = KEYWORD_CONST.ID";
$result = $dbh->execute($query);
$keywords = $dbh->fetch_all_assoc($result);                     
$dbh->free_result($result);
$smarty->assign('KeywordList', $keywords);


$query = "SELECT JOBDATA.ID as ID,
		 JOBDATA.Description as Description,
		 JOBDATATYPE_CONST.Description as Type
	  FROM JOBDATA, JOBDATATYPE_CONST
	  WHERE JOBDATA.Job_ID = " . $job_ID . "
	  AND JOBDATA.JobDataType_ID = JOBDATATYPE_CONST.ID";
$result = $dbh->execute($query);
$jobdata = $dbh->fetch_all_assoc($result);                     
$dbh->free_result($result);
$smarty->assign('JobDataList', $jobdata);

$query = "SELECT ID, Child_ID as Related_ID, Description 
	  FROM JOBRELATED_LNK
	  WHERE Parent_ID = " . $job_ID;
$result = $dbh->execute($query);
$related = $dbh->fetch_all_assoc($result);                     
$dbh->free_result($result);
$query = "SELECT ID, Parent_ID as Related_ID, Description
	  FROM JOBRELATED_LNK
	  WHERE Child_ID = " . $job_ID;
$result = $dbh->execute($query);
$related = array_merge($related , $dbh->fetch_all_assoc($result));
$dbh->free_result($result);
$smarty->assign('JobRelatedList', $related);


buildLoopByTable(&$dbh, &$smarty, "StatusList", "STATUS_CONST");
buildLoopByTable(&$dbh, &$smarty, "NextActionList", "NEXTACTION_CONST");
buildLoopByTable(&$dbh, &$smarty, "TypeList", "TYPE_CONST");
buildLoopByTable(&$dbh, &$smarty, "SourceList", "SOURCE_CONST");
buildLoopByQuery(&$dbh, &$smarty, "LocationList", "SELECT * FROM LOCATION_CONST ORDER BY Value");


$dbh->disconnect();

//$checkvar = $smarty->get_template_vars();
//echo "<pre>" . var_dump($checkvar) ."</pre>";
$smarty->assign('PageTitle',"Job Detail");
$smarty->display('skin:jobdetail.tpl');


// Callbvck funtions to extract the agents we already have
function new_only($element){
	global $agents;
	return (!in_array($element{ID}, array_map(getAgentIDs,$agents)));
}

function getAgentIDs($element){
	return $element{ID};
}

?>
