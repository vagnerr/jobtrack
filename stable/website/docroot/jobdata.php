<?php
/* $Id: jobdata.php,v 1.1.1.1 2003/06/02 21:35:07 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$keyword_ID = GET(ID);

$smarty->assign('PageTitle', "Jobs Data");
/*we dont need to know status when they will all be "open" */
$template = 'jobdata.tpl';


$query = "SELECT JOBDATATYPE_CONST.Keyword as Keyword,
		 JOBDATATYPE_CONST.Description as JobDataTypeDescription,
		 JOBDATA.Description as Description,
		 JOBDATA.Data as Data,
		 JOBDATA.ID as ID,
		 JOB.ID as Job_ID,
		 JOB.JobTitle as JobTitle
	FROM JOBDATATYPE_CONST, JOBDATA, JOB 
	WHERE JOBDATATYPE_CONST.ID = JOBDATA.JobDataType_ID
	AND JOBDATA.Job_ID = JOB.ID
	AND JOBDATA.ID = " . $keyword_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);

foreach ($line as $keyword => $value){
	$smarty->assign($keyword ,$value);
}

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
