<?php
/* $Id: stats.php,v 1.4 2003/08/22 20:30:00 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("libraries/DB.inc.php");
require("utils.php");

$dbh = new Database($db["database"], $db["host"], $db["username"], $db["password"]);
$dbh->connect();

$smarty->assign('PageTitle', "Stats");
$template = 'stats.tpl';

$query = "SELECT Description, count( Description ) as Count
	  FROM STATUS_CONST, JOB
	  WHERE JOB.Status_ID = STATUS_CONST.ID
	  GROUP BY Description ORDER BY STATUS_CONST.ID";
$line = $dbh->executeQuery($query, null, true);

$count=0;
$total=0;

if($line != null)
{
	foreach ($line as $k => $v)
	{
		$total += $line[$k]["Count"];
		$statelist[$count++] = $line[$k];
	}
}else{
}
$smarty->assign('StatusCountList', $statelist);
$smarty->assign('TotalJobs', $total);

$query = "SELECT count(*) as c from AGENCY";
$line = $dbh->executeQuery($query, null, true);

$smarty->assign('TotalAgencies', $line[0]{c});

$query = "SELECT count(*) as c from AGENT";
$line = $dbh->executeQuery($query, null, true);

$smarty->assign('TotalAgents', $line[0]{c});

$query = "SELECT count(*) as c from JOB where TO_DAYS(NOW()) - TO_DAYS(DateAdded) <=14;";
$line = $dbh->executeQuery($query, null, true);

$smarty->assign('TotalNew', $line[0]{c});

$query = "SELECT count(*) as c from JOB where TO_DAYS(NOW()) - TO_DAYS(DateLastChanged) <=14;";
$line = $dbh->executeQuery($query, null, true);

$smarty->assign('TotalChanged', $line[0]{c});

$query = "SELECT count(*) as c from JOB,STATUS_CONST
	  where TO_DAYS(NOW()) - TO_DAYS(DateToCheck) >=0 AND
	  JOB.Status_ID = STATUS_CONST.ID AND STATUS_CONST.Keyword = 'OPEN';";
$line = $dbh->executeQuery($query, null, true);

$smarty->assign('TotalOutstanding', $line[0]{c});

$query = "SELECT count(*) as c from JOB,STATUS_CONST
	  where TO_DAYS(NOW()) - TO_DAYS(DateToCheck) >=-7 AND
	  TO_DAYS(NOW()) - TO_DAYS(DateToCheck) <=-1 AND
	  JOB.Status_ID = STATUS_CONST.ID AND STATUS_CONST.Keyword = 'OPEN';";
$line = $dbh->executeQuery($query, null, true);

$smarty->assign('TotalDue', $line[0]{c});

$dbh->disconnect();
$smarty->display("skin:".$template);
?>
