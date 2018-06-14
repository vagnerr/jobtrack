<!-- $Id: jsajobtable.tpl,v 1.1.1.1 2003/06/02 21:35:38 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{if $JobList}

  {section name=jobsec loop=$JobList}
	
	<strong><u>{$JobList[jobsec].JobTitle}</u> 
	{if $JobList[jobsec].Reference}
		(<em>{$JobList[jobsec].Reference}</em>)
	{/if}
	</strong><br />

	<strong>Applied:</strong>{$JobList[jobsec].DateAdded}&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Last Checked:</strong>{$JobList[jobsec].DateLastChanged}&nbsp;&nbsp;&nbsp;&nbsp;
	{if $JobList[jobsec].DateOfInterview && ($JobList[jobsec].DateOfInterview ne "0/0/0000")}
		<strong>Interview:</strong>{$JobList[jobsec].DateOfInterview}&nbsp;&nbsp;&nbsp;&nbsp;
	{/if}
	{if $JobList[jobsec].DateToCheck ne "0/0/0000"}
		<strong>Next Check:</strong>{$JobList[jobsec].DateToCheck} ({$JobList[jobsec].NextAction}) 
	{/if}
  <br />
	{if $JobList[jobsec].Company}
		<strong>Company:</strong>{$JobList[jobsec].Company}&nbsp;&nbsp;&nbsp;&nbsp;
	{/if}
	{if $JobList[jobsec].Location}
		<strong>Location:</strong>{$JobList[jobsec].Location}&nbsp;&nbsp;&nbsp;&nbsp;
	{/if}
	{if $JobList[jobsec].Agency}
		<strong>Agency:</strong>{$JobList[jobsec].Agency}&nbsp;&nbsp;&nbsp;&nbsp;
	{/if}
	{if $JobList[jobsec].Agent}
		<strong>Agent:</strong>{$JobList[jobsec].Agent}&nbsp;&nbsp;&nbsp;&nbsp;
	{/if}
	<strong>Status:</strong>{$JobList[jobsec].Status}
	
	{include file="skin:jsanotestable.tpl" JobNotesList=$JobList[jobsec].JobNotesList}
	<hr />
  {/section}
{else}
  <em> --- No Data Found --- </em>
{/if}

