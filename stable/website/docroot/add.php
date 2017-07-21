<?php
/* $Id: add.php,v 1.1.1.1 2003/06/02 21:35:02 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

global $ok;
$ok=1;

$submit = GET(submit);

if(!$submit || $submit == ""){

	presentForm($dbh,$smarty);


}else{
	$Fake = GET(Fake);
	if($Fake == ""){
		$Fake =0;
	}
	$DateAdded = getDateAdded(GET(DateAdded));
	$DateLastChanged = $DateAdded;
	$DateToCheck = getDateToCheck(GET(DateToCheck),$DateLastChanged);
	$NextAction_ID = GET(NextAction_ID);
	$DateOfInterview = GET(DateOfInterview);
	$Status_ID = GET(Status_ID);
	$Type_ID = GET(Type_ID);
	$Salary = GET(Salary);
	$Source_ID = getSourceID($dbh, GET(Source_ID), GET(NewSource));
	$JobTitle = GET(JobTitle);
	$Company_ID = getCompanyID($dbh, GET(NewCompany));
	$Location_ID = getLocationID($dbh, GET(Location_ID), GET(NewLocation));
	$Reference = GET(Reference);
	$Agency_ID = getAgencyID($dbh, GET(Agency_ID), GET(NewAgency));

	if($ok){
		// we have all the values time to fo the insert
		$query = "INSERT INTO JOB(Fake,DateAdded,DateLastChanged,
				  DateToCheck,NextAction_ID,DateOfInterview,
				  Status_ID,Type_ID,Salary,Source_ID,
				  JobTitle,Company_ID,Location_ID,
				  Reference,Agency_ID)
		  VALUES($Fake,'$DateAdded','$DateLastChanged',
                         '$DateToCheck',$NextAction_ID,'$DateOfInterview',
                         $Status_ID,$Type_ID,'$Salary',$Source_ID,
                         '$JobTitle',$Company_ID,$Location_ID,
                         '$Reference',$Agency_ID)";
		$result = $dbh->execute($query);
		global $ID;
		$ID = $dbh->last_insert_id();

		$smarty->assign('LAST_RESULT_MESSAGE',
				"Job Added Successfully");
		$smarty->assign('LAST_RESULT_TYPE', "OK");
		//now run the jobdetail page the user can continue from there
		require('jobdetail.php');
	}else{
		$smarty->assign('LAST_RESULT_MESSAGE',
				"Problem Job Not Added");
		$smarty->assign('LAST_RESULT_TYPE', "FAIL");
	
		presentForm($dbh,$smarty);
	}	

}





$dbh->disconnect();

// our loverly functions


function presentForm($dbh,$smarty){
	// submit not pressed so display the form
	buildLoopByTable(&$dbh, &$smarty, "StatusList", "STATUS_CONST");
	buildLoopByTable(&$dbh, &$smarty, "NextActionList", "NEXTACTION_CONST");
	buildLoopByTable(&$dbh, &$smarty, "TypeList", "TYPE_CONST");
	buildLoopByTable(&$dbh, &$smarty, "SourceList", "SOURCE_CONST",
							"Description");
	buildLoopByTable(&$dbh, &$smarty, "AgencyList", "AGENCY", "Name");
	buildLoopByTable(&$dbh, &$smarty, "LocationList", "LOCATION_CONST",
							"Value");
	//$checkvar = $smarty->get_template_vars();
	//echo "<pre>" . var_dump($checkvar) ."</pre>";
	$smarty->assign('PageTitle',"Add");
	$smarty->display('skin:add.tpl');
}

function getDateAdded($date){
	if ($date==""){
		$date = date("Y-m-d H:i:s");
	}else{
		if (($date = strtotime($date)) === -1){
			#timestring faied
			$ok = 0;
		}else{
			$date = date("Y-m-d H:i:s", $date);
		}
	}
	return($date);
}

function getDateToCheck($date,$lastdate){
	if ($date==""){
		$date = date("Y-m-d H:i:s",strtotime("+7 days",strtotime($lastdate)));
	}else{
		if (($date = strtotime($date)) === -1){
			#timestring faied
			$ok = 0;
		}else{
			$date = date("Y-m-d H:i:s", $date);
		}
	}
	return($date);

}

function getSourceID($dbh, $sourceID, $newsource){
	if($sourceID == -1){
		// add a new source
		if($newsource == ""){
			// go with no source
			return 0;
		}else{
			return (addNewSource($dbh,$newsource));
		}
	}else{
		return $sourceID;
	}
}

function getCompanyID($dbh, $company){
	if($company == ""){
		// go with no source
		return 0;
	}else{
		return (addNewCompany($dbh,$company));
	}
}

function getLocationID($dbh, $locationID, $newlocation){
	if($locationID == -1){
		// add a new source
		if($newlocation == ""){
			// go with no source
			return 0;
		}else{
			return (addNewLocation($dbh,$newlocation));
		}
	}else{
		return $locationID;
	}
}

function getAgencyID($dbh, $agencyID, $newagency){
	if($agencyID == -1){
		// add a new source
		if($newagency == ""){
			// go with no source
			return 0;
		}else{
			return (addNewAgency($dbh,$newagency));
		}
	}else{
		return $agencyID;
	}
}


?>
