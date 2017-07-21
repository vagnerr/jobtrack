<?php
/* $Id: rawdata.php,v 1.1.1.1 2003/06/02 21:39:57 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

require("database.php");
require("utils.php");
require("../configs/db_setup.php");

$dbh = new Database;
$dbh->connect($db);

$data_ID = GET(ID);

$query = "SELECT JobDataType_ID as TypeID,
		 Keyword,
		 Data,
		 FileName, FileSize, FileType
	FROM JOBDATATYPE_CONST, JOBDATA
	WHERE JOBDATATYPE_CONST.ID = JOBDATA.JobDataType_ID
	AND JOBDATA.ID = " . $data_ID;
$result = $dbh->execute($query);
$line = $dbh->fetch_assoc($result);
$dbh->free_result($result);


header("Content-type: " . $line{FileType} );
header("Content-length: " . $line{FileSize} );
header("Content-Disposition: ". $line{FileType} );
header("Content-Description: PHP Generated Data");
echo $line{Data};

$dbh->disconnect();

?>
