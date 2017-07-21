<!-- $Id: menu.tpl,v 1.1.1.1 2003/06/02 21:35:39 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

<center>
{section name=mensec loop=$MenuList}
{strip}
	{if $PageTitle eq $MenuList[mensec].Name}
		{$MenuList[mensec].Name}
	{else}
		<a href="{$MenuList[mensec].URL}">{$MenuList[mensec].Name}</a> 
	{/if}
	{if ! $smarty.section.mensec.last}
		&nbsp;|&nbsp;
	{/if}
{/strip}
{/section}
</center>
