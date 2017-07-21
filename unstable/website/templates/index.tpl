<!-- $Id: index.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl" PageTitle="Main Menu"}
		
<h1>Job Applications</h1>
<ul>
	{section name=mensec loop=$MenuList}
	{strip}
	        <li><a href="{$MenuList[mensec].URL}">{$MenuList[mensec].Name}</a>
	{/strip}
	{/section}
</ul>

{include file="skin:footer.tpl" PageTitle="Main Menu"}		
