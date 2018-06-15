<?php
/* $Id: db_setup.php,v 1.1.1.1 2003/06/02 21:34:59 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).

/*Database details */
global $db;  
  
$db = array(  
     "host"              =>    getenv( "DB_HOST", true ) ?: "job-mysql",
     "username"          =>    getenv( "DB_USER", true ) ?: "jobapp_u",
     "password"          =>    getenv( "DB_PASS", true ) ?: "jobapp_p",
     "database"          =>    getenv( "DB_NAME", true ) ?: "JOBAPPS"
);  



?>
