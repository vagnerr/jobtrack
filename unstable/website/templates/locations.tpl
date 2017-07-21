<!-- $Id: locations.tpl,v 1.1.1.1 2003/06/02 21:40:23 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>


<table border="0">
<tr>
	<th>Name</th><th>Jobs</th>
</tr>
{section name=location loop=$LocationList}
	<tr>
		<td>
			<a href="locationdetail.php?ID={$LocationList[location].ID}">
				{$LocationList[location].Value}
			</a>
		</td>
		<td>
			{$LocationList[location].JobCount}
		</td>
	</tr>
{/section}
</table>

{include file="skin:footer.tpl"}		
