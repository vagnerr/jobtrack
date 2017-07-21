<!-- $Id: jobdata.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

<h2>"{$Description}" ({$JobDataTypeDescription})  for <a href="jobdetail.php?ID={$Job_ID}">{$JobTitle}</a></h2>

{if $Keyword == "TEXT" }
	<table border="1">
	<tr><td>
	{$Data}
	</td></tr>
	</table>
{elseif $Keyword == "EMAIL"}
	<table border="1">
	<tr><td>
	<pre>{$Data}</pre>
	</td></tr>
	</table>
{elseif $Keyword == "HTML"}
	<table border="1">
	<tr><td>
	{$Data}
	</td></tr>
	</table>
{elseif $Keyword == "IMAGE" }
	<table border="1">
	<tr><td>
	<img src="rawdata.php?ID={$ID}">
	</td></tr>
	</table>
{elseif $Keyword == "DOC" || $Keyword == "BINARY"}
	<table border="1">
	<tr><td>
	<a href="rawdata.php?ID={$ID}">view</a>
	</td></tr>
	</table>
{/if}

{include file="skin:footer.tpl"}		
