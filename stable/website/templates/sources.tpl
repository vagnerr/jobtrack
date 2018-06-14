<!-- $Id: sources.tpl,v 1.1.1.1 2003/06/02 21:35:39 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

{if $SourceList}
  <table border="0">
  <tr>
	<th>Name</th><th>Jobs</th>
  </tr>
  {section name=source loop=$SourceList}
	<tr>
		<td>
			<a href="sourcedetail.php?ID={$SourceList[source].ID}">
				{$SourceList[source].Description}
			</a>
		</td>
		<td>
			{$SourceList[source].JobCount}
		</td>
	</tr>
  {/section}
  </table>
{else}
  <em>--None--</em>
{/if}
{include file="skin:footer.tpl"}		
