<?php
/* $Id: jsareport.php,v 1.1.1.1 2003/06/02 21:39:54 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "JSA Report");
if (!GET(Date)){
	# we dont have a date so just display the question and exit
	$template = 'jsareportgetdate.tpl';
	$smarty->display("skin:".$template);
	exit();
}else{
	#split up the date are create the two date strings needed
	$dateparts = explode("-",GET(Date));

	$lastdate = sprintf("%4d-%02d-%02d",$dateparts[0],$dateparts[1],$dateparts[2]);
	$lastdaterev = sprintf("%02d-%02d-%4d",$dateparts[2],$dateparts[1],$dateparts[0]);
}

#we want to override the pager code for the report
$pager_size=0;

/*handle activejobs.php or alljobs.php*/
	$active_only = " AND (TO_DAYS(DateAdded) >= TO_DAYS('". $lastdate ."') 
			 OR TO_DAYS(DateLastChanged) >= TO_DAYS('". $lastdate ."')) ";
	$Cactive_only = " WHERE TO_DAYS(DateAdded) >= TO_DAYS('". $lastdate ."') "; 
	$order_by = " (TO_DAYS(DateAdded) < TO_DAYS('". $lastdate ."')), 
		      (Status_ID != 1) , DateAdded ";
	$template = 'jsareport.tpl';


$joblist = process_job_list(&$dbh, &$smarty, $pager_size, $Cactive_only,
			 $active_only, "", $order_by);

$count = 0;
foreach ($joblist as $job){
	$query = "SELECT date_format(AddDate,'%e/%c/%Y') as AddDate,
		  Data,
		  AGENT.Name as AgentName,
		  AGENT.ID as Agent_ID,
		  JOBNOTES.ID as NoteID
		  FROM JOBNOTES, AGENT
		  WHERE Job_ID = " . $job{ID} . "
		  AND AGENT.ID = JOBNOTES.Agent_ID
		  AND TO_DAYS(AddDate) >= TO_DAYS('". $lastdate ."')
		  ORDER BY JOBNOTES.AddDate";
	$result = $dbh->execute($query);
	$notes = $dbh->fetch_all_assoc($result);                     
	$dbh->free_result($result);
	$joblist[$count++]{JobNotesList} = $notes;

}
$smarty->assign('JobList' , $joblist);
$smarty->assign('StartDate' , $lastdaterev);
$today = getdate();
$month = $today['mon'];
$day = $today['mday'];
$year = $today['year'];
$smarty->assign('CurrentDate' , sprintf("%02d-%02d-%4d",$day,$month,$year));
$dbh->disconnect();
$smarty->display("skin:".$template);
?>
