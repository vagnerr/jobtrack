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
		$this->link = mysql_connect($db{host},$db{username},$db{password})
							or die("Connect failed");
		mysql_select_db($db{database})
							or die("Select failed");
		$this->connected = 1;
		return $link;
	}

	function execute($query){
		if(!$this->connected) die ("Not1 connected to DB");
		$this->result = mysql_query($query) or die (mysql_error());
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
		$this->line = mysql_fetch_array($resobj, MYSQL_ASSOC);
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
		while($line = mysql_fetch_array($resobj, MYSQL_ASSOC)){
			$returnarr[$count++] = $line;
		}
		return $returnarr;
	}

	function free_result($resobj =0){
		if ($resobj){
			mysql_free_result($resobj);
		}else{
			mysql_free_result($this->result);
		}
	}

	function last_insert_id($resobj =0){
		if ($resobj){
			return mysql_insert_id($resobj);
		}else{
			return mysql_insert_id();
		}
	}

	function disconnect(){
		if($this->connected) mysql_close($this->link);
		$this->connected = 0;
	}


}

?>
