<?php
/* $Id: setjobdetails.php,v 1.1.1.1 2003/06/02 21:35:14 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

$ok = 1;

// sort our simple inputs
$ID = GET('ID');
$DateToCheck = GET(DateToCheck);
  $DateToCheck_SQL = $DateToCheck ? "DateToCheck='$DateToCheck'," : "DateToCheck=NULL,";
$DateOfInterview = GET(DateOfInterview);
  $DateOfInterview_SQL = $DateOfInterview ? "DateOfInterview='$DateOfInterview'," : "DateOfInterview=NULL,";
$NextAction_ID = GET(NextAction_ID);
$Status_ID = GET(Status_ID);
$Type_ID = GET(Type_ID);
$Salary = GET(Salary);
$JobTitle = GET(JobTitle);
$Reference = GET(Reference);
$Fake = GET(Fake);
if($Fake == ""){
	$Fake =0;
}
// I want a copy of the current record makes some
// stuff easier
$current_record = getCurrentRecord($dbh,$ID);

// now sort the more complex ones
$Source_ID = GET(Source_ID);
if($Source_ID == -1){
	// we need to add a new one
	$Source_ID = addNewSource($dbh,GET(NewSource));
}

$company = GET(CompanyName);
if($company){
	$Company_ID = addNewCompany($dbh,$company);
}else{
	$Company_ID = $current_record{Company_ID};
}

$Location_ID = GET(Location_ID);
if($Location_ID == -1){
	// need to add a new one
	$Location_ID = addNewLocation($dbh,GET(NewLocation));
}

$primaryagent = GET(PrimaryAgent);
if($primaryagent){
	setPrimaryAgent($dbh,$ID,$primaryagent);
}

$newagent = GET(NewAgentName);
if($newagent){
	addNewAgent($dbh,$ID,$current_record{Agency_ID},$newagent);
}

$newagentlist = GET(NewAgentID);
if($newagentlist){
	addNewAgentID($dbh,$ID,$newagentlist);
}

$newkeyword = GET(NewKeyword);
if($newkeyword){
	addNewKeyword($dbh,$ID,$newkeyword);
}

$newrelationID = GET(NewRelationID);
$newrelationDescription = GET(NewRelationDescription);
if($newrelationID && $newrelationDescription){
	addNewRelationship($dbh,$ID,$newrelationID,$newrelationDescription);
}


// Now we should have evrything we need, (or tehy are at their
// default values so no its time to do the update of the job record

	//DateOfInterview='".$DateOfInterview."',
$query = "UPDATE JOB SET
	$DateToCheck_SQL
	$DateOfInterview_SQL
	NextAction_ID=".$NextAction_ID.",
	Status_ID=".$Status_ID.",
	Type_ID=".$Type_ID.",
	Salary='".$Salary."',
	Source_ID=".$Source_ID.",
	JobTitle='".$JobTitle."',
	Company_ID=".$Company_ID.",
	Location_ID=".$Location_ID.",
	Reference='".$Reference."',
	Fake=".$Fake."
	WHERE ID=".$ID;
$result = $dbh->execute($query);

$smarty->assign('LAST_RESULT_MESSAGE', "Changed Successfully");
$smarty->assign('LAST_RESULT_TYPE', "OK");

// Time to re-execute the jobdetail script
require('jobdetail.php');
$dbh->disconnect();


// now add all the function we have called earlier (may want to move some
// of these to utils they may be usefull elsewhere

// Grabs the single job row and returns it as an associative
// array so we have a snapshot of what we had for comparison
function getCurrentRecord($dbh, $ID){
	$query = "SELECT * FROM JOB WHERE ID=".$ID;
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	$dbh->free_result($result);
	return($line);
}

?>
