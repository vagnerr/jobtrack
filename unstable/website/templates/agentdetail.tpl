<!-- $Id: agentdetail.tpl,v 1.1.1.1 2003/06/02 21:40:22 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

<form name="agentform" action="updateagentdetails.php">
<input type="hidden" name="ID" value="{$ID}">
<strong>Agent Name:</strong>
	<input type="text" name="Name" value="{$Name}" size="30">
	<input type="submit" name="submit" value="Change">
<h2>Contacts</h2>

<input type="hidden" name="WhichContactID" value="0">
<table border="0">
  {section name=contact loop=$AgentContactList}
    <tr>
      <td>
        <input type="text" 
               name="ContactData-{$AgentContactList[contact].ID}"
               value="{$AgentContactList[contact].Data}" size="50">
      </td>
      <td align="left" valign="top">
        <select name="ContactType_ID-{$AgentContactList[contact].ID}">
          {section name=ctype loop=$ContactTypeList}
            <option value="{$ContactTypeList[ctype].ID}" 
              {if $ContactTypeList[ctype].ID == 
                   $AgentContactList[contact].ContactType_ID}SELECTED{/if}>
              {$ContactTypeList[ctype].Description}
            </option>
          {/section}
        </select>
      </td>
      <td>
        <input type="submit" name="submit" value="Edit"
                onclick="document.forms['agentform'].WhichContactID.value={$AgentContactList[contact].ID};" >
      </td>
      <td>
        <input type="submit" name="submit" value="Remove"
                onclick="document.forms['agentform'].WhichContactID.value={$AgentContactList[contact].ID};" >
      </td>
      <td>
        {if $AgentContactList[contact].Keyword=="EMAIL"}
          <a href="mailto:{$AgentContactList[contact].Data}">Send Email</a>
        {elseif $AgentContactList[contact].Keyword=="URL"}
          <a href="{$AgentContactList[contact].Data}">Visit URL</a>
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
</form>      
<h2>Agency</h2>
<ul>
	<li><a href="agencydetail.php?ID={$Agency.ID}">{$Agency.Name}</a>
	{section name=agencyc loop=$Agency.ContactList}
		<br/>{$Agency.ContactList[agencyc].Description} - 
		{if $Agency.ContactList[agencyc].Keyword=="EMAIL"}
			<a href="mailto:{$Agency.ContactList[agencyc].Data}">
		{elseif $Agency.ContactList[agencyc].Keyword=="URL"}
			<a href="{$Agency.ContactList[agencyc].Data}">
		{/if}
		{$Agency.ContactList[agencyc].Data}
		{if $Agency.ContactList[agencyc].Keyword=="EMAIL" ||
			$Agency.ContactList[agencyc].Keyword=="URL"}
			</a>
		{/if}
	{/section}
</ul>  
<h2>Jobs From This Agent</h2>
{include file="skin:jobtable.tpl"}

{include file="skin:footer.tpl"}		
