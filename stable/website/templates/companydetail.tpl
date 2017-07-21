<!-- $Id: companydetail.tpl,v 1.1.1.1 2003/06/02 21:35:36 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

{include file="skin:header.tpl"}
<h1>{$PageTitle}</h1>

<form name="companyform" action="updatecompanydetails.php">
<input type="hidden" name="ID" value="{$ID}">
<strong>Company Name:</strong>
	<input type="text" name="Name" value="{$Name}" size="30">
	<input type="submit" name="submit" value="Change">
<h2>Contacts</h2>
<input type="hidden" name="WhichContactID" value="0">
<table border="0">
  {section name=contact loop=$CompanyContactList}
    <tr>
      <td>
        <input type="text" 
               name="ContactData-{$CompanyContactList[contact].ID}"
               value="{$CompanyContactList[contact].Data}" size="50">
      </td>
      <td align="left" valign="top">
        <select name="ContactType_ID-{$CompanyContactList[contact].ID}">
          {section name=ctype loop=$ContactTypeList}
            <option value="{$ContactTypeList[ctype].ID}" 
              {if $ContactTypeList[ctype].ID == 
                   $CompanyContactList[contact].ContactType_ID}SELECTED{/if}>
              {$ContactTypeList[ctype].Description}
            </option>
          {/section}
        </select>
      </td>
      <td>
        <input type="submit" name="submit" value="Edit"
		onclick="document.forms['companyform'].WhichContactID.value={$CompanyContactList[contact].ID};" >
      </td>
      <td>
        <input type="submit" name="submit" value="Remove"
                onclick="document.forms['companyform'].WhichContactID.value={$CompanyContactList[contact].ID};" >
      </td>
      <td>
        {if $CompanyContactList[contact].Keyword=="EMAIL"}
          <a href="mailto:{$CompanyContactList[contact].Data}">Send Email</a>
        {elseif $CompanyContactList[contact].Keyword=="URL"}
          <a href="{$CompanyContactList[contact].Data}">Visit URL</a>
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
<h2>Jobs at this Company</h2>
{include file="skin:jobtable.tpl"}

{include file="skin:footer.tpl"}		
