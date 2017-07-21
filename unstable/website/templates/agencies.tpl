<!-- $Id: agencies.tpl,v 1.1.1.1 2003/06/02 21:40:11 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>


<table border="0">
<tr>
	<th>Name</th><th>Agents</th><th>Jobs</th>
</tr>
{section name=agency loop=$AgencyList}
	<tr>
		<td>
			<a href="agencydetail.php?ID={$AgencyList[agency].ID}">
				{$AgencyList[agency].Name}
			</a>
		</td>
		<td>
			{$AgencyList[agency].AgentCount}
		</td>
		<td>
			{$AgencyList[agency].JobCount}
		</td>
	</tr>
{/section}
</table>

{include file="skin:footer.tpl"}		
