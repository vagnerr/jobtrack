<!-- $Id: add.tpl,v 1.1.1.1 2003/06/02 21:40:11 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}

<script src="/smarty_datepick/javascripts/datepick.js" language="javascript"></script>
<h1>Add New Job</h1>

<form name="add" action="add.php" method="get">
<center><input type="submit" name="submit"  value="Submit New Job"></center>
<table border="0">
{if $MARK_FAKE}
  <tr>
    <td align="right"><strong>Fake</strong></td>
    <td>
      <input type="checkbox" name="Fake" value="1">
    </td>
  </tr>
{else}
  <input type="hidden" name="Fake" value="0">
{/if}
<tr>
  <td align="right"><strong>Date Applied/LastChecked</strong></td>
  <td>
    <input type="text" name="DateAdded" size="10">{datepick form="add" field="DateAdded"}
  </td>
</tr>
<tr>
  <td align="right"><strong>Next Check</strong></td>
  <td>
    <input type="text" name="DateToCheck" size="10">{datepick form="add" field="DateToCheck"}
    (<select name="NextAction_ID">
       {section name=action loop=$NextActionList}
       {strip}
         <option value="{$NextActionList[action].ID}">
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
    <input type="text" name="DateOfInterview" size="18">{datepick form="add" field="DateOfInterview"}
  </td>
</tr>
<tr>
  <td align="right"><strong>Status</strong></td>
  <td>
       <select name="Status_ID">
       {section name=status loop=$StatusList}
       {strip}
         <option value="{$StatusList[status].ID}">
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
        <option value="{$TypeList[type].ID}">
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
    <input type="text" name="Salary" value="{$salary}" size="10">
  </td>
</tr>
<tr>
  <td align="right"><strong>Source</strong></td>
  <td>
    <select name="Source_ID">
      {section name=source loop=$SourceList}
      {strip}                                                       
        <option value="{$SourceList[source].ID}">
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
    <input type="text" name="JobTitle" size="60">
  </td>
</tr>
<tr>
  <td align="right"><strong>Company</strong></td>
  <td>
    <input type="text" name="NewCompany" size="30">
  </td>
</tr>
<tr>
  <td align="right"><strong>Location</strong></td>
  <td>
    <select name="Location_ID">
      {section name=location loop=$LocationList}
      {strip}                                                       
        <option value="{$LocationList[location].ID}">
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
    <input type="text" name="Reference" size="60">
  </td>
</tr>


<tr>
  <td align="right"><strong>Agency</strong></td>
  <td>
    <select name="Agency_ID">
      {section name=agency loop=$AgencyList}
      {strip}                                                       
        <option value="{$AgencyList[agency].ID}">
          {$AgencyList[agency].Name}
        </option>
      {/strip}
      {/section}
      <option value="-1">-New-</option>
    </select>
    <input type="text" name="NewAgency" size="30">
  </td>
</tr>


</table>
<center><input type="submit" name="submit" value="Submit New Job"></center>
</form>

{include file="skin:footer.tpl"}		
