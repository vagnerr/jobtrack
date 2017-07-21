<!-- $Id: agents.tpl,v 1.1.1.1 2003/06/02 21:35:36 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>


<table border="0">
<tr>
	<th>Name</th><th>Agency</th><th>Jobs</th>
</tr>
{section name=agent loop=$AgentList}
	<tr>
		<td>
			<a href="agentdetail.php?ID={$AgentList[agent].ID}">
				{$AgentList[agent].Name}
			</a>
		</td>
		<td>
			<a href="agencydetail.php?ID={$AgentList[agent].Agency_ID}">
				{$AgentList[agent].AgencyName}
			</a>
		</td>
		<td>
			{$AgentList[agent].JobCount}
		</td>
	</tr>
{/section}
</table>

{include file="skin:footer.tpl"}		
