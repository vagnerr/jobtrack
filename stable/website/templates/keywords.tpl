<!-- $Id: keywords.tpl,v 1.1.1.1 2003/06/02 21:35:38 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>


<table border="0">
<tr>
	<th>Name</th><th>Jobs</th>
</tr>
{section name=keyword loop=$KeywordList}
	<tr>
		<td>
			<a href="keyworddetail.php?ID={$KeywordList[keyword].ID}">
				{$KeywordList[keyword].Keyword}
			</a>
		</td>
		<td>
			{$KeywordList[keyword].JobCount}
		</td>
	</tr>
{/section}
</table>

{include file="skin:footer.tpl"}		
