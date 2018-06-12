<?php
/*
 * Smarty plugin
 * ------------------------------------------------------------- 
 * File:     resource.skin.php
 * Type:     resource
 * Name:     skin
 * Purpose:  attempts to load the current "skin" template
 *           before reverting to default if it can
 *
 * $Id: resource.skin.php,v 1.1.1.1 2003/06/02 21:34:57 vagnerr Exp $
 *
 * Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
 * This code is protected under the Gnu Public License 
 * (See LICENSE). 
 * -------------------------------------------------------------
 */

function smarty_resource_skin_getfilename($tpl_name, &$smarty){
	//$skinname = "testskin"; // for now
	$skinname = $smarty->skin_name; // for now
	if ($smarty->template_exists( "skins" . DIRECTORY_SEPARATOR .
					$skinname . DIRECTORY_SEPARATOR . $tpl_name)){
		return ($smarty->template_dir . DIRECTORY_SEPARATOR . 
			"skins" . DIRECTORY_SEPARATOR .
			$skinname . DIRECTORY_SEPARATOR . 
			$tpl_name);
	}elseif ($smarty->template_exists($tpl_name)){
		return ($smarty->template_dir . DIRECTORY_SEPARATOR . $tpl_name);
	}else{
		return;
	}

}

function smarty_resource_skin_source($tpl_name, &$tpl_source, &$smarty)
{
    // attempt to load template file
    if ($filename = smarty_resource_skin_getfilename($tpl_name, $smarty)){
	$fd = fopen ($filename, "r");
	$tpl_source = fread ($fd, filesize ($filename));
	fclose ($fd);
        return true;
    } else {
        return false;
    }
}

function smarty_resource_skin_timestamp($tpl_name, &$tpl_timestamp, &$smarty)
{
    // get timestamp of template file
    if ($filename = smarty_resource_skin_getfilename($tpl_name, $smarty)) {
    	$tpl_timestamp = time($filename);
        return true;
    } else {
        return false;
    }
}

function smarty_resource_skin_secure($tpl_name, &$smarty)
{
    // assume all templates are secure
    return true;
}

function smarty_resource_skin_trusted($tpl_name, &$smarty)
{
    // not used for templates
}
?>

