<!-- $Id: jobdetail.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}

<script src="libraries/functions.js" type="text/javascript" language="javascript"></script>
<script src="/smarty_datepick/javascripts/datepick.js" language="javascript"></script>
<h1>Jobs Detail</h1>

<form name="jobdetail" action="setjobdetails.php" method="get">
<input type="hidden" name="ID" value="{$ID}">
{if $MARK_FAKE && $Fake}
  <center><font color=#FF0000><hr>-----Fake-----<hr></font></center>
{/if}
<center><input type="submit" value="Submit Job Changes"></center>
<table border="0">
{if $MARK_FAKE}
  <tr>
    <td align="right"><strong>Fake</strong></td>
    <td>
      <input type="checkbox" name="Fake" value="1" {if $Fake}CHECKED{/if}>
    </td>
  </tr>
{else}
  <input type="hidden" name="Fake" value="{$Fake}">
{/if}
<tr><td align="right"><strong>Date Applied</strong></td><td>{$DateAdded}</td></tr>
<tr><td align="right"><strong>Last Checked</strong></td><td>{$DateLastChanged}</td></tr>
<tr>
  <td align="right"><strong>Next Check</strong></td>
  <td>
    <input type="text" name="DateToCheck" value="{$DateToCheck}" size="10">{datepick form="jobdetail" field="DateToCheck"}
    (<select name="NextAction_ID">
       {section name=action loop=$NextActionList}
       {strip}
         <option value="{$NextActionList[action].ID}" {if $NextActionList[action].ID == $NextAction_ID}SELECTED{/if}>
           {$NextActionList[action].Description}
         </option>
       {/strip}
       {/section}
       </select>)
  </td>
</tr>
<tr>
  <td align="right"><strong>Interview Date</strong></td>
  <td>
    <input type="text" name="DateOfInterview" value="{$DateOfInterview}" size="18">{datepick form="jobdetail" field="DateOfInterview"}
  </td>
</tr>
<tr>
  <td align="right"><strong>Status</strong></td>
  <td>
       <select name="Status_ID">
       {section name=status loop=$StatusList}
       {strip}
         <option value="{$StatusList[status].ID}" {if $StatusList[status].ID == $Status_ID}SELECTED{/if}>
           {$StatusList[status].Description}
         </option>
       {/strip}
       {/section}
       </select>
  </td>
</tr>
<tr>
  <td align="right"><strong>Type</strong></td>
  <td>
    <select name="Type_ID">
      {section name=type loop=$TypeList}
      {strip}
        <option value="{$TypeList[type].ID}" {if $TypeList[type].ID == $Type_ID}SELECTED{/if}>
          {$TypeList[type].Description}
        </option>
      {/strip}
      {/section}
    </select>
  </td>
</tr>
<tr>
  <td align="right"><strong>Salary</strong></td>
  <td>
    <input type="text" name="Salary" value="{$Salary}" size="10">
  </td>
</tr>
<tr>
  <td align="right"><strong>Source</strong></td>
  <td>
    <select name="Source_ID">
      {section name=source loop=$SourceList}
      {strip}                                                       
        <option value="{$SourceList[source].ID}" {if $SourceList[source].ID == $Source_ID}SELECTED{/if}>
          {$SourceList[source].Description}
        </option>
      {/strip}
      {/section}
      <option value="-1">-New-</option>
    </select>
    <input type="text" name="NewSource" size="15">
  </td>
</tr>
<tr>
  <td align="right"><strong>Job Title</strong></td>
  <td>
    <input type="text" name="JobTitle" value="{$JobTitle}" size="60">
  </td>
</tr>
<tr>
  <td align="right"><strong>Company</strong></td>
  <td>
    {if $CompanyName}
      <a href="companydetail.php?ID={$Company_ID}">{$CompanyName}</a>
      (<a href="removecompany.php?ID={$ID}&Company_ID={$Company_ID}">-</a>)
    {else}
      <input type="text" name="CompanyName" size="30">
    {/if}
  </td>
</tr>
<tr>
  <td align="right"><strong>Location</strong></td>
  <td>
    <select name="Location_ID">
      {section name=location loop=$LocationList}
      {strip}                                                       
        <option value="{$LocationList[location].ID}" {if $LocationList[location].ID == $Location_ID}SELECTED{/if}>
          {$LocationList[location].Value}
        </option>
      {/strip}
      {/section}
      <option value="-1">-New-</option>
    </select>
    <input type="text" name="NewLocation" size="15">
    
  </td>
</tr>
<tr>
  <td align="right"><strong>Reference</strong></td>
  <td>
    <input type="text" name="Reference" value="{$Reference}" size="60">
  </td>
</tr>
<tr><td align="right"><strong>Agency</strong></td><td><a href="agencydetail.php?ID={$Agency_ID}">{$AgencyName}</a></td></tr>
<tr>
  <td align="right" valign="top"><strong>Agent(s)</strong></td>
  <td>
    {section name=agent loop=$AgentList}
    {strip}
      <input type="radio" name="PrimaryAgent" value="{$AgentList[agent].ID}" {if $smarty.section.agent.first} CHECKED{/if}>
      <a href="agentdetail.php?ID={$AgentList[agent].ID}">{$AgentList[agent].Name}</a>
      <br/>
    {/strip}
    {/section}
    <input type="text" name="NewAgentName" size="20">
    {if $NewAgentList}
      <select name="NewAgentID">
        <option value="0" CHECKED></option>
        {section name=newagent loop=$NewAgentList}
        {strip}
          <option value="{$NewAgentList[newagent].ID}">
            {$NewAgentList[newagent].Name}
          </option>
        {/strip}
        {/section}
      </select>
    {/if}
  </td>
</tr>
<tr><td align="right"><strong>Notes</strong></td><td>{$NoteCount}</td></tr>
<tr>
  <td align="right" valign="top"><strong>Keywords</strong></td>
  <td>
    {section name=keyword loop=$KeywordList}
    {strip}
      <a href="keyworddetail.php?ID={$KeywordList[keyword].ID}">
        {$KeywordList[keyword].Keyword}
      </a>
      (<a href="removekeyword.php?ID={$ID}&KeywordID={$KeywordList[keyword].ID}">
        -
      </a>)
      {if ! $smarty.section.keyword.last}
	&nbsp;,&nbsp;
      {/if}
    {/strip}
    {/section}
    <input type="text" name="NewKeyword" size="15">
  </td>
</tr>
<tr>
  <td align="right" valign="top"><strong>Related</strong></td>
  <td>
    {section name=relate loop=$JobRelatedList}
    {strip}
      <a href="jobdetail.php?ID={$JobRelatedList[relate].Related_ID}">
        {$JobRelatedList[relate].Description}
      </a> 
      (<a href="removerelation.php?ID={$ID}&RelationID={$JobRelatedList[relate].ID}">
        -
      </a>)
      {if ! $smarty.section.relate.last}
	&nbsp;,&nbsp;
      {/if}
    {/strip}
    {/section}
    (
      <input type="text" name="NewRelationID" size="4">-
      <input type="text" name="NewRelationDescription" size="10">
    )
  </td>
</tr>
<tr>
  <td align="right" valign="top"><strong>Data</strong></td>
  <td>
    {section name=jobdat loop=$JobDataList}
    {strip}
      <a href="jobdata.php?ID={$JobDataList[jobdat].ID}">
        {$JobDataList[jobdat].Description}
      </a>
      ({$JobDataList[jobdat].Type})
      (<a href="deletedata.php?ID={$ID}&DataID={$JobDataList[jobdat].ID}">
        -
      </a>)
      <br />
    {/strip}
    {/section}
    <a href="adddata.php?JobID={$ID}">(--Add New Data--)</a>
  </td>
</tr>
</table>
<center><input type="submit" value="Submit Job Changes"></center>
</form>

{if $MARK_FAKE && $Fake}
  <center><font color=#FF0000><hr>-----Fake-----<hr></font></center>
{/if}
<h2> Notes </h2>

{include file="skin:jobnotestable.tpl"}

{if $MARK_FAKE && $Fake}
  <center><font color=#FF0000><hr>-----Fake-----<hr></font></center>
{/if}
{include file="skin:footer.tpl"}		
