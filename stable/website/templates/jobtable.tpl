<!-- $Id: jobtable.tpl,v 1.1.1.1 2003/06/02 21:35:36 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

<script src="libraries/functions.js" type="text/javascript" language="javascript"></script>	

{if $JobList}
<table border="0">
<tr>
	<th>Detail</th>
	{if !$hide_DateAdded}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=DateAdded{$rev_DateAdded}">Date Applied</a></th>{/if}
	{if !$hide_DateLastChanged}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=DateLastChanged{$rev_DateLastChanged}">Last Checked</a></th>{/if}
	{if !$hide_DateToCheck}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=DateToCheck{$rev_DateToCheck}">Next Check</a></th>{/if}
	{if !$hide_JobTitle}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=JobTitle{$rev_JobTitle}">Job Title</a></th>{/if}
	{if !$hide_Company}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=Company{$rev_Company}">Company</a></th>{/if}
	{if !$hide_Location}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=Location{$rev_Location}">Location</a></th>{/if}
	{if !$hide_Reference}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=Reference{$rev_Reference}">Reference</a></th>{/if}
	{if !$hide_Agency}<th><a href="{$PHP_SELF}?{$ID_FIELD}order=Agency{$rev_Agency}">Agency</a></th>{/if}
	{if !$hide_Agent}<th>Agent</th>{/if}
	{if !$hide_Notes}<th>Notes</th>{/if}
	{if !$hide_Status}<th>Status</th>{/if}
</tr>
{section name=jobsec loop=$JobList}
{strip}
	<tr bgcolor="{cycle name="c1" values="#aaaaaa,#bbbbbb"}" onmouseover="setPointer(this, {$smarty.section.jobsec.index}, 'over', '{cycle name="c2" values="#aaaaaa,#bbbbbb"}', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, {$smarty.section.jobsec.index}, 'out', '{cycle name="c3" values="#aaaaaa,#bbbbbb"}', '#CCFFCC', '#FFCC99');" onmousedown="setPointer(this, {$smarty.section.jobsec.index}, 'click', '{cycle name="c4" values="#aaaaaa,#bbbbbb"}', '#CCFFCC', '#FFCC99'); document.location='jobdetail.php?ID={$JobList[jobsec].ID}'">
                <td nowrap="nowrap"><a href="jobdetail.php?ID={$JobList[jobsec].ID}">Detail</a></td>
		{if !$hide_DateAdded}
                  <td nowrap="nowrap">
                    {if $MARK_FAKE && $JobList[jobsec].Fake}
                      <font color="#ffffff">
                    {/if}
                        {$JobList[jobsec].DateAdded}
                    {if $MARK_FAKE && $JobList[jobsec].Fake}
                      </font>
                    {/if}
                  </td>
                {/if}
		{if !$hide_DateLastChanged}<td nowrap="nowrap">{$JobList[jobsec].DateLastChanged}</td>{/if}
		{if !$hide_DateToCheck}<td nowrap="nowrap">{$JobList[jobsec].DateToCheck}</td>{/if}
		{if !$hide_JobTitle}<td>{$JobList[jobsec].JobTitle}</td>{/if}
		{if !$hide_Company}<td><a href="companydetail.php?ID={$JobList[jobsec].Company_ID}">{$JobList[jobsec].Company}</a></td>{/if}
		{if !$hide_Location}<td>{$JobList[jobsec].Location}</td>{/if}
		{if !$hide_Reference}<td>{$JobList[jobsec].Reference}</td>{/if}
		{if !$hide_Agency}<td><a href="agencydetail.php?ID={$JobList[jobsec].Agency_ID}">{$JobList[jobsec].Agency}</a></td>{/if}
		{if !$hide_Agent}<td><a href="agentdetail.php?ID={$JobList[jobsec].Agent_ID}">{$JobList[jobsec].Agent}</a></td>{/if}
		{if !$hide_Notes}<td>{$JobList[jobsec].Notes}</td>{/if}
		{if !$hide_Status}<td>{$JobList[jobsec].Status}</td>{/if}
	</tr>
{/strip}
{/section}
</table>

{else}
  <em>--- No Jobs Found ---</em>
{/if}

<center>
{if ($start_prev ne "")}
	(<a href="{$PHP_SELF}?{$ID_FIELD}order={$order}&start={$start_prev}{$decrement}">Previous</a>)
{/if}
{$first_record}-{$last_record}/{$total_record}
{if ($start_next ne"")}
	(<a href="{$PHP_SELF}?{$ID_FIELD}order={$order}&start={$start_next}{$decrement}">Next</a>)
{/if}
</center>
