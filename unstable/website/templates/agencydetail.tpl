<!-- $Id: agencydetail.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

<form name="agencyform" action="updateagencydetails.php">
<input type="hidden" name="ID" value="{$ID}">
<strong>Agency Name:</strong>
	<input type="text" name="Name" value="{$Name}" size="30">
	<input type="submit" name="submit" value="Change">
<h2>Contacts</h2>
<input type="hidden" name="WhichContactID" value="0">
<table border="0">
  {section name=contact loop=$AgencyContactList}
    <tr>
      <td>
        <input type="text" 
               name="ContactData-{$AgencyContactList[contact].ID}"
               value="{$AgencyContactList[contact].Data}" size="50">
      </td>
      <td align="left" valign="top">
        <select name="ContactType_ID-{$AgencyContactList[contact].ID}">
          {section name=ctype loop=$ContactTypeList}
            <option value="{$ContactTypeList[ctype].ID}" 
              {if $ContactTypeList[ctype].ID == 
                   $AgencyContactList[contact].ContactType_ID}SELECTED{/if}>
              {$ContactTypeList[ctype].Description}
            </option>
          {/section}
        </select>
      </td>
      <td>
        <input type="submit" name="submit" value="Edit"
                onclick="document.forms['agencyform'].WhichContactID.value={$AgencyContactList[contact].ID};" >
      </td>
      <td>
        <input type="submit" name="submit" value="Remove"
                onclick="document.forms['agencyform'].WhichContactID.value={$AgencyContactList[contact].ID};" >
      </td>
      <td>
        {if $AgencyContactList[contact].Keyword=="EMAIL"}
          <a href="mailto:{$AgencyContactList[contact].Data}">Send Email</a>
        {elseif $AgencyContactList[contact].Keyword=="URL"}
          <a href="{$AgencyContactList[contact].Data}">Visit URL</a>
        {/if}
      </td>
    </tr>
  {/section}                                                    
  <tr>                                                        
    <td>                                                      
      <input type="text" name="ContactData" size="50">        
    </td>                                                     
    <td align="left" valign="top">                            
      <select name="ContactType_ID">                             
        {section name=ctype loop=$ContactTypeList}            
          <option value="{$ContactTypeList[ctype].ID}">       
            {$ContactTypeList[ctype].Description}             
          </option>                                           
        {/section}                                            
      </select>                                               
    </td>                                                     
    <td>                                                      
      <input type="submit" name="submit" value="Add">         
    </td>                                                     
  </tr>
</table>
<h2>Agents</h2>
<ul>
{section name=agent loop=$AgentList}
	<li><a href="agentdetail.php?ID={$AgentList[agent].ID}">{$AgentList[agent].Name}</a>
	{section name=agentc loop=$AgentList[agent].ContactList}
		<br/>{$AgentList[agent].ContactList[agentc].Description} - 
		{if $AgentList[agent].ContactList[agentc].Keyword=="EMAIL"}
			<a href="mailto:{$AgentList[agent].ContactList[agentc].Data}">
		{elseif $AgentList[agent].ContactList[agentc].Keyword=="URL"}
			<a href="{$AgentList[agent].ContactList[agentc].Data}">
		{/if}
		{$AgentList[agent].ContactList[agentc].Data}
		{if $AgentList[agent].ContactList[agentc].Keyword=="EMAIL" ||
			$AgentList[agent].ContactList[agentc].Keyword=="URL"}
			</a>
		{/if}
	{/section}
{/section}
</ul>  
<h2>Jobs From This Agency</h2>
{include file="skin:jobtable.tpl"}

{include file="skin:footer.tpl"}		
