<?php
/* $Id: companydetail.php,v 1.1.1.1 2003/06/02 21:39:50 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

$company_ID = GET(ID);
$smarty->assign('ID',$company_ID);
$smarty->assign('ID_FIELD', "ID=" . $company_ID . "&");

$main_clause = " AND Company_ID = " . $company_ID;
$count_clause = " WHERE Company_ID = " . $company_ID;
$smarty->assign('PageTitle', "Company Details");
/*we dont need to know status when they will all be "open" */
$smarty->assign('hide_Company',1);
$template = 'companydetail.tpl';


process_job_list(&$dbh, &$smarty, $pager_size, $count_clause, $main_clause);


$query = "SELECT Name FROM COMPANY WHERE ID = " . $company_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$name = $line{Name};
$dbh->free_result($result);
$smarty->assign('Name', $name);

$query = "SELECT COMPANYCONTACT_LNK.ID as ID, Description, Data, Keyword,
		 CONTACTTYPE_CONST.ID as ContactType_ID
	  FROM COMPANYCONTACT_LNK, CONTACTTYPE_CONST
	  WHERE ContactType_ID = CONTACTTYPE_CONST.ID
	  AND Company_ID = " . $company_ID . "
	  ORDER BY CONTACTTYPE_CONST.ID";
buildLoopByQuery(&$dbh,&$smarty,'CompanyContactList',$query);
buildLoopByTable(&$dbh,&$smarty,'ContactTypeList','CONTACTTYPE_CONST');

$dbh->disconnect();
$smarty->display("skin:".$template);

?>
