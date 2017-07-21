<?php
/* $Id: addnote.php,v 1.1.1.1 2003/06/02 21:35:02 vagnerr Exp $ */

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
$note = GET('Data');
$date_added = GET('AddDate');
if ($date_added == ""){
	//generate the date at this end
	$date_added = date("YmdHis");
}else{
	//need to reformat what i have been given
	if (($timestamp = strtotime($date_added)) === -1){
		#timestring faied
		$smarty->assign('LAST_RESULT_MESSAGE', "Add Failed: Invalid Date");
		$smarty->assign('LAST_RESULT_TYPE', "FAIL");
		$ok = 0;
	}else{
		$date_added = date("YmdHis", $timestamp);
	}
}//need to add test for short date here.
$agent_ID = GET('Agent_ID');
if($ok){
	// Add the agent if need be
	if ($agent_ID == -1 ){
		$newagent = GET('NewAgentName');
		if ($newagent == ""){
			$agent_ID=0;
		}else{
			//add the agent and get a new id for it
			//first grab agency ID
			$query = "SELECT Agency_ID from JOB where ID = " .$job_ID;
			$result = $dbh->execute($query);
			$line = $dbh->fetch_assoc($result);
			$agency_ID = $line{Agency_ID};
			$dbh->free_result($result);
			// now insert the agent
			$query = "INSERT INTO AGENT(Agency_ID,Name)
				  VALUES(".$agency_ID.",'".$newagent."')";
			$result = $dbh->execute($query);
			$agent_ID = $dbh->last_insert_ID();
			//and link it to the job
			$query = "INSERT INTO JOBAGENT_LNK(Job_ID,Agent_ID)
				  VALUES(".$job_ID.",".$agent_ID.")";
			$result = $dbh->execute($query);
		}
	}

	//OK now add the note
	$query = "INSERT INTO JOBNOTES(Job_ID,Agent_ID,AddDate,Data)
		  VALUES(".$job_ID.",".$agent_ID.",'".$date_added."','".$note."')";
	$result = $dbh->execute($query);

	$smarty->assign('LAST_RESULT_MESSAGE', "Added Successfully");
	$smarty->assign('LAST_RESULT_TYPE', "OK");

	//now update the status of the job, along with the last check and
	//next check dates
	$last_check = $date_added; // thery are the same effectivly
	$next_check = GET(NextCheck);
	if ($next_check == -1){
		// we dont want a next check (guess we are closing)
		$next_check = 0;
	}else{
		$next_check = date("Ymd",strtotime("+".$next_check." days"));
	}
	$next_action = GET(NextAction_ID);
	$new_status = GET(Status_ID);
	//Now perform the query to update the job
	$query = "UPDATE JOB SET
			DateLastChanged=".$last_check.",
			DateToCheck=".$next_check.",
			NextAction_ID=".$next_action.",
			Status_ID=".$new_status."
		 WHERE ID=".$job_ID;
	$result = $dbh->execute($query);



}

// Time to re-execute the jobdetail script
require('jobdetail.php');
$dbh->disconnect();

?>
