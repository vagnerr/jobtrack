<?php
/* $Id: stats.php,v 1.1.1.1 2003/06/02 21:35:15 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("../configs/common_setup.php");
require("database.php");
require("utils.php");

$dbh = new Database;
$dbh->connect($db);

$smarty->assign('PageTitle', "Stats");
$template = 'stats.tpl';

$query = "SELECT Description, count( Description ) as Count
	  FROM STATUS_CONST, JOB
	  WHERE JOB.Status_ID = STATUS_CONST.ID
	  GROUP BY Description ORDER BY STATUS_CONST.ID";
$result = $dbh->execute($query);

$count=0;
$total=0;

while ($line = $dbh->fetch_assoc($result)){

	$total += $line{Count};
	$statelist[$count++] = $line;
}
$dbh->free_result($result);

$smarty->assign('StatusCountList', $statelist);
$smarty->assign('TotalJobs', $total);

$query = "SELECT count(*) as c from AGENCY";
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);
$smarty->assign('TotalAgencies', $line{c});

$query = "SELECT count(*) as c from AGENT";
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);
$smarty->assign('TotalAgents', $line{c});

$query = "SELECT count(*) as c from JOB where TO_DAYS(NOW()) - TO_DAYS(DateAdded) <=14;";
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);
$smarty->assign('TotalNew', $line{c});

$query = "SELECT count(*) as c from JOB where TO_DAYS(NOW()) - TO_DAYS(DateLastChanged) <=14;";
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);
$smarty->assign('TotalChanged', $line{c});

$query = "SELECT count(*) as c from JOB,STATUS_CONST
	  where TO_DAYS(NOW()) - TO_DAYS(DateToCheck) >=0 AND
	  JOB.Status_ID = STATUS_CONST.ID AND STATUS_CONST.Keyword = 'OPEN';";
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);
$smarty->assign('TotalOutstanding', $line{c});

$query = "SELECT count(*) as c from JOB,STATUS_CONST
	  where TO_DAYS(NOW()) - TO_DAYS(DateToCheck) >=-7 AND
	  TO_DAYS(NOW()) - TO_DAYS(DateToCheck) <=-1 AND
	  JOB.Status_ID = STATUS_CONST.ID AND STATUS_CONST.Keyword = 'OPEN';";
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);
$smarty->assign('TotalDue', $line{c});

$dbh->disconnect();
$smarty->display("skin:".$template);
?>
