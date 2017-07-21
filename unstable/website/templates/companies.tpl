<!-- $Id: companies.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>


<table border="0">
<tr>
	<th>Name</th><th>Jobs</th>
</tr>
{section name=company loop=$CompanyList}
	<tr>
		<td>
			<a href="companydetail.php?ID={$CompanyList[company].ID}">
				{$CompanyList[company].Name}
			</a>
		</td>
		<td>
			{$CompanyList[company].JobCount}
		</td>
	</tr>
{/section}
</table>

{include file="skin:footer.tpl"}		
