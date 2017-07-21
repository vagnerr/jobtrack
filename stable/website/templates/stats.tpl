<!-- $Id: stats.tpl,v 1.1.1.1 2003/06/02 21:35:39 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

<h2>Job Status Count</h2>
<table border="1">
<tr><th>State<th>No</tr>
{section name=state loop=$StatusCountList}
	<tr><td>{$StatusCountList[state].Description}<td align='right'>{$StatusCountList[state].Count}</tr>
{/section}
<tr><td><strong>Total</strong><td align='right'><strong>{$TotalJobs}</strong></tr>
</table>

<ul>
<li>Total Agancies:		{$TotalAgencies} 
<li>Total Agents:		{$TotalAgents}
<li>New Jobs in 14 days:	{$TotalNew}
<li>Changed Jobs in 14 days:	{$TotalChanged}
<li>Outstanding checks: 	{$TotalOutstanding}
<li>Checks Due in 7 days:	{$TotalDue}
</ul>

{include file="skin:footer.tpl"}
