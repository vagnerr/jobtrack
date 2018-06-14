<?php
/* $Id: database.php,v 1.1.1.1 2003/06/02 21:35:07 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

class Database
{
	var $query;
	var $result;
	var $link;
	var $connected = 0;


	function connect ($db){
		if($this->connected) die ("already Connected to DB");
		$this->link = mysqli_connect($db{host},$db{username},$db{password})
							or die("Connect failed");
		mysqli_select_db($this->link, $db{database})
							or die("Select_db failed");
		$this->connected = 1;
		return $link;
	}

	function execute($query){
error_log("SQL:" . $query);
		if(!$this->connected) die ("Not1 connected to DB");
		$this->result = mysqli_query($this->link, $query) or die (mysqli_error($this->link));
		return $this->result;
	}

	function fetch_assoc($resobj = 0){
		if(!$this->connected) die ("Not2 connected to DB");
		if($resobj){
			return $this->_fetch_assoc($resobj);
		}else{
			return $this->_fetch_assoc($this->result);
		}
	}

	function _fetch_assoc($resobj){
		$this->line = mysqli_fetch_array($resobj, MYSQLI_ASSOC);
		return $this->line;
	}

	function fetch_all_assoc($resobj = 0){
		if(!$this->connected) die ("Not2 connected to DB");
		if($resobj){
			return $this->_fetch_all_assoc($resobj);
		}else{
			return $this->_fetch_all_assoc($this->result);
		}
	}

	function _fetch_all_assoc($resobj){
		$count = 0;
		while($line = mysqli_fetch_array($resobj, MYSQLI_ASSOC)){
			$returnarr[$count++] = $line;
		}
		return $returnarr;
	}

	function free_result($resobj =0){
		if ($resobj){
			mysqli_free_result($resobj);
		}else{
			mysqli_free_result($this->result);
		}
	}

	function last_insert_id($resobj =0){
		if ($resobj){
			return mysqli_insert_id($this->link, $resobj);
		}else{
			return mysqli_insert_id($this->link);
		}
	}

	function disconnect(){
		if($this->connected) mysqli_close($this->link);
		$this->connected = 0;
	}


}

?>
