<?php
/* $Id: common_setup.php,v 1.1.1.1 2003/06/02 21:34:59 vagnerr Exp $ */

// Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
// This code is protected under the Gnu Public License (See LICENSE).


#PDA#define('DIRECTORY_SEPARATOR' , '/');
#PDA#ini_set("include_path", ".:/usr/local/lib/php:/home/www/htdocs:/home/www/configs");

/* Create and Initialise the smarty object */
require("Smarty/Smarty.class.php");
$smarty = new Smarty;
$base = '/home/peter/www/jobapplications-dev/';
#PDA#$base = '/home/www/';
$smarty->template_dir = $base . 'templates/';
$smarty->compile_dir = $base . 'templates_c/';
$smarty->config_dir = $base . 'configs/';
$smarty->cache_dir = $base . 'cache/';
$smarty->skin_name = "testskin";

/* create main index list  */
$smarty->assign('MenuList', array(
	array('Name' => 'Stats',	'URL' => 'stats.php'),
	array('Name' => 'Active Jobs',	'URL' => 'activejobs.php'),
	array('Name' => 'All Jobs',	'URL' => 'alljobs.php'),
	array('Name' => 'Companies',	'URL' => 'companies.php'),
	array('Name' => 'Agencies',	'URL' => 'agencies.php'),
	array('Name' => 'Agents',	'URL' => 'agents.php'),
	array('Name' => 'Keywords',	'URL' => 'keywords.php'),
	array('Name' => 'Locations',	'URL' => 'locations.php'),
	array('Name' => 'Sources',	'URL' => 'sources.php'),
	array('Name' => 'Add',		'URL' => 'add.php'),
	array('Name' => 'JSA Report',	'URL' => 'jsareport.php')
	));
$smarty->assign('PHP_SELF', $PHP_SELF);

/*Database details */
require("db_setup.php");

$pager_size = 20;
$mark_fake = 1;
$smarty->assign('MARK_FAKE', $mark_fake);


?>

