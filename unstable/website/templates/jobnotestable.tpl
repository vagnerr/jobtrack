<!-- $Id: jobnotestable.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

<table border = "0">
<tr><th>Date</th><th>Note</th><th>Agent</th></tr>
{section name=note loop=$JobNotesList}
{strip}
<tr bgcolor="{cycle name="c1" values="#aaaaaa,#dddddd"}">
  <td nowrap="nowrap" align="right" valign="top">{$JobNotesList[note].AddDate}</td>
  <td valign="top">{$JobNotesList[note].Data}</td>
  <td nowrap="nowrap" valign="top"><a href="agentdetail.php?ID={$JobNotesList[note].Agent_ID}">{$JobNotesList[note].AgentName}</a></td>
</tr>

{/strip}
{/section}
<tr>
<td colspan="2">
<table border="0"><tr><td>
  <form name="addnote" action="addnote.php">
    <input type="hidden" name="ID" value="{$ID}">
     <td valign="top" nowrap="nowrap">
       <input type="text" name="AddDate" size="10">
       <a href="javascript:;" onclick="document.forms['addnote'].AddDate.value=getNow()">Now</a><br />
       
       <select name="NextCheck">
         <option value="0">Today</option>
         <option value="1">1 Day</option>
         <option value="2">2 Days</option>
         <option value="3">3 Days</option>
         <option value="4">4 Days</option>
         <option value="5">5 Days</option>
         <option value="6">6 Days</option>
         <option value="7" SELECTED>7 Days</option>
         <option value="8">8 Days</option>
         <option value="9">9 Days</option>
         <option value="10">10 Days</option>
         <option value="11">11 Days</option>
         <option value="12">12 Days</option>
         <option value="13">13 Days</option>
         <option value="14">14 Days</option>
         <option value="-1">Never</option>
       </select>
       <select name="NextAction_ID">
       {section name=action loop=$NextActionList}
       {strip}
         <option value="{$NextActionList[action].ID}">
           {$NextActionList[action].Description}
         </option>
       {/strip}
       {/section}
       </select>
<br />
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
     <td><textarea cols="60" rows="4" name="Data"></textarea></td>
</table>
</tr>
</td>
     <td valign="top">
       <select name="Agent_ID">
         <option value="0">-None-</option>
         {section name=agent loop=$AllAgentList}
         {strip}
           <option value="{$AllAgentList[agent].ID}" {if $AllAgentList[agent].ID == $PrimaryAgentID}SELECTED{/if}>
             {$AllAgentList[agent].Name}
           </option>
         {/strip}
         {/section}
         <option value="-1">-New-</option>
       </select>
       <input type="text" name="NewAgentName" size="10">
       <input type="submit" name="submit" value="Add Note">
     </td>
  </form>
</tr>
</table>
