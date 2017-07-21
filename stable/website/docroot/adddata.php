<?php
/* $Id: adddata.php,v 1.1.1.1 2003/06/02 21:35:02 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).
  
require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);
$ok = 1;
if ($action == "upload") {
	// ok, let's get the uploaded data and insert it into the db now
	if (isset($FileName) && $FileName != "none") {
		$data = addslashes(fread(fopen($FileName, "r"), filesize($FileName)));
		$ok = 1;
	}else if($JobDataType_ID < 4){//nasty hard coded ie not bin files
		$data = addslashes(nl2br($Data));
		$ok = 1;
	}else{
		$ok = 0;
		$smarty->assign('LAST_RESULT_MESSAGE', 
				"Error: Canot Cut-n-Paste binary");
		$smarty->assign('LAST_RESULT_TYPE', "FAIL");
	}
	if($ok){
		$strDescription = addslashes(nl2br($Description));
		$sql = "INSERT INTO JOBDATA ";
		$sql .= "(Job_ID, JobDataType_ID,Description,Data, ";
		$sql .= "FileName, FileSize, FileType) ";
		$sql .= "VALUES ($ID,$JobDataType_ID,'$strDescription', '$data', ";
		$sql .= "'$FileName_name', '$FileName_size', '$FileName_type')";

		$result = $dbh->execute($sql);
		$smarty->assign('LAST_RESULT_MESSAGE', 
				"Data Added Successfully");
		$smarty->assign('LAST_RESULT_TYPE', "OK");

	}
	// run the jobdetail page
	require('jobdetail.php');
} else {

	// Called the first time from the jobdetails page so
	// generate and display the form
	$jobID = GET(JobID);
	$smarty->assign('ID',$jobID);

	buildLoopByTable(&$dbh, &$smarty, "JobDataTypeList", "JOBDATATYPE_CONST");

	$smarty->assign('PageTitle',"Add Job Data");
	$smarty->display('skin:adddata.tpl');

}

$dbh->disconnect();
?>
