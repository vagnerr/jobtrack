<?php
/* $Id: utils.php,v 1.1.1.1 2003/06/02 21:40:07 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

function process_job_list($dbh, $smarty, $pager_size, $count_clause="", $main_clause="" , $extra_tables="", $order=""){

	/* sort paging */
	if (GET(start)){
		$start = GET(start);
	}else{
		$start = 0;
	}
	if ($start > $pager_size){
		$smarty->assign('start_prev', $start - $pager_size);
	}else if ($start > 0){
		$smarty->assign('start_prev', "0");
	}


	/* sort orderung headers */
	if ($order != ""){
		#overide the order code based on cgi vars
		$order_by = $order;
	}else{
		#use main ordering scheme
		if (GET(order)){
			$order_by = GET(order);
			if (!GET(decrement)){
				$smarty->assign('rev_' . GET(order), '&decrement=1');
			}else{
				$decrement = " DESC";
				$smarty->assign('decrement', "&decrement=1");
			}
		}else{
			$order_by = "DateAdded";
			$smarty->assign('rev_DateAdded', '&decrement=1');
		}
		$smarty->assign('order', $order_by);
	}

	/* grab the total records */
	$query = "SELECT COUNT(JOB.ID) as total FROM JOB " . $extra_tables . $count_clause;
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	$total_records = $line{total};
	$dbh->free_result($result);

	/* main data query */
	$query = "SELECT JOB.ID as ID,
			date_format(DateAdded,'%e/%c/%Y') as DateAdded,
			date_format(DateLastChanged,'%e/%c/%Y') as DateLastChanged,
			date_format(DateToCheck,'%e/%c/%Y') as DateToCheck,
			date_format(DateOfInterview,'%e/%c/%Y') as DateOfInterview,
			JobTitle,
			Reference,
			LOCATION_CONST.Value as Location,
			COMPANY.Name as Company,
			JOB.Company_ID as Company_ID,
			AGENCY.Name as Agency,
			AGENCY.ID as Agency_ID,
			STATUS_CONST.Description as Status,
			NEXTACTION_CONST.Description as NextAction,
			Fake
		  FROM JOB, LOCATION_CONST, COMPANY, AGENCY,
			NEXTACTION_CONST,
			STATUS_CONST " . $extra_tables . "
		  WHERE STATUS_CONST.ID = JOB.Status_ID
			AND LOCATION_CONST.ID = JOB.Location_ID
			AND COMPANY.ID = JOB.Company_ID
			AND AGENCY.ID = JOB.Agency_ID 
			AND NEXTACTION_CONST.ID = JOB.NextAction_ID " . $main_clause . "
		  ORDER BY ". $order_by . $decrement;
 	if($pager_size){
		#if pager size is non-zero then add the limit code to the 
		#query string

		$query .= " LIMIT " . $start . "," . $pager_size;
	}

	$result = $dbh->execute($query);

	/* insert the transient data */
	$count = 0;
	while ($line = $dbh->fetch_assoc($result)){
		$line{Notes} = getJobNotesCount($dbh,$line{ID});
		$subquery = "SELECT Name, AGENT.ID as AgentID
				FROM AGENT, JOBAGENT_LNK     
	                            WHERE JOBAGENT_LNK.Agent_ID=AGENT.ID 
	                            AND JOBAGENT_LNK.Job_ID=" . $line{ID} ."
				ORDER BY PrimaryAgent DESC";

		$subresult = $dbh->execute($subquery);
		if ($subline = $dbh->fetch_assoc($subresult)){
			$line{Agent} = $subline{Name};
			$line{Agent_ID} = $subline{AgentID};
		}
		$dbh->free_result($subresult);
		$joblist[$count++] = $line;
	}

	$dbh->free_result($result);

	$smarty->assign('JobList', $joblist);
	$smarty->assign('first_record', $start + 1);
	$smarty->assign('last_record', $start + $count);
	$smarty->assign('total_record', $total_records);
	if ($count == $pager_size){
		/* we have a full page so *might* need another one */
		$smarty->assign('start_next', $start + $pager_size);
	}

	return $joblist;
}

function buildLoopByQuery($dbh, $smarty, $varname, $query ){
	$result = $dbh->execute($query);
	$smarty->assign($varname,$dbh->fetch_all_assoc($result));
	$dbh->free_result($result);
}

function buildLoopByTable($dbh, $smarty, $varname, $table, $order="",$desc=0){
	$query = "SELECT * FROM " . $table;
	if($order != ""){
		$query .= " ORDER BY " . $order;
		if ($desc){
			$query .= " DESC";
		}
	}
	buildLoopByQuery(&$dbh, &$smarty, $varname, $query);

}


//Get function to handle all access to the CGI get variable so its only a small change
//between ziggy and selma
//ZIGGY VERSION
function GET($keyword){
	$returnval = $_GET{$keyword}; //try the get field first
	if ($returnval){
		return $returnval;
	}else{
		global $$keyword;  //yes this is nasty :-}
		return $$keyword;  //otherwise try post method
	}
}
//SELMA VERISION
//function GET($keyword){
//        global $HTTP_GET_VARS;
//        $returnval = $HTTP_GET_VARS[$keyword];
//        if ($returnval){
//                return $returnval;
//        }else{
//                global $$keyword;  //yes this is nasty :-}
//                return $$keyword;  //otherwise try post method
//        }
//}
////SELMA ALSO NEEDS A FAKE array_filter() function
//function array_filter($array,$callbackfunction){
//        //just return the array and be dammed
//        return($array);
//} 

// takes the source name given and if the source already
// exists then it returns the source ID (backup just incase
// user entered a new source when it already exists. If
// no such source exists then it will create one and
// return the new ID.
function addNewSource($dbh,$sourcename){
	$query = "SELECT ID FROM SOURCE_CONST
		  WHERE Description = '".$sourcename."'";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if($line){
		$dbh->free_result($result);
		return($line{ID});
	}else{
		//need to add new entry
		$query = "INSERT INTO SOURCE_CONST(Description)
			  VALUES('".$sourcename."')";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id());
	}
}

// take the company name given and if it already exists
// then returns the ID. If no such entry exists then
// creates one and returns the new ID.
function addNewCompany($dbh, $companyname){
	$query = "SELECT ID FROM COMPANY
		  WHERE Name = '".$companyname."'";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if($line){
		$dbh->free_result($result);
		return($line{ID});
	}else{
		//need to add new entry
		$query = "INSERT INTO COMPANY(Name)
			  VALUES('".$companyname."')";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id());
	}
}

// take the location name given and if it already exists
// then returns the ID (backup just in case the user
// missed the current one. If no such entry exists then
// creates one and returns the new ID.
function addNewLocation($dbh, $locationname){
	$query = "SELECT ID FROM LOCATION_CONST
		  WHERE Value = '".$locationname."'";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if($line){
		$dbh->free_result($result);
		return($line{ID});
	}else{
		//need to add new entry
		$query = "INSERT INTO LOCATION_CONST(Value)
			  VALUES('".$locationname."')";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id());
	}
}

// checks to see if the primary agent has changed, if it
// has then unsets the previous record as primary agent
// and sets the new one
function setPrimaryAgent($dbh,$jobID, $primaryagentID){
	$query = "SELECT ID, Agent_ID FROM JOBAGENT_LNK
		  WHERE PrimaryAgent=1 AND Job_ID=".$jobID;
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if($line){
		$currentprimary = $line{Agent_ID};
		if ($currentprimary == $primaryagentID){
			//already matches so nothing to do
			return;
		}else{
			// we need to unset the old id
			$query = "UPDATE JOBAGENT_LNK SET PrimaryAgent=0
				  WHERE ID=".$line{ID};
			$result = $dbh->execute($query);
		}
	}
	// if we are here then either there was no primary agent
	// or we needed to change it
	$query = "UPDATE JOBAGENT_LNK SET PrimaryAgent=1
		  WHERE Job_ID=".$jobID." AND Agent_ID=".$primaryagentID;
	$result = $dbh->execute($query);

}

// checks if teh agent already exists with the given agency and uses 
// that it if it does, otherwise it create a new agent entry
// the ncalles addNewAgentID to link it to to the job
// if the agencyID is 0 then it is a special case and will
// only match an existing agent if it is already linked to
// the job (and therefore the function must do nothing
function addNewAgent($dbh, $jobID, $agencyID, $newagentname){
	if($agencyID){
		$query="SELECT ID FROM AGENT
			WHERE Agency_ID = ".$agencyID."
			AND Name = '".$newagentname."'";
		$result = $dbh->execute($query);
		$line = $dbh->fetch_assoc($result);
		if($line){
			addNewAgentID($dbh,$jobID,$line{ID});
			return;
		}
	}else{
		$query="SELECT AGENT.ID FROM AGENT as A,JOBAGENT_LNK as L
			WHERE L.Agent_ID = A.ID
			AND L.Job_ID = ".$jobID."
			AND A.Name = '".$newagentname."'";
		$result = $dbh->execute($query);
		$line = $dbh->fetch_assoc($result);
		if($line){
			// the agent already exists and is
			// already linked to the job
			// so we dont need to do anything
			return;
		}
	}
	// If we are here we nned to actualy add the agent as
	// it doesnt exist yet.
	$query = "INSERT INTO AGENT(Agency_ID,Name)
		  VALUES(".$agencyID.",'".$newagentname."')";
	$result = $dbh->execute($query);
	$agentID = $dbh->last_insert_id();
	// ok now link it to the job
	addNewAgentID($dbh,$jobID,$agentID);
}

// link the given agent ID to a job unless it already exists
function addNewAgentID($dbh, $jobID,$agentID){
	$query = "SELECT ID FROM JOBAGENT_LNK
		  WHERE Job_ID = ".$jobID."
		  AND Agent_ID = ".$agentID;
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if(!$line){
		//need to add new entry
		$query = "INSERT INTO JOBAGENT_LNK(Job_ID,Agent_ID,PrimaryAgent)
			  VALUES(".$jobID.",".$agentID.",0)";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id()); // dont need the id but hey :)
	}
}

// take the company name given and if it already exists
// then returns the ID. If no such entry exists then
// creates one and returns the new ID.
function addNewAgency($dbh, $agencyname){
	$query = "SELECT ID FROM AGENCY
		  WHERE Name = '".$agencyname."'";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if($line){
		$dbh->free_result($result);
		return($line{ID});
	}else{
		//need to add new entry
		$query = "INSERT INTO AGENCY(Name)
			  VALUES('".$agencyname."')";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id());
	}
}


// Add the keyword to the keyword table if it does not alreadu
// exist. and then link it to the job.
function addNewKeyword($dbh,$jobID,$newkeyword){
	$query = "SELECT ID FROM KEYWORD_CONST
		  WHERE Keyword = '".$newkeyword."'";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if($line){
		$dbh->free_result($result);
		addNewKeywordID($dbh,$jobID,$line{ID});
	}else{
		//need to add new entry
		$query = "INSERT INTO KEYWORD_CONST(Keyword)
			  VALUES('".$newkeyword."')";
		$result = $dbh->execute($query);
		addNewKeywordID($dbh,$jobID,$dbh->last_insert_id());
	}
}	

// link the given keyword ID to a job unless it already exists
function addNewKeywordID($dbh, $jobID,$keyID){
	$query = "SELECT ID FROM KEYWORD_LNK
		  WHERE Job_ID = ".$jobID."
		  AND Keyword_ID = ".$keyID;
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if(!$line){
		//need to add new entry
		$query = "INSERT INTO KEYWORD_LNK(Job_ID,Keyword_ID)
			  VALUES(".$jobID.",".$keyID.")";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id()); // dont need the id but hey :)
	}
}

// Link the two given ID's together with the description unless
// there already exists a link between the tow jobs
// IN EITHER DIRECTION!!
function addNewRelationship($dbh,$PjobID,$CjobID,$desc){
	$query = "SELECT ID FROM JOBRELATED_LNK
		  WHERE
			(Parent_ID = ".$PjobID."
		  	AND Child_ID = ".$CjobID.")
		  OR
			(Parent_ID = ".$CjobID."
			AND Child_ID = ".$PjobID.")";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	if(!$line){
		//need to add new entry
		$query = "INSERT INTO
				JOBRELATED_LNK(Parent_ID,Child_ID,Description)
			  VALUES(".$PjobID.",".$CjobID.",'".$desc."')";
		$result = $dbh->execute($query);
		return($dbh->last_insert_id()); // dont need the id but hey :)
	}
}


// get the count of notes for a given job id
function getJobNotesCount($dbh, $jobID){
	$query = "SELECT COUNT(*) as notes FROM JOBNOTES WHERE Job_ID=$jobID";
	$result = $dbh->execute($query);
	$line = $dbh->fetch_assoc($result);
	$dbh->free_result($result);
	return($line{notes});
}


?>
