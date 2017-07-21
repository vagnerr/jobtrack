<?php
/* $Id: updateagencydetails.php,v 1.1.1.1 2003/06/02 21:35:17 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require_once("../configs/common_setup.php");
require_once("database.php");
require_once("utils.php");

$dbh = new Database;
$dbh->connect($db);

global $ok;
$ok = 1;

// sort our inputs
$agency_ID = GET('ID');
$submitmode = GET('submit');
if ($submitmode == "Change"){
	// Call to change the company name
	$name = GET('Name');
	$message = setAgencyName($dbh,$agency_ID,$name);
}else if($submitmode == "Edit"){
	// Call to edit an existing contact row given
	$whichrow = GET('WhichContactID');
	$data = GET('ContactData-'.$whichrow);
	$type = GET('ContactType_ID-'.$whichrow);
	$message = editContactDetails($dbh,$whichrow,$data,$type);
}else if($submitmode == "Remove"){
	//call to remove an existing contact given
	$whichrow = GET('WhichContactID');
	$message = removeContactDetails($dbh,$whichrow);
}else if($submitmode == "Add"){
	$data = GET('ContactData');
	$type = GET('ContactType_ID');
	$message = addContactDetails($dbh,$agency_ID,$data,$type);
}else{
	// should not be here
	$ok = 0;
}
	
if($ok){
	$smarty->assign('LAST_RESULT_MESSAGE', "Change Successfull");
	$smarty->assign('LAST_RESULT_TYPE', "OK");
}else{
	$smarty->assign('LAST_RESULT_MESSAGE', "Error: ". $message);
	$smarty->assign('LAST_RESULT_TYPE', "FAIL");
}

// Time to re-execute the jobdetail script
require('agencydetail.php');
$dbh->disconnect();

function setAgencyName($dbh,$agency_ID,$name){
	if($name == ""){
		global $ok;
		$ok = 0;
		return('Blank Agency Name Not Permited'); 
	}
	$query = "UPDATE AGENCY SET Name = '".$name."'
			WHERE ID = ".$agency_ID;
	$dbh->execute($query);
}

function editContactDetails($dbh,$whichrow,$data,$type){
	if(!$whichrow){
		// need a row to work with
		global $ok;
		$ok = 0;
		return('Must Have Row ID');
	}
	if($data == ""){
		// they emptied it so lets just delete
		return( removeContactDetails($dbh,$whichrow));
	}
	if(!$type){
		// bad
		global $ok;
		$ok = 0;
		return('Must Have Type');
	}
	$query = "UPDATE AGENCYCONTACT_LNK SET ContactType_ID = ".$type.",
			Data = '".$data."'
		  WHERE ID=".$whichrow;
	$dbh->execute($query);
}

function removeContactDetails($dbh,$whichrow){
	if(!$whichrow){
		// need a row to work with
		global $ok;
		$ok = 0;
		return('Must Have Row ID');
	}
	$query = "DELETE FROM AGENCYCONTACT_LNK WHERE ID=".$whichrow;
	$dbh->execute($query);
}

function addContactDetails($dbh,$agency_ID,$data,$type){
	if($data == ""){
		// bad
		global $ok;
		$ok = 0;
		return('Must Have Data');
	}
	if(!$type){
		// bad
		global $ok;
		$ok = 0;
		return('Must Have Type');
	}
	if(!$agency_ID){
		// bad
		global $ok;
		$ok = 0;
		return('Must Have Agency');
	}
	$query = "INSERT INTO AGENCYCONTACT_LNK(Agency_ID,
						 ContactType_ID,Data)
		  VALUES(".$agency_ID.",".$type.",'".$data."')";
	$dbh->execute($query);
}
?>
